<?php

namespace App\Controllers\api;

use App\Libraries\ApiService;
use App\Libraries\Portal;

class Event extends BaseController {
    public function jobDaily() {
        $result = $this->update_statment();
        return $this->response(isset($result->data) ? $result->data : null, $result->message);
    }
    protected function update_statment() {
        $body = [
            'web' => session()->web,
            'webuser' => session()->webuser,
        ];
        $service = new ApiService();
        $history = $service->history($body);
        if (!$history->status) return (object)["message" => $history->msg, "status" => false];
        if (!$history->data) return (object)["message" => "No Transactions.", "status" => true];

        return update_statement($history->data);

        // $portal = new Portal();
        // $wheel = $portal->wheel();
        // if (!$wheel->status) return (object)["message" => $wheel->message, "status" => false];

        // $checkin = $portal->checkin();
        // if (!$checkin->status) return (object)["message" => $checkin->message, "status" => false];

        // foreach ($history->data as $data) {
        //     if ($data->type != "ฝาก") continue;
        //     if ($data->status != "Y") continue;
        //     $date = date("Y-m-d", strtotime($data->date));
        //     if ($date < "2024-01-01") continue;
        //     if (intval($data->amount) >= $wheel->data->deposit_rule) {
        //         $addable = $portal->wheeldaily_addable([
        //             "checkin" => $checkin->data->id,
        //             "user" => session()->webuser,
        //             "date" => $date,
        //         ]);
        //         if (!$addable->status) continue;
        //         if (!$addable->data) continue;
        //         $daily = array(
        //             "wheel" => $wheel->data->id,
        //             "user" => $data->userid,
        //             "date" => $date,
        //             "add_by" => session()->webuser,
        //         );
        //         $portal->wheeldaily_add($daily);
        //     }
        //     if (intval($data->amount) >= $checkin->data->deposit_rule) {
        //         $usable = $portal->checkindaily_usable([
        //             "checkin" => $checkin->data->id,
        //             "user" => session()->webuser,
        //             "date" => $date,
        //         ]);
        //         if (!$usable->status) continue;
        //         if (!$usable->data) continue;
        //         $daily = array(
        //             "checkin" => $checkin->data->id,
        //             "user" => $data->userid,
        //             "date" => $date,
        //             "add_by" => session()->webuser,
        //         );
        //         $portal->checkindaily_add($daily);
        //     }
        // }
        // return (object)["data" => null, "message" => "Success !", "status" => true];
    }

    public function getCheckin() {
        $portal = new Portal();
        $checkin = $portal->checkin();
        if (!$checkin->status) return $this->response(null, $checkin->message, false);
        $checkin = (object)[
            "checkin" => $checkin->data->id,
            "title" => $checkin->data->title,
            "detail" => $checkin->data->detail, 
            "progresses" => [],
        ];
        $progress = $portal->progress_list($checkin);
        if (!$progress->status) return $this->response(null, $progress->message, false);
        foreach ($progress->data as $data) {
            $checkin->progresses[] = [
                "index" => $data->index,
                "title" => $data->title,
                "type" => $data->type,
                "value" => $data->value,
            ];
        }
        unset($checkin->key);
        unset($checkin->secret);
        return $this->response($checkin);
    }
    public function getCheckinList() {
        $body = $this->getPost();
        $portal = new Portal();
        $checkin = $portal->checkindaily_list([
            "user" => session()->webuser,
            "checkin" => $body->checkin,
            "date" => date("Y-m-d"),
        ]);
        if (!$checkin->status) return $this->response(null, $checkin->message, false);

        $usable = $portal->checkindaily_usable([
            "user" => session()->webuser,
            "checkin" => $body->checkin,
            "date" => date("Y-m-d"),
        ]);
        if (!$usable->status) return $this->response(null, $usable->message, false);

        return $this->response([
            "checked" => $checkin->data,
            "checkable" => $usable->data,
        ]);
    }
    public function getCheckinHistories() {
        $body = $this->getPost();
        $portal = new Portal();
        $histories = $portal->checkindaily_history(["user" => session()->webuser, "checkin" => $body->checkin]);
        if (!$histories->status) return $this->response(null, $histories->message, false);
        usort($histories->data, fn ($a, $b) => $a->date_use < $b->date_use);
        $result = [];
        foreach ($histories->data as $his) {
            if (empty($his->date_use)) continue;
            $result[] = [
                "id" => $his->id,
                "checkin" => $his->checkin,
                "title" => $his->title,
                "type" => $his->type,
                "value" => $his->value,
                "status" => empty($his->date_claim) ? "CLAIMABLE" : "CLAIMED",
                "status_text" => empty($his->date_claim) ? lang("Lang.checkin.CLAIMABLE") : lang("Lang.checkin.CLAIMED"),
                // "date" => empty($his->date_claim) ? $his->date_use : $his->date_claim,
                "date" => $his->date_use,
            ];
        }
        return $this->response($result);
    }
    public function getCheckinClaim() {
        $body = $this->getPost();
        $portal = new Portal();
        $checkinDaily = $portal->checkindaily_info(["user" => session()->webuser, "checkin" => $body->checkin, "id" => $body->id]);
        if (!$checkinDaily->status) return $this->response(null, $checkinDaily->message, false);

        $service = new ApiService();
        $bonus = $service->add_bonus([
            "user" => session()->userid,
            "token" => session()->token,
            "web" => session()->web,
            "webuser" => session()->webuser,
            "amount" => $checkinDaily->data->value,
            "bonustxt" => "Checkin Daily",
            "turnover" => $checkinDaily->data->value,
        ]);
        if (!$bonus->status) return $this->response(null, $bonus->msg, false);

        $claim = $portal->checkindaily_claim([
            "id" => $checkinDaily->data->id,
            "checkin" => $checkinDaily->data->checkin,
            "user" => session()->webuser,
            "edit_by" => session()->webuser,
        ]);
        if (!$claim->status) return $this->response(null, $claim->message, false);

        return $this->response();
    }
    public function getCheckinClaimAll() {
        $body = $this->getPost();
        $portal = new Portal();
        $histories = $portal->checkindaily_claimable(["user" => session()->webuser, "checkin" => $body->checkin]);
        if (!$histories->status) return $this->response(null, $histories->message, false);
        if (!$histories->data) return $this->response(null, "Can't claim !", false);

        $bonus = 0;
        $claimed = [];
        foreach ($histories->data as $item) {
            if ($item->type != "CREDIT") continue;
            if (!$item->value) continue;

            $claim = $portal->checkindaily_claim([
                "id" => $item->id,
                "checkin" => $item->checkin,
                "user" => session()->webuser,
                "edit_by" => session()->webuser,
            ]);
            if (!$claim->status) continue;

            $claimed[] = $item;
            $bonus += $item->value;
        }
        if (!$bonus) return $this->response(null, "Can't claim !", false);

        $service = new ApiService();
        $bonus = $service->add_bonus([
            "user" => session()->userid,
            "token" => session()->token,
            "web" => session()->web,
            "webuser" => session()->webuser,
            "amount" => sprintf("%0.2f", $bonus),
            "bonustxt" => "Checkin Daily",
            "turnover" => sprintf("%0.2f", $bonus),
        ]);
        if ($bonus->status) return $this->response();

        foreach ($claimed as $item) {
            $portal->checkindaily_unclaim([
                "id" => $item->id,
                "checkin" => $item->checkin,
                "user" => session()->webuser,
                "edit_by" => session()->webuser,
            ]);
        }

        return $this->response(null, $bonus->msg, false);
    }

    public function getWheel() {
        $portal = new Portal();
        $wheel = $portal->wheel();
        if (!$wheel->status) return $this->response(null, $wheel->message, false);
        $wheel = (object)[
            "wheel" => $wheel->data->id,
            "title" => $wheel->data->title,
            "detail" => $wheel->data->detail,
            "segments" => [],
        ];
        $segment = $portal->segment_list($wheel);
        if (!$segment->status) return $this->response(null, $segment->message, false);
        foreach ($segment->data as $data) {
            $wheel->segments[] = [
                "index" => $data->index,
                "text" => $data->title,
                "fillStyle" => $data->hex,
                "image" => $data->image,
            ];
        }
        unset($wheel->key);
        unset($wheel->secret);
        return $this->response($wheel);
    }
    public function getWheelUsable() {
        $body = $this->getPost();
        $portal = new Portal();
        $canroll = $portal->wheeldaily_usable(["user" => session()->webuser, "wheel" => $body->wheel]);
        if (!$canroll->status) return $this->response(null, $canroll->message, false);

        return $this->response(count($canroll->data));
    }
    public function getWheelRoll() {
        $body = $this->getPost();
        $portal = new Portal();
        $canroll = $portal->wheeldaily_usable(["user" => session()->webuser, "wheel" => $body->wheel]);
        if (!$canroll->status) return $this->response(null, $canroll->message, false);
        if (!count($canroll->data)) return $this->response(null, "Can't roll", false);

        $roll = $portal->wheel_roll(["id" => $body->wheel]);
        if (!$roll->status) return $this->response(null, $roll->message, false);

        $body = [
            "user" => session()->webuser,
            "wheel" => $roll->data->wheel,
            "segment" => $roll->data->id,
            "title" => $roll->data->title,
            "type" => $roll->data->type,
            "value" => $roll->data->value,
            "rate" => $roll->data->rate,
            "rate_min" => $roll->data->rate_min,
            "rate_max" => $roll->data->rate_max,
            "lucky_number" => $roll->data->lucky_number,
            "edit_by" => session()->webuser,
        ];
        $dailyroll = $portal->wheeldaily_roll($body);
        if (!$dailyroll->status) return $this->response(null, $dailyroll->message, false);

        $result = [
            "index" => $roll->data->index,
            "title" => $roll->data->title,
        ];
        return $this->response($result);

        // if ($roll->data->type != "CREDIT") return $this->response($result);

        // $service = new ApiService();
        // $bonus = $service->add_bonus([
        //     "user" => session()->userid,
        //     "token" => session()->token,
        //     "web" => session()->web,
        //     "webuser" => session()->webuser,
        //     "amount" => $roll->data->value,
        //     "bonustxt" => "Lucky Wheel",
        //     "turnover" => $roll->data->value,
        // ]);
        // if (!$bonus->status) return $this->response($result);

        // $claim = $portal->wheeldaily_claim([
        //     "id" => $dailyroll->data->id,
        //     "wheel" => $dailyroll->data->wheel,
        //     "user" => session()->webuser,
        //     "edit_by" => session()->webuser,
        // ]);
        // if (!$claim->status) return $this->response($result);

        // return $this->response($result);
    }
    public function getWheelHistories() {
        $body = $this->getPost();
        $portal = new Portal();
        $histories = $portal->wheeldaily_history(["user" => session()->webuser, "wheel" => $body->wheel]);
        if (!$histories->status) return $this->response(null, $histories->message, false);
        usort($histories->data, fn ($a, $b) => $a->date_use < $b->date_use);
        $result = [];
        foreach ($histories->data as $his) {
            if (empty($his->date_use)) continue;
            $result[] = [
                "id" => $his->id,
                "wheel" => $his->wheel,
                "title" => $his->title,
                "type" => $his->type,
                "value" => $his->value,
                "status" => empty($his->date_claim) ? "CLAIMABLE" : "CLAIMED",
                "status_text" => empty($his->date_claim) ? lang("Lang.wheel.CLAIMABLE") : lang("Lang.wheel.CLAIMED"),
                // "date" => empty($his->date_claim) ? $his->date_use : $his->date_claim,
                "date" => $his->date_use,
            ];
        }
        return $this->response($result);
    }
    public function getWheelClaim() {
        $body = $this->getPost();
        $portal = new Portal();
        $wheelDaily = $portal->wheeldaily_info(["user" => session()->webuser, "wheel" => $body->wheel, "id" => $body->id]);
        if (!$wheelDaily->status) return $this->response(null, $wheelDaily->message, false);

        $service = new ApiService();
        $bonus = $service->add_bonus([
            "user" => session()->userid,
            "token" => session()->token,
            "web" => session()->web,
            "webuser" => session()->webuser,
            "amount" => $wheelDaily->data->value,
            "bonustxt" => "Lucky Wheel",
            "turnover" => $wheelDaily->data->value,
        ]);
        if (!$bonus->status) return $this->response(null, $bonus->msg, false);

        $claim = $portal->wheeldaily_claim([
            "id" => $wheelDaily->data->id,
            "wheel" => $wheelDaily->data->wheel,
            "user" => session()->webuser,
            "edit_by" => session()->webuser,
        ]);
        if (!$claim->status) return $this->response(null, $claim->message, false);

        return $this->response();
    }
    public function getWheelClaimAll() {
        $body = $this->getPost();
        $portal = new Portal();
        $histories = $portal->wheeldaily_claimable(["user" => session()->webuser, "wheel" => $body->wheel]);
        if (!$histories->status) return $this->response(null, $histories->message, false);
        if (!$histories->data) return $this->response(null, "Can't claim !", false);

        $bonus = 0;
        $claimed = [];
        foreach ($histories->data as $item) {
            if ($item->type != "CREDIT") continue;
            if (!$item->value) continue;

            $claim = $portal->wheeldaily_claim([
                "id" => $item->id,
                "wheel" => $item->wheel,
                "user" => session()->webuser,
                "edit_by" => session()->webuser,
            ]);
            if (!$claim->status) continue;

            $claimed[] = $item;
            $bonus += $item->value;
        }
        if (!$bonus) return $this->response(null, "Can't claim !", false);

        $service = new ApiService();
        $bonus = $service->add_bonus([
            "user" => session()->userid,
            "token" => session()->token,
            "web" => session()->web,
            "webuser" => session()->webuser,
            "amount" => sprintf("%0.2f", $bonus),
            "bonustxt" => "Lucky Wheel",
            "turnover" => sprintf("%0.2f", $bonus),
        ]);
        if ($bonus->status) return $this->response();

        foreach ($claimed as $item) {
            $portal->wheeldaily_unclaim([
                "id" => $item->id,
                "wheel" => $item->wheel,
                "user" => session()->webuser,
                "edit_by" => session()->webuser,
            ]);
        }

        return $this->response(null, $bonus->msg, false);
    }

    public function getLottoList() {
        $Portal = new Portal();
        $lotto = $Portal->lotto_list();
        return $this->response($lotto->data, $lotto->message, $lotto->status);
    }
    public function getLottoInfo() {
        $body = $this->getPost();
        $Portal = new Portal();
        $info = $Portal->lotto_info(["lotto" => $body->lotto, "webuser" => session()->webuser]);
        return $this->response($info->data, $info->message, $info->status);
    }
    public function getLottoHistory() {
        $Portal = new Portal();
        $history = $Portal->lotto_history(["webuser" => session()->webuser]);
        return $this->response($history->data, $history->message, $history->status);
    }
    public function getLottoNumberList() {
        $body = $this->getPost();
        $Portal = new Portal();
        $number = $Portal->lotto_number_list(["lotto" => $body->lotto, "webuser" => session()->webuser]);
        return $this->response($number->data, $number->message, $number->status);
    }
    public function getLottoNumberBuy() {
        $body = $this->getPost();
        $Portal = new Portal();
        $number = $Portal->lotto_number_buy([
            "lotto" => $body->lotto,
            "webuser" => session()->webuser,
            "webpass" => session()->webpass,
            "tel" => session()->username,
            "no" => $body->no,
        ]);
        return $this->response($number->data, $number->message, $number->status);
    }
}

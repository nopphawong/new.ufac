<?php

/**
 * Custom Function.
 */

use App\Libraries\Portal;
use PhpParser\Node\Stmt\Return_;

/**
 * This is Function Trim and Replace.
 * @param array|string $search 
 * The value being searched for, otherwise known as the needle. An array may be used to designate multiple needles.
 * @param array|string $replace 
 * The replacement value that replaces found search values. An array may be used to designate multiple replacements.
 * @param array|string $subject 
 * The string or array being searched and replaced on, otherwise known as the haystack.
 */
function trimReplace($search, $replace, $subject): string
{
    return trim(str_replace($search, $replace, $subject));
}

function transformAuthData($data): object
{
    $index = array_search('UFA', array_column($data->weblists, 'webag'));
    $bank = explode('-', $data->bank);
    $newData = [
        'userid' => $data->userid,
        'name' => $data->name,
        'tel' => $data->tel,
        'email' => $data->email,
        'lineid' => $data->lineid,
        'bankid' => $bank[0],
        'bankno' => $bank[1],
        'token' => $data->token,
        'webbalance' => 0,
    ];

    $result = (object) array_merge(
        (array) $newData,
        (array) $data->weblists[$index]
    );
    unset($result->weblists);
    return $result;
}

function update_statement($history = array(), $all = false)
{
    if (!is_array($history)) return (object)["message" => "Invalid transactions !", "status" => false];
    $portal = new Portal();
    $wheel = $portal->wheel();
    if (!$wheel->status) return (object)["message" => $wheel->message, "status" => false];

    $checkin = $portal->checkin();
    if (!$checkin->status) return (object)["message" => $checkin->message, "status" => false];

    foreach ($history as $data) {
        if ($data->type != "ฝาก") continue;
        if ($data->status != "Y") continue;
        $date = date("Y-m-d", strtotime($data->date));
        if ($date < "2024-01-01") continue;
        if (intval($data->amount) >= intval($wheel->data->deposit_rule)) {
            $addable = $portal->wheeldaily_addable([
                "checkin" => $checkin->data->id,
                "user" => session()->webuser,
                "date" => $date,
            ]);
            if ($addable->status && $addable->data) {
                $daily = array(
                    "wheel" => $wheel->data->id,
                    "user" => $data->userid,
                    "date" => $date,
                    "add_by" => session()->webuser,
                );
                $portal->wheeldaily_add($daily);
            }
        }
        if (intval($data->amount) >= intval($checkin->data->deposit_rule)) {
            $usable = $portal->checkindaily_usable([
                "checkin" => $checkin->data->id,
                "user" => session()->webuser,
                "date" => $date,
            ]);
            if ($usable->status && $usable->data) {
                $daily = array(
                    "checkin" => $checkin->data->id,
                    "user" => $data->userid,
                    "date" => $date,
                    "add_by" => session()->webuser,
                );
                $portal->checkindaily_add($daily);
            }
        }
        if (!$all) break;
    }
    return (object)["data" => null, "message" => "Success !", "status" => true];
}

<?php

namespace App\Controllers\api;

use App\Libraries\ApiService;

class Financial extends BaseController
{
    // remark  คือ remark ครับ
    // type 
    // 1=ฝาก
    // 2=ถอน
    // 3=เพิ่มโบนัส
    // 4=ลดโบนัส

    // status
    // Y=สำเร็จ
    // C=ยกเลิก
    // R=รอดำเนินการ
    public function getHistory()
    {
        $body = [
            'web' => session()->web,
            'webuser' => session()->webuser,
        ];
        $service = new ApiService();
        $result = $service->history($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($result->data, $result->msg);
    }

    public function getDepositAccount()
    {
        $body = [
            'user' => session()->userid,
            'web' => session()->web,
            'webuser' => session()->webuser,
        ];
        $service = new ApiService();
        $result = $service->get_deposit_account($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($result->data, $result->msg);
    }

    public function deposit()
    {
        $data = $this->getPost();
        $body = [
            'user' => session()->userid,
            'token' => session()->token,
            'web' => session()->web,
            'webuser' => session()->webuser,
            'amount' => $data->deposit_amount . '.00',
            'frombankid' => session()->bankid,
            'frombankno' => session()->bankno,
            'tobankid' => $data->tbankid,
            'tobankno' => $data->tbankno,
        ];
        $service = new ApiService();
        $result = $service->deposit($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($data, $result->msg);
    }

    public function depositQrCode()
    {
        $data = $this->getPost();
        $body = [
            'user' => session()->userid,
            'token' => session()->token,
            'web' => session()->web,
            'webuser' => session()->webuser,
            'amount' => $data->deposit_amount . '.00',
            'frombankid' => session()->bankid,
            'frombankno' => session()->bankno,
            'tobankid' => $data->tbankid,
            'tobankno' => $data->tbankno,
        ];
        $service = new ApiService();
        $result = $service->deposit_qr($body);
        if (!$result->status) {
            if ($result->msg == 'Waiting') return $this->response($result->data, $result->msg, false);
            return $this->response(null, $result->msg, false);
        }
        return $this->response($result, $result->msg);
    }

    public function withdraw()
    {
        $data = $this->getPost();
        $body = [
            'user' => session()->userid,
            'token' => session()->token,
            'web' => session()->web,
            'webuser' => session()->webuser,
            'amount' => $data->withdraw_amount . '.00',
        ];
        $service = new ApiService();
        $result = $service->withdraw($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($data, $result->msg);
    }
}

<?php

namespace App\Controllers\api;

use App\Libraries\ApiService;
use App\Libraries\Portal;

class Auth extends BaseController {
    public function login() {
        $data = $this->getPost();
        $credential = [
            'user' => $data->username,
            'pass' => $data->password,
        ];
        $service = new ApiService();
        $result = $service->login($credential);
        if (!$result->status) return $this->response(null, $result->msg, false);
        $data = transformAuthData($result->data);
        $ses_data = array_merge(
            (array) $data,
            ['logged_in' => TRUE],
        );
        session()->set($ses_data);
        
        // check and add old webuser
        $Portal = new Portal();
        $Portal->webuser_checkup([
            "webuser" => $data->webuser,
            "webpass" => $data->webpass,
            "tel" => $data->userid,
        ]);

        // $history = $service->history([
        //     'web' => session()->web,
        //     'webuser' => session()->webuser,
        // ]);
        // if (isset($history->data)) update_statement($history->data, true);

        return $this->response($result->data, $result->msg);
    }

    public function checkUserExits() {
        $data = $this->getPost();
        $body = [
            'user' => $data->username,
        ];
        $service = new ApiService();
        $result = $service->check_user_exits($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($data, $result->msg);
    }

    public function verifyBank() {
        $data = $this->getPost();
        $body = [
            'accno' => trimReplace('-', '', $data->account_number),
            'bankid' => trimReplace('-', '', $data->financial_id),
        ];
        $service = new ApiService();
        // check bank exits.
        $checked = $service->check_bank_exits($body);
        if (!$checked->status) return $this->response(null, $checked->msg, false);
        // get name from bank and bank account.
        $result = $service->verify_bank($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($result->data, $result->msg);
    }

    public function getWebUser() {
        $data = $this->getPost();
        $body = [
            'tel' => $data->username,
        ];
        $portal = new Portal();
        $result = $portal->webuser_register($body);
        if (!$result->status) return $this->response(null, $result->message, false);
        return $this->response($result->data, $result->message);
    }

    public function unlinkWebUser() {
        $data = $this->getPost();
        $body = [
            'tel' => $data->username,
            'web_username' => $data->web_username
        ];
        $portal = new Portal();
        $result = $portal->webuser_unlink($body);
        if (!$result->status) return $this->response(null, $result->message, false);
        return $this->response($result->data, $result->message);
    }

    public function register() {
        $data = $this->getPost();

        $ref_param = isset($data->reference) ? $data->reference : null;

        $body = [
            'user' => $data->username,
            'pass' => $data->password,
            'name' => $data->account_name,
            'bankid' => $data->financial_id,
            'bankno' => $data->account_number,
            'code' => $data->username,
            'otpcode' => '123456',
            'otpref' => 'PDFDA'
            // 'webuser' => $webuser->web_username,
            // 'webpass' => $webuser->web_password,
            // 'webag' => $webuser->web_agent,
            // "ref" => $webuser->chanel_ref,
            // "code_name" => $webuser->chanel_name,
        ];

        // GET WEB USER
        $portal = new Portal();
        $webuser = $portal->webuser_register(["tel" => $data->username, "ref" => $ref_param]);
        if (!$webuser->status) return $this->response(null, $webuser->message, false);
        $webuser = $webuser->data;

        $body["webuser"] = $webuser->web_username;
        $body["webpass"] = $webuser->web_password;
        $body["webag"] = $webuser->web_agent;
        if (isset($webuser->chanel_ref) && !empty($webuser->chanel_ref)) {
            $body["ref"] = $webuser->chanel_ref;
            $body["code_name"] = $webuser->chanel_name;
        }
        // 

        $service = new ApiService();
        $result = $service->register($body);
        if (!$result->status) {
            // UNLINK WEB USER
            $portal->webuser_unlink(["tel" => $data->username, "web_username" => $webuser->web_username]);
            return $this->response(null, $result->msg, false);
        }
        $service->send_telegram($body);
        return $this->response($result->data, $result->msg);
    }

    public function requestOtp() {
        $data = $this->getPost();
        $body = [
            'user' => $data->username
        ];
        $service = new ApiService();

        // STEP 1: Check User Exits. 
        $result = $service->check_user_exits($body);
        if ($result->status) return $this->response(null, $result->msg, false);

        // STEP 2: Requst OTP.
        $body = [
            'tel' => $data->username
        ];
        $result = $service->request_otp($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($result->data, $result->msg);
    }

    public function forgot() {
        $data = $this->getPost();
        $body = [
            'user' => $data->username,
            'otpref' => $data->otpref,
            'otpcode' => $data->otpcode,
            'pass' => $data->password,
        ];
        $service = new ApiService();
        $result = $service->forgot($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($data, $result->msg);
    }
}

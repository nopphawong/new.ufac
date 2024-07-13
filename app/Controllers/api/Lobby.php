<?php

namespace App\Controllers\api;

use App\Libraries\ApiService;
use DOMDocument;
use DOMXPath;

class Lobby extends BaseController {
    public function getLobby() {
        // Get info.
        // $body = [
        //     'user' => session()->userid,
        //     'token' => session()->token,
        // ];

        // $service = new ApiService();
        // $result = $service->get_info($body);
        // if (!$result->status) return $this->response(null, $result->msg, false);
        // $data = transformAuthData($result->data);
        // session()->set((array) $data);

        // Get Balance.
        $body = [
            'user' => session()->userid,
            'token' => session()->token,
            'web' => session()->web,
            'webuser' => session()->webuser,
        ];
        $service = new ApiService();
        $result = $service->get_balance($body);
        if (!$result->status) {
            // NOTE: Check has webuser (frist login).
            if ($result->msg == 'webuser not found') return $this->response(null, $result->msg);
            return $this->response(null, $result->msg, false);
        }
        session()->set(['webbalance' => $result->data->webbalance]);
        return $this->response($result->data, $result->msg);
    }

    public function getInfo() {
        $body = [
            'user' => session()->userid,
            'token' => session()->token,
        ];
        $service = new ApiService();
        $result = $service->get_info($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        return $this->response($result->data, $result->msg);
    }

    public function getBalance() {
        $body = [
            'user' => session()->userid,
            'token' => session()->token,
            'web' => session()->web,
            'webuser' => session()->webuser,
        ];
        $service = new ApiService();
        $result = $service->get_balance($body);
        if (!$result->status) {
            // NOTE: Check has webuser (frist login).
            if ($result->msg == 'webuser not found') return $this->response(null, $result->msg);
            return $this->response(null, $result->msg, false);
        }
        session()->set(['webbalance' => $result->data->webbalance]);
        return $this->response($result->data, $result->msg);
    }

    public function changePassword() {
        $data = $this->getPost();
        $body = [
            'web' => session()->web,
            'user' => session()->userid,
            'token' => session()->token,
            'oldpass' => $data->current_password,
            'newpass' => $data->new_password,
        ];
        $service = new ApiService();
        $result = $service->change_password($body);
        if (!$result->status) return $this->response(null, $result->msg, false);
        session()->destroy();
        return $this->response($data, $result->msg);
    }

    public function getUfaToken() {
        $body = $this->getPost();
        $curl = curl_init();
        $endpoint = isset($body->endpoint) ? $body->endpoint : 'https://lion777.apple855.com/HomeSmart.aspx?lang=EN-GB';
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(),
        ));

        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        // $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($curl);

        $inputs = [];
        $arr = explode(PHP_EOL, $body);
        // return $this->response($arr, null, false);
        foreach ($arr as $row) {
            if (strpos($row, "__VIEWSTATEGENERATOR") != false) $inputs[] = $row;
            else if (strpos($row, "__EVENTVALIDATION") != false) $inputs[] = $row;
            else if (strpos($row, "__VIEWSTATE") != false) $inputs[] = $row;
        }
        // return $this->response($inputs, null, false);

        if (count($inputs) == 0) return $this->response(null, "Token not found!");

        $result = [];
        $document = new DOMDocument();
        $document->loadHTML(implode("", $inputs));
        $xpath = new DOMXPath($document);
        $result["__VIEWSTATEGENERATOR"] = $xpath->query("//input[@name=\"__VIEWSTATEGENERATOR\"]")[0]->getAttribute("value");
        $result["__EVENTVALIDATION"] = $xpath->query("//input[@name=\"__EVENTVALIDATION\"]")[0]->getAttribute("value");
        $result["__VIEWSTATE"] = $xpath->query("//input[@name=\"__VIEWSTATE\"]")[0]->getAttribute("value");
        $result["__ENDPOINT"] = $endpoint;

        return $this->response($result);
    }
}

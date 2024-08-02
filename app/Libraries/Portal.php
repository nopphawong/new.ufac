<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Exception;

class Portal {
    private $curl;
    private $secret;
    private $key;

    public function __construct() {
        $this->curl = new CURLRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI(),
            new \CodeIgniter\HTTP\Response(new \Config\App()),
            ["baseURI" => $_ENV["api.portalURL"]]
        );
        $this->secret = "{$_ENV["app.secret"]}";
        $this->key = "{$_ENV["app.appKey"]}";
    }

    // Agent
    public function agent_info($data = array()) {
        return self::post("agent/info", $data);
    }

    // banner
    public function banner_list($data = array()) {
        return self::post("banner/list/actived", $data);
    }
    public function banner_info($data = array()) {
        return self::post("banner/info", $data);
    }

    // wheel
    public function wheel($data = array()) {
        return self::post("wheel/first", $data);
    }
    public function wheel_roll($data = array()) {
        return self::post("wheel/roll", $data);
    }
    // segment
    public function segment_list($data = array()) {
        return self::post("segment/list", $data);
    }
    // wheeldaily
    public function wheeldaily_list($data = array()) {
        return self::post("wheeldaily/list", $data);
    }
    public function wheeldaily_history($data = array()) {
        return self::post("wheeldaily/list/history", $data);
    }
    public function wheeldaily_usable($data = array()) {
        return self::post("wheeldaily/list/usable", $data);
    }
    public function wheeldaily_claimable($data = array()) {
        return self::post("wheeldaily/list/claimable", $data);
    }
    public function wheeldaily_info($data = array()) {
        return self::post("wheeldaily/info", $data);
    }
    public function wheeldaily_addable($data = array()) {
        return self::post("wheeldaily/addable", $data);
    }
    public function wheeldaily_add($data = array()) {
        return self::post("wheeldaily/add", $data);
    }
    public function wheeldaily_roll($data = array()) // data from wheel/roll
    {
        return self::post("wheeldaily/roll", $data);
    }
    public function wheeldaily_claim($data = array()) {
        return self::post("wheeldaily/claim", $data);
    }
    public function wheeldaily_unclaim($data = array()) {
        return self::post("wheeldaily/unclaim", $data);
    }

    // checkin
    public function checkin($data = array()) {
        return self::post("checkin/first", $data);
    }
    // progress
    public function progress_list($data = array()) {
        return self::post("progress/list", $data);
    }
    // checkindaily
    public function checkindaily_list($data = array()) {
        return self::post("checkindaily/list", $data);
    }
    public function checkindaily_usable($data = array()) {
        return self::post("checkindaily/usable", $data);
    }
    public function checkindaily_claimable($data = array()) {
        return self::post("checkindaily/list/claimable", $data);
    }
    public function checkindaily_info($data = array()) {
        return self::post("checkindaily/info", $data);
    }
    public function checkindaily_add($data = array()) {
        return self::post("checkindaily/add", $data);
    }
    public function checkindaily_history($data = array()) {
        return self::post("checkindaily/list/history", $data);
    }
    public function checkindaily_claim($data = array()) {
        return self::post("checkindaily/claim", $data);
    }
    public function checkindaily_unclaim($data = array()) {
        return self::post("checkindaily/unclaim", $data);
    }

    // webuser
    public function webuser_register($data = array()) {
        return self::post("webuser/register", $data);
    }
    public function webuser_unlink($data = array()) {
        return self::post("webuser/unlink", $data);
    }
    public function webuser_checkup($data = array()) {
        return self::post("webuser/checkup", $data);
    }

    // channel
    public function channel_list($data = array()) {
        return self::post("channel/list", $data);
    }

    // lotto
    public function lotto_list($data = array()) {
        return self::post("lotto/list", $data);
    }
    public function lotto_info($data = array()) {
        return self::post("lotto/info", $data);
    }
    public function lotto_history($data = array()) {
        return self::post("lotto/history", $data);
    }
    public function lotto_point($data = array()) {
        return self::post("lotto/point", $data);
    }
    public function lotto_number_list($data = array()) {
        return self::post("lotto/number/list", $data);
    }
    public function lotto_number_buy($data = array()) {
        return self::post("lotto/number/buy", $data);
    }


    /* ========================================================================== */

    protected function post($path, $data = array()) {
        $data = (object) $data;
        $data->secret = $this->secret;
        $data->key = $this->key;
        $body = self::hash_data($data);
        log_message("alert", "path: {$path} :: " . $body);
        $response = $this->curl->post("{$path}", ["json" => $data]);
        $result = self::prepare_result($response);
        log_message("alert", "path: {$path} :: " . json_encode($result));
        return $result;
    }

    protected function get($path) {
        $response = $this->curl->get($path);
        return self::prepare_result($response);
    }

    protected function hash_data($array) {
        if (empty($array)) $array = array();
        return json_encode((array)$array);
    }

    protected function prepare_result($response) {
        try {
            $result = json_decode($response->getBody());
            if (json_last_error() !== JSON_ERROR_NONE) {
                return (object) array(
                    "status" => false,
                    "message" => $response->getBody(),
                );
            }
            return $result;
        } catch (Exception $ex) {
            return (object) array(
                "status" => false,
                "message" => $ex->getMessage(),
            );
        }
    }
}

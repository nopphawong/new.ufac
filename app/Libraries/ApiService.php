<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Exception;

class ApiService
{
    private $curl;
    private $app_name;
    private $appid;
    private $secret;
    private $tele_url;
    private $tele_token;
    private $tele_chat_id;

    public function __construct()
    {
        $this->app_name = "{$_ENV["app.appName"]}";
        $this->appid = "{$_ENV["app.appKey"]}";
        $this->secret = "{$_ENV["app.secret"]}";
        $this->tele_url = "{$_ENV["app.telegramURL"]}";
        $this->tele_token = "{$_ENV["app.telegramToken"]}";
        $this->tele_chat_id = "{$_ENV["app.telegramChatID"]}";
        // $this->curl = service("curlrequest", ["baseURI" => "{$_ENV["app.apiURL"]}"]);
        $this->curl = new CURLRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI(),
            new \CodeIgniter\HTTP\Response(new \Config\App()),
            ["baseURI" => "{$_ENV["app.apiURL"]}"]
        );
    }

    // Login.
    public function login($data = array())
    {
        return self::post("m_login", $data);
    }

    // Register.
    public function check_user_exits($data = array())
    {
        return self::post("m_checkexits", $data);
    }
    public function check_bank_exits($data = array())
    {
        return self::post("m_checkbank", $data);
    }
    public function verify_bank($data = array())
    {
        return self::post("m_bankverifyx", $data);
    }
    public function register($data = array())
    {
        // NOTE: Send notify telegram.
        // self::send($data);
        return self::post("m_register", $data);
    }

    // Forgot Password.
    public function request_otp($data = array())
    {
        return self::post("m_sentotp", $data);
    }
    public function forgot($data = array())
    {
        return self::post("m_forgetpass", $data);
    }

    // Lobby Info.
    public function get_info($data = array())
    {
        return self::post("m_info", $data);
    }
    public function get_balance($data = array())
    {
        return self::post("m_webbalance", $data);
    }
    public function change_password($data = array())
    {
        return self::post("m_uchangepass", $data);
    }

    // Financial
    public function get_deposit_account($data = array())
    {
        return self::post("m_ibankdeposit", $data);
    }
    public function deposit($data = array())
    {
        return self::post("m_ideposit", $data);
    }
    public function deposit_qr($data = array())
    {
        return self::post("m_idepositqr", $data);
    }
    public function withdraw($data = array())
    {
        return self::post("m_iwithdraw", $data);
    }
    public function history($data = array())
    {
        return self::post("m_ididwidlists", $data);
    }

    // user/m_didbonus

    public function add_bonus($data = array())
    {
        return self::post("m_didbonus", $data);
    }

    /* ========================================================================== */

    protected function post($path, $data = array())
    {
        $body = array_merge(
            ['appid' => $this->appid,],
            $data
        );

        $seconds = round((microtime(true) * 1000));
        $body['time'] = $seconds;
        $hash = self::hashdata($body, $this->secret);
        $body['hash'] = $hash;
        $response = $this->curl->post("{$path}", ["json" => $body]);
        log_message("alert", "path: {$path} :: " . json_encode($body));
        $result = self::prepare_result($response);
        log_message("alert", "path: {$path} :: " . json_encode($result));
        return $result;
    }

    public function send_telegram($data = array())
    {
        return self::send($data);
    }

    protected function send($data = array())
    {
        $name = 'ชื่อ: ' . $data['name'];
        $tel = 'เบอร์: ' . $data['user'];
        $bank = 'ธนาคาร: ' . $data['bankid'];
        $bank_ac_no = 'หมาเลขบัญชี: ' . $data['bankno'];
        $code = 'Code: ' . $data['code'];
        $webuser = 'Web User: ' . ($data['webuser'] ? $data['webuser'] : 'ยังไม่ได้รับยูส');
        $webagent = 'Web Agent: ' . ($data['webag'] ? $data['webag'] : '-');
        $ref_name = 'Ref Name: ' . (isset($data['code_name']) ? $data['code_name'] : '-');
        $ref = 'Ref Code: ' . (isset($data['ref']) ? $data['ref'] : '-');

        $message = urlencode("FROM: " . $this->app_name . "\n" . $name . "\n" . $tel . "\n" . $bank . "\n" . $bank_ac_no . "\n" . $code . "\n" . $webuser . "\n" . $webagent . "\n" . $ref_name . "\n" . $ref);
        $url = $this->tele_url . $this->tele_token . '/sendMessage?chat_id=' . $this->tele_chat_id . '&text=' . $message;
        $this->curl->get("{$url}");
        log_message("alert", "send telegram notify :: " . json_encode($data));
    }

    protected function hashdata($array, $secret)
    {
        $array = array_change_key_case($array, CASE_LOWER);
        ksort($array);
        $rawData = '';
        foreach ($array as $Key => $Value) {
            $rawData .=  $Key . '=' . $Value . '&';
        }
        $rawData  = substr($rawData, 0, -1);

        $rawData .= $secret;

        $hash     = md5($rawData);

        return $hash;
    }

    protected function prepare_result($response)
    {
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

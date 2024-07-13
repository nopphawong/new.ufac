<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;

class BaseController extends ResourceController
{
    protected $session;

    public function __construct()
    {
        // Load helpers.
        helper(['util']);
    }
    protected function response($data = null, $message = "Successful !", $status = true)
    {
        $data = array(
            "status" => $status,
            "message" => $message,
            "data" => $data,
        );
        return $this->respond($data);
    }
    protected function getPost()
    {
        $body = $this->request->is('json') ? $this->request->getVar() : $this->request->getPost();
        return (object) $body;
    }
}

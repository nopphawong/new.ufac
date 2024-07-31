<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pages extends BaseController
{
    public function __construct()
    {
        if (session()->logged_in) return redirect()->to(previous_url());
    }
    public function index()
    {
        return view("pages/home", $this->viewData);
    }

    public function register()
    {
        return view("pages/register", $this->viewData);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url("/"));
    }
    public function profile()
    {
        return view("pages/profile", $this->viewData);
    }
    public function changePassword()
    {
        return view("pages/change_pass", $this->viewData);
    }
    public function deposit()
    {
        return view("pages/deposit", $this->viewData);
    }
    public function withdraw()
    {
        return view("pages/withdraw", $this->viewData);
    }
    public function history()
    {
        return view("pages/history", $this->viewData);
    }
    public function promotion()
    {
        return view("pages/promotion", $this->viewData);
    }
    public function lotto() {
        return view("pages/lotto", $this->viewData);
    }
}

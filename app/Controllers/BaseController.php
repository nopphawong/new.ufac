<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Libraries\Portal;
use App\Libraries\Formatter;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller {
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    protected $viewData = [
        "use_meta_tag" => false,
    ];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load helpers.
        helper(['form', 'url', 'number', 'date', 'inflector', 'util', 'html']);

        // E.g.: $this->session = \Config\Services::session();
        $language = \Config\Services::language();
        $language->setLocale(session()->lang);

        // Get Assets From Portal.
        $this->initial_web_info();
        $this->viewData['formatter'] = new Formatter();
        $this->viewData['locale'] = $language->getLocale();
        $this->viewData['version'] = '1.2b';
    }

    private function initial_web_info() {
        $portal = new Portal();
        $info = $portal->agent_info();
        if ($info->status) {
            $this->viewData["title"] = $info->data->name;
            $this->viewData["description"] = $info->data->description;
            $this->viewData["line_id"] = $info->data->line_id;
            $this->viewData["line_link"] = $info->data->line_link;
            $this->viewData["logo"] = $info->data->logo ? $info->data->logo : site_url("assets/images/default/logo_default.png");
            $this->viewData["meta_tag"] = $info->data->meta_tag;
        }
        $banners = $portal->banner_list();
        if ($banners->status) $this->viewData["banners"] = $banners->data;
    }
}

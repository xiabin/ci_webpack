<?php
/**
 * Created by PhpStorm.
 * User: xiabin
 * Date: 2016/3/25
 * Time: 15:26
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Web_Controller
 */
class BaseController extends CI_Controller
{

    /**
     * Web_Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->template_data['static_url'] = base_url() . "static";
        $this->template_data['title'] = "ci_webpack demo";
        // 开发模式下开启性能分析
        if (ENVIRONMENT === 'development' and !$this->input->is_ajax_request()) {
            $this->output->enable_profiler(false);
        }
    }
}


/**
 * Class Base_Controller
 */
class WebController extends BaseController
{


    /**
     * MY_Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

    }
}




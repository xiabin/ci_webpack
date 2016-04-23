<?php
/**
 * Created by PhpStorm.
 * User: xiabin
 * Date: 2016/4/12
 * Time: 10:32
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends BaseController
{
    public function index()
    {
        echo guid();
        exit;
        $this->load->view('test/index', $this->template_data);
    }

    public function index2()
    {
        $this->load->view('test/index2', $this->template_data);

    }

}
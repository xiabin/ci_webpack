<?php

/**
 * Created by PhpStorm.
 * User: xiabin
 * Date: 2016/3/25
 * Time: 15:26
 */
class MY_Controller extends CI_Controller
{
    /*
     * 模板解析数据
     */
    protected $template_data;

    public function __construct()
    {
        parent::__construct();
        $this->template_data['public_url'] = base_url()."public";
    }




}
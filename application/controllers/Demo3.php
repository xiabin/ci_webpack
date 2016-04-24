<?php

/**
 * Created by PhpStorm.
 * User: binxia3
 * Date: 2016/4/24 0024
 * Time: 12:13
 */
class Demo3 extends WebController
{
    public function index(){
        $this->load->view('demo3',$this->template_data);
    }

}
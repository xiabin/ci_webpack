<?php

/**
 * Created by PhpStorm.
 * User: xiabin
 * Date: 2016/3/25
 * Time: 15:55
 */
class Demo2 extends WebController
{
    public function index()
    {
        $this->load->view('demo2',$this->template_data);
    }

    public function do_upload()
    {
        $config['upload_path']      = base_url() .'/uploads/';
        $config['allowed_types']    = '*';
        $config['max_size']     = 10000;
        $config['max_width']        = 1024;
        $config['max_height']       = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {

            echo false;
        }
        else
        {

            echo true;
        }
    }


}
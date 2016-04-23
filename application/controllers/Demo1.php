<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo1 extends WebController
{
	public function __construct()
	{
		parent::__construct();

	}


	public function index()
	{
		$this->load->view('demo1',$this->template_data);
	}
}

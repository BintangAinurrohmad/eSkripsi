<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data = [
			'title' => "Dashboard",
			'content' => 'welcome_message', 
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function dosen()
	{
		$data = [
			'title' => "Dashboard",
			'content' => 'welcome_message', 
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	public function koordinator()
	{
		$data = [
			'title' => "Dashboard",
			'content' => 'welcome_message', 
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function admin()
	{
		$data = [
			'title' => "Dashboard",
			'content' => 'welcome_message', 
		];
		$this->load->view('template/overlay/admin', $data);
	}

}

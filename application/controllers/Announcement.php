<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Announcement extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Announcement_model');
	}

	public function index()
	{
		$pengumuman = $this->Announcement_model->get();
		$data = [
			'title' => "Pengumuman",
			'content' => 'announcement/list',
			'pengumuman' => $pengumuman
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function add()
	{
		$pengumuman = $this->Announcement_model->get();
		$data = [
			'title' => "Pengumuman",
			'content' => 'announcement/add',
			'pengumuman' => $pengumuman
		];
		$this->load->view('template/overlay/koordinator', $data);
	}
}

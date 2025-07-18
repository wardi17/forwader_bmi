<?php

class Home extends Controller{


	public function __construct()
	{	
	
		
		if($_SESSION['login_user'] == '') {
			Flasher::setMessage('Login','Tidak ditemukan.','danger');
			header('location: '. base_url . '/login');
			exit;
		}
	} 
	public function index()
		{
		

			$data["pages"] ="home";
			$this->view('templates/header');
			$this->view('templates/sidebar', $data);
			$this->view('home/index');
			$this->view('templates/footer');
		}


	


 
}
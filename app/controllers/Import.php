<?php

class Import extends Controller {

	protected $userid;

	public function __construct()
	{	
	
		
		if($_SESSION['login_user'] == '') {
			Flasher::setMessage('Login','Tidak ditemukan.','danger');
			header('location: '. base_url . '/login');
			exit;
		}else{
			$this->userid = $_SESSION['login_user'];
		}
	} 

		public function index()
		{
	
			$data['pages'] = "trans";
			$data['page'] = "trans";
			$data['userid']= $this->userid;
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('forwaderimport/index', $data);
			$this->view('templates/footer');
		}


		public function tambah()
		{
			$data['pages']		= "trans";
			$data['page']		= "trans";
			$data["userid"]		= $this->userid;
			$data["supplierforwade"] = $this->model('SupplierForwaderModel')->Tampildata();
			$data["supplier"] = $this->model('SupplierModel')->Tampildata();

			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('forwaderimport/tambah', $data);
			$this->view('templates/footer'); 
		}


		public function post(){
			$data['pages']		= "trans";
			$data['page']		= "trans";
			$data["userid"]		= $this->userid;
			
			$id	= $_POST["ItemNo"];
			$data["item"] = $this->model('TransaksiModel')->getById($id);
				if (!$data["item"]) {
					die("Data tidak ditemukan");
				}
			$data["supplierforwade"] = $this->model('SupplierForwaderModel')->Tampildata();
			$data["supplier"] = $this->model('SupplierModel')->Tampildata();
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('forwaderimport/posting', $data);
			$this->view('templates/footer'); 
		}

		public function edit(){
			$data['pages']		= "trans";
			$data['page']		= "trans";
			$data["userid"]		= $this->userid;
			
			$id	= $_POST["ItemNo"];
			$data["item"] = $this->model('TransaksiModel')->getById($id);
				if (!$data["item"]) {
					die("Data tidak ditemukan");
				}

			$data["supplierforwade"] = $this->model('SupplierForwaderModel')->Tampildata();
			$data["supplier"] = $this->model('SupplierModel')->Tampildata();
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('forwaderimport/edit', $data);
			$this->view('templates/footer'); 
		}


		public function put(){
		    $data['pages'] = "put";
			$data['page'] = "put";
			$data['userid']= $this->userid;
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('forwaderimport/posted', $data);
			$this->view('templates/footer');
		}


		public function detail(){
			$data['pages']		= "put";
			$data['page']		= "put";
			$data["userid"]		= $this->userid;
			
			$id	= $_POST["ItemNo"];
			$data["item"] = $this->model('TransaksiModel')->getById($id);
				if (!$data["item"]) {
					die("Data tidak ditemukan");
				}
			$data["supplierforwade"] = $this->model('SupplierForwaderModel')->Tampildata();
			$data["supplier"] = $this->model('SupplierModel')->Tampildata();
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('forwaderimport/detail', $data);
			$this->view('templates/footer'); 
		}


}
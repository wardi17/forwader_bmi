<?php
include("Import.php");
class LaporanImport extends Import
{

    private $model_lap;
    public function __construct()
    {


        if ($_SESSION['login_user'] == '') {
            Flasher::setMessage('Login', 'Tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/login');
            exit;
        } else {
            $this->model_lap = $this->model('LaporanTransaksiImportModel');
            $this->userid = $_SESSION['login_user'];
        }
    }


    public function cetakprint()
    {


        $datas = $this->model_lap->cetakprint($_POST);
        $data["datas"] = $datas;

        $this->view('laporanimport/print', $data);
    }



    public  function index()
    {
        $data['pages'] = "lapimport";
        $data['userid'] = $this->userid;
        $this->view('templates/header');
        $this->view('templates/sidebar', $data);
        $this->view('laporanimport/index', $data);
        $this->view('templates/footer');
    }




    //getlaporan

    public function getlaporan()
    {
        try {
            $data = $this->model_lap->GetListLaporan(); // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }



    //detail laporan

    public function lap_d()
    {
        $data['pages']        = "lapimport";
        $data['page']        = "lapimport";
        $data["userid"]        = $this->userid;

        $id    = $_POST["ItemNo"];
        $data["item"] = $this->model('TransaksiModel')->getById($id);
        if (!$data["item"]) {
            die("Data tidak ditemukan");
        }
        $data["supplierforwade"] = $this->model('SupplierForwaderModel')->Tampildata();
        $data["supplier"] = $this->model('SupplierModel')->Tampildata();
        $this->view('templates/header');
        $this->view('templates/sidebar', $data);
        $this->view('laporanimport/detail', $data);
        $this->view('templates/footer');
    }
}

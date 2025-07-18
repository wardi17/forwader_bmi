<?php

class TransaksiModel extends Models
{

    protected $table_trs = "[bambi-bmi].[dbo].forwarder_transactions";



    public function SaveData()
    {


        // Decode JSON ke array


        $nama_atter = "";
        $nama_atter_str = "";
        if (!empty($_FILES)) {
            $files = $_FILES['files'];
            $total = count($files['name']);
            for ($i = 0; $i < $total; $i++) {
                $file_name = $files['name'][$i];
                $file_tmp = $files['tmp_name'][$i];
                $file_size = $files['size'][$i];
                $file_error = $files['error'][$i];
                $fileType = $files['type'][$i];

                if ($file_error !== UPLOAD_ERR_OK) {
                    return "Error uploading $file_name. Error code: $file_error<br>";
                }
                $new_nama      = $file_name;
                $destination = FOLDER . $new_nama;
                if (move_uploaded_file($file_tmp, $destination)) {
                    $nama_atter .= $new_nama . ",";
                }
            }

            $nama_atter_str = rtrim($nama_atter, ",");
        }

        $inputJSON = $_POST["datahider"];
        $post = json_decode($inputJSON, true);



        $kode = "SPKBI";
        $jenis = "IM";
        $ID_document = $this->Get_ID_document($kode, $jenis);
        $tanggal      = $this->setdate($this->test_input($post["tanggal"]));
        $forwaderid = $this->test_input($post["forwaderid"]);
        $forwadername      = $this->test_input($post["forwadername"]);
        $pc              = $this->test_input($post["pc"]);
        $alamat          = $this->test_input($post["alamat"]);
        $importer          = $this->test_input($post["importer"]);
        $consignee      = $this->test_input($post["consignee"]);
        $supplierid          = $this->test_input($post["supplier"]);
        $suppliername      = $this->test_input($post["suppliername"]);
        $coderegion      = $this->test_input($post["coderegion"]);
        $jenisbarang      = $this->test_input($post["jenisbarang"]);
        $hscode          = $this->test_input($post["hscode"]);
        $jumlah_volume  = $this->test_input($post["jumlah_volume"]);
        $pelabuhan_tujuan = $this->test_input($post["pelabuhan_tujuan"]);
        $eta              = $this->setdate($this->test_input($post["eta"]));
        $no_invoice          = $this->test_input($post["no_invoice"]);
        $shippingline          = $this->test_input($post["shippingline"]);
        $no_bl_awb          = $this->test_input($post["no_bl_awb"]);
        $container_no          = $this->test_input($post["container_no"]);
        $vessel_voyage      = $this->test_input($post["vessel_voyage"]);
        $notelpon           = $this->test_input($post["notelpon"]);
        $DOTransacID        = $this->test_input($post["DOTransacID"]);
        $DONumber           = $this->test_input($post["DONumber"]);


        $userid = $_SESSION['login_user'];

        $query = "INSERT INTO $this->table_trs(ID_document,Tanggal,forwaderid,forwadername,pc,alamat,importer,consignee,
          supplierid,suppliername,coderegion,jenisbarang,hscode,jumlah_volume,pelabuhan_tujuan,eta,no_invoice,shippingline,
          no_bl_awb,container_no,vessel_voyage,userinput,document_files,notelpon,DOTransacID,DONumber
          )VALUES(
          '{$ID_document}','{$tanggal}','{$forwaderid}','{$forwadername}','{$pc}','{$alamat}','{$importer}','{$consignee}',
          '{$supplierid}','{$suppliername}','{$coderegion}','{$jenisbarang}','{$hscode}','{$jumlah_volume}','{$pelabuhan_tujuan}','{$eta}','{$no_invoice}','{$shippingline}',
          '{$no_bl_awb}','{$container_no}','{$vessel_voyage}','{$userid}','{$nama_atter_str}','{$notelpon}','{$DOTransacID}','{$DONumber}'
          )";

        //$this->consol_war($query);
        $result = $this->db->baca_sql($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Tambah";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Tambah";
        }
    }


    protected function setdate($tanggal)
    {
        $tanggalObj = DateTime::createFromFormat("d/m/Y", $tanggal);
        $tanggal_sql = $tanggalObj->format(("Y-m-d"));
        return $tanggal_sql;
    }

    private function Get_ID_document($kode, $jenis)
    {
        $bulan = date("m"); // ex: 07
        $tahun = date("Y"); // ex: 2025

        // Query untuk mendapatkan nomor urut terakhir per bulan dan tahun
        $query = "
                SELECT MAX(CAST(LEFT(ID_document, 3) AS INT)) AS nomor_terakhir
                FROM $this->table_trs
                WHERE MONTH(Tanggal) = '{$bulan}' AND YEAR(Tanggal) = '{$tahun}' 
            ";


        $stmt = $this->db->baca_sql2($query);
        $nomorTerakhir = odbc_result($stmt, "nomor_terakhir");

        // Jika NULL, anggap 0
        if (is_null($nomorTerakhir)) {
            $nomorTerakhir = 0;
        }

        // Tambah 1 dan format 3 digit
        $urutBaru = str_pad($nomorTerakhir + 1, 3, '0', STR_PAD_LEFT);

        // Gabung ke format ID Document
        $idDocument = "$urutBaru/$kode/$jenis/$bulan/$tahun";

        return $idDocument;
    }



    public function ListData()
    {
        try {
            $rawData = file_get_contents("php://input");

            $post = json_decode($rawData, true);
            $userid = $this->test_input($post["userid"]);


            $status = ($userid == "wardi" || $userid == "herman" || $userid == "weelan") ? "Y" : "N";
            $tahun  = $this->test_input($post["tahun"]);
            $level_posting = ($userid == "wardi" || $userid == "herman" || $userid == "weelan") ? "Y" : "N";

            // Siapkan query SQL

            $query = "USP_TamplilListForwaderImport '{$status}','{$tahun}','{$userid}'";
            $result = $this->db->baca_sql2($query);

            if (!$result) {
                throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
            }

            $datas = [];
            while (odbc_fetch_row($result)) {
                $ItemNo        = rtrim(odbc_result($result, 'ItemNo'));
                $Tanggal       = new DateTime(rtrim(odbc_result($result, 'Tanggal')));
                $forwaderid    = rtrim(odbc_result($result, 'forwaderid'));
                $pc            = rtrim(odbc_result($result, 'pc'));
                $importer      = rtrim(odbc_result($result, "importer"));
                $jenisbarang   = rtrim(odbc_result($result, "jenisbarang"));
                $userinput   = rtrim(odbc_result($result, "userinput"));
                $FlagPosting  = rtrim(odbc_result($result, "FlagPosting"));
                $FlagPrint    = rtrim(odbc_result($result, "FlagPrint"));
                $level_edit = ($userid == "wardi" || $userid == "herman" || $userid == $userinput) ? "Y" : "N";
                $level_print = ($userid == "wardi" || $userid == "herman" || $userid == $userinput) ? "Y" : "N";

                $datas[] = [
                    "ItemNo"        => $ItemNo,
                    "Tanggal"       => date_format($Tanggal, "d-m-y"),
                    "forwaderid"    => $forwaderid,
                    "pc"            => $pc,
                    "importer"      => $importer,
                    "jenisbarang"   => $jenisbarang,
                    "userinput"     => $userinput,
                    "FlagPosting"   => $FlagPosting,
                    "FlagPrint"     => $FlagPrint,
                    "level_posting" => $level_posting,
                    "level_edit"    => $level_edit,
                    "level_print"   => $level_print

                ];
            }
            // $this->consol_war($datas);
            return $datas;
        } catch (Exception $e) {
            // Catat error log untuk debug
            error_log("Error in GetKatgori: " . $e->getMessage());

            // Kembalikan array kosong jika gagal
            return [];
        }
    }



    public function getById($id)
    {
        $query = "SELECT * FROM $this->table_trs  WHERE ItemNo ='{$id}'";
        $result = $this->db->baca_sql2($query);
        if (!$result) {
            throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
        }

        $datas = [];
        while (odbc_fetch_row($result)) {
            $ID_document        = rtrim(odbc_result($result, 'ID_document'));
            $Tanggal       = new DateTime(rtrim(odbc_result($result, 'Tanggal')));
            $forwaderid    = rtrim(odbc_result($result, 'forwaderid'));
            $forwadername  = rtrim(odbc_result($result, 'forwadername'));
            $pc            = rtrim(odbc_result($result, 'pc'));
            $alamat        = rtrim(odbc_result($result, "alamat"));
            $importer      = rtrim(odbc_result($result, "importer"));
            $consignee     = rtrim(odbc_result($result, "consignee"));
            $supplierid      = rtrim(odbc_result($result, "supplierid"));
            $suppliername  = rtrim(odbc_result($result, "suppliername"));
            $coderegion    = rtrim(odbc_result($result, "coderegion"));
            $jenisbarang   = rtrim(odbc_result($result, "jenisbarang"));
            $hscode        = rtrim(odbc_result($result, "hscode"));
            $jumlah_volume = rtrim(odbc_result($result, "jumlah_volume"));
            $pelabuhan_tujuan = rtrim(odbc_result($result, "pelabuhan_tujuan"));
            $eta             = new DateTime(rtrim(odbc_result($result, "eta")));
            $no_invoice     = rtrim(odbc_result($result, "no_invoice"));
            $shippingline   = rtrim(odbc_result($result, "shippingline"));
            $no_bl_awb      = rtrim(odbc_result($result, "no_bl_awb"));
            $container_no   = rtrim(odbc_result($result, "container_no"));
            $vessel_voyage = rtrim(odbc_result($result, "vessel_voyage"));
            $userinput     = rtrim(odbc_result($result, "userinput"));
            $document_files = rtrim(odbc_result($result, "document_files"));
            $notelpon       = rtrim(odbc_result($result, "notelpon"));
            $DONumber       = rtrim(odbc_result($result, "DONumber"));
            $DOTransacID    = trim(odbc_result($result, "DOTransacID"));
            $datas = [
                "ID_document"   => $ID_document,
                "Tanggal"       => date_format($Tanggal, "d-m-Y"),
                "forwaderid"    => $forwaderid,
                "forwadername"  => $forwadername,
                "pc"            => $pc,
                "importer"      => $importer,
                "jenisbarang"   => $jenisbarang,
                "userinput"     => $userinput,
                "alamat"        => $alamat,
                "consignee"     => $consignee,
                "supplierid"    => $supplierid,
                "hscode"        => $hscode,
                "jumlah_volume" => $jumlah_volume,
                "pelabuhan_tujuan" => $pelabuhan_tujuan,
                "eta"            => date_format($eta, "d-m-Y"),
                "no_invoice"     => $no_invoice,
                "shippingline"   => $shippingline,
                "no_bl_awb"      => $no_bl_awb,
                "container_no"   => $container_no,
                "vessel_voyage"  => $vessel_voyage,
                "document_files" => $document_files,
                "notelpon"       => $notelpon,
                "DONumber"       => $DONumber,
                "ItemNo"         => $id,
                "DOTransacID"    => $DOTransacID,

            ];
        }

        //$this->consol_war($datas);
        return $datas;
    }




    //proses posting 
    public function PostingData()
    {
        $inputJSON = $_POST["datahider"];
        $post = json_decode($inputJSON, true);
        $ItemNo           = $this->test_input($post["ItemNo"]);
        $ID_document      = $this->test_input($post["ID_document"]);
        $userid = $_SESSION['login_user'];
        $dataposting =  date('Y-m-d H:i:s');

        $query = "UPDATE $this->table_trs  SET FlagPosting='Y', UserPosting='{$userid}', DatePosting='{$dataposting}' 
            WHERE  ItemNo ='{$ItemNo}' AND ID_document='{$ID_document}' ";

        $result = $this->db->baca_sql($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Posting";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Posting";
        }

        return $status;
    }

    //and proses posting




    public function StatusPrint()
    {
        $rawData = file_get_contents("php://input");
        $post = json_decode($rawData, true);

        $ItemNo           = $this->test_input($post["ItemNo"]);
        $userid           = $this->test_input($post["userid"]);
        $dateprint        =  date('Y-m-d H:i:s');

        $query = "UPDATE $this->table_trs  SET FlagPrint='Y', UserPrint='{$userid}', DatePrint='{$dateprint}' 
            WHERE  ItemNo ='{$ItemNo}' ";

        $result = $this->db->baca_sql($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            return $this->ListData();
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Posting";

            return $status;
        }
    }



    public function ListPosted()
    {
        try {
            $rawData = file_get_contents("php://input");

            $post = json_decode($rawData, true);
            $userid = $this->test_input($post["userid"]);
            $status = ($userid == "wardi" || $userid == "herman") ? "Y" : "N";
            $tahun  = $this->test_input($post["tahun"]);

            // Siapkan query SQL

            $query = "USP_TamplilListPostedForwaderImport '{$status}','{$tahun}','{$userid}'";
            $result = $this->db->baca_sql2($query);

            if (!$result) {
                throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
            }

            $datas = [];
            while (odbc_fetch_row($result)) {
                $ItemNo        = rtrim(odbc_result($result, 'ItemNo'));
                $Tanggal       = new DateTime(rtrim(odbc_result($result, 'Tanggal')));
                $forwaderid    = rtrim(odbc_result($result, 'forwaderid'));
                $pc            = rtrim(odbc_result($result, 'pc'));
                $importer      = rtrim(odbc_result($result, "importer"));
                $jenisbarang   = rtrim(odbc_result($result, "jenisbarang"));
                $userinput   = rtrim(odbc_result($result, "userinput"));
                $FlagPosting  = rtrim(odbc_result($result, "FlagPosting"));
                $FlagPrint    = rtrim(odbc_result($result, "FlagPrint"));

                $datas[] = [
                    "ItemNo"        => $ItemNo,
                    "Tanggal"       => date_format($Tanggal, "d-m-y"),
                    "forwaderid"    => $forwaderid,
                    "pc"            => $pc,
                    "importer"      => $importer,
                    "jenisbarang"   => $jenisbarang,
                    "userinput"     => $userinput,
                    "FlagPosting"   => $FlagPosting,
                    "FlagPrint"     => $FlagPrint,
                    "status"        => $status,

                ];
            }
            // $this->consol_war($datas);
            return $datas;
        } catch (Exception $e) {
            // Catat error log untuk debug
            error_log("Error in GetKatgori: " . $e->getMessage());

            // Kembalikan array kosong jika gagal
            return [];
        }
    }

    public function UpdateData()
    {
        $nama_atter = "";
        $nama_atter_str = "";
        if (!empty($_FILES)) {
            $files = $_FILES['files'];
            $total = count($files['name']);
            for ($i = 0; $i < $total; $i++) {
                $file_name = $files['name'][$i];
                $file_tmp = $files['tmp_name'][$i];
                $file_size = $files['size'][$i];
                $file_error = $files['error'][$i];
                $fileType = $files['type'][$i];

                if ($file_error !== UPLOAD_ERR_OK) {
                    return "Error uploading $file_name. Error code: $file_error<br>";
                }
                $new_nama      = $file_name;
                $destination = FOLDER . $new_nama;
                if (move_uploaded_file($file_tmp, $destination)) {
                    $nama_atter .= $new_nama . ",";
                }
            }

            $nama_atter_str = rtrim($nama_atter, ",");
        }
        $inputJSON = $_POST["datahider"];
        $post = json_decode($inputJSON, true);
        $ID_document = $this->test_input($post["ID_document"]);
        $ItemNo      = $this->test_input($post["ItemNo"]);
        $nama_files_old = $post["nama_files_old"];
        $tanggal      = $this->setdate($this->test_input($post["tanggal"]));
        $forwaderid = $this->test_input($post["forwaderid"]);
        $forwadername      = $this->test_input($post["forwadername"]);
        $pc              = $this->test_input($post["pc"]);
        $alamat          = $this->test_input($post["alamat"]);
        $importer          = $this->test_input($post["importer"]);
        $consignee      = $this->test_input($post["consignee"]);
        $supplierid          = $this->test_input($post["supplier"]);
        $suppliername      = $this->test_input($post["suppliername"]);
        $coderegion      = $this->test_input($post["coderegion"]);
        $jenisbarang      = $this->test_input($post["jenisbarang"]);
        $hscode          = $this->test_input($post["hscode"]);
        $jumlah_volume  = $this->test_input($post["jumlah_volume"]);
        $pelabuhan_tujuan = $this->test_input($post["pelabuhan_tujuan"]);
        $eta              = $this->setdate($this->test_input($post["eta"]));
        $no_invoice          = $this->test_input($post["no_invoice"]);
        $shippingline          = $this->test_input($post["shippingline"]);
        $no_bl_awb          = $this->test_input($post["no_bl_awb"]);
        $container_no          = $this->test_input($post["container_no"]);
        $vessel_voyage      = $this->test_input($post["vessel_voyage"]);
        $notelpon           = $this->test_input($post["notelpon"]);
        $DOTransacID        = $this->test_input($post["DOTransacID"]);
        $DONumber           = $this->test_input($post["DONumber"]);
        $new_nama_atter = "";

        // Cek apakah array lama tidak kosong
        if (!empty($nama_files_old)) {
            $this->hapusFileupload($nama_files_old, $ID_document, $ItemNo);
            // Gabungkan nama file lama dengan koma
            $gabungan_lama = implode(",", $nama_files_old);
            // Gabungkan dengan string baru
            $new_nama_atter = empty($nama_atter_str) === true ? $gabungan_lama :  $gabungan_lama . "," . $nama_atter_str;
        } else {
            // Jika kosong, pakai string baru saja
            $new_nama_atter = $nama_atter_str;
        }
        $userid = $_SESSION['login_user'];
        $date_update        =  date('Y-m-d H:i:s');

        $query = "UPDATE $this->table_trs SET Tanggal='{$tanggal}',forwaderid='{$forwaderid}',forwadername='{$forwadername}',
         pc ='{$pc}',alamat='{$alamat}',importer='{$importer}',consignee ='{$consignee}',supplierid='{$supplierid}',suppliername ='{$suppliername}',
         coderegion='{$coderegion}',jenisbarang ='{$jenisbarang}',hscode ='{$hscode}',jumlah_volume ='{$jumlah_volume}',pelabuhan_tujuan ='{$pelabuhan_tujuan}',
         eta ='{$eta}',no_invoice ='{$no_invoice}',shippingline ='{$shippingline}',no_bl_awb ='{$no_bl_awb}',container_no ='{$container_no}',
         vessel_voyage ='{$vessel_voyage}',user_update='{$userid}',document_files ='{$new_nama_atter}',notelpon ='{$notelpon}',DOTransacID ='{$DOTransacID}',DONumber='{$DONumber}',
         date_update='{$date_update}'
         WHERE ItemNo ='{$ItemNo}' AND ID_document ='{$ID_document}'
          ";
        $result = $this->db->baca_sql($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Update";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Update";
        }
    }

    private function hapusFileupload($nama_files_old, $ID_document, $ItemNo)
    {
        // Ambil nama file dari database
        $query = "SELECT document_files FROM $this->table_trs WHERE ID_document='{$ID_document}' AND ItemNo='{$ItemNo}'";
        $sql = $this->db->baca_sql($query);
        $document_files = odbc_result($sql, "document_files");

        // Ubah string menjadi array
        $list_files_db = array_map('trim', explode(",", $document_files));

        // Loop semua file dari database
        foreach ($list_files_db as $file_name) {
            // Jika file ini TIDAK ADA dalam nama_files_old, maka hapus
            if (!in_array($file_name, $nama_files_old)) {
                $path = FOLDER . basename($file_name); // Pastikan hanya nama file, bukan path lengkap

                if (file_exists($path)) {
                    unlink($path); // Hapus file
                }
            }
        }
    }


    public function DeleteData()
    {
        $rawData = file_get_contents("php://input");
        $post = json_decode($rawData, true);
        $ID_document = $this->test_input($post["ID_document"]);
        $ItemNo      = $this->test_input($post["ItemNo"]);
        $query = "SELECT document_files FROM $this->table_trs WHERE ID_document='{$ID_document}' AND ItemNo='{$ItemNo}'";
        $sql = $this->db->baca_sql($query);

        // Cek jika query berhasil dan ada hasil
        $document_files = "";
        if ($sql && odbc_fetch_row($sql)) {
            $document_files = odbc_result($sql, "document_files");
        }
        // Jika document_files tidak kosong
        if (!empty($document_files)) {
            // Ubah string jadi array, buang spasi
            $list_files_db = array_map('trim', explode(",", $document_files));

            foreach ($list_files_db as $file_name) {
                // Pastikan hanya nama file saja
                $path = FOLDER . basename($file_name);

                // Cek dan hapus jika file ada
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $query2 = "DELETE  FROM $this->table_trs  WHERE ID_document='{$ID_document}' AND ItemNo='{$ItemNo}'";
        $result2 =  $this->db->baca_sql2($query2);
        $cek = 0;
        if (!$result2) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Dihapus";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Dihapus";
        }
        return $status;
    }
}

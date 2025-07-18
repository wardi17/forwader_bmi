<?php
include("TransaksiModel.php");
class LaporanTransaksiImportModel  extends TransaksiModel{
    private $pihak_fowader =[
        "Melakukan proses kepabeanan (custom clearance)",
        "Menangani proses pengeluaran barang dari pelabuhan",
        "Mengatur pengiriman barang ke gudang kami di:"
    ];

    public function cetakprint($post){
        $ItemNo = $this->test_input($post["ItemNo"]);

        $query ="USP_CetakPrintForwaderImport '{$ItemNo}'";
        $result = $this->db->baca_sql2($query);

         if (!$result) {
            throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
        }

        $datas = [];
        while (odbc_fetch_row($result)){
             $ID_document        = rtrim(odbc_result($result, 'ID_document'));
             $Tanggal       =new DateTime(rtrim(odbc_result($result, 'Tanggal')));
             $forwaderid    = rtrim(odbc_result($result, 'forwaderid'));
             $forwadername  = rtrim(odbc_result($result, 'forwadername'));
             $pc            = rtrim(odbc_result($result, 'pc'));
             $alamat        = rtrim(odbc_result($result,"alamat"));
             $importer      = rtrim(odbc_result($result,"importer"));
             $consignee     = rtrim(odbc_result($result,"consignee"));
             $supplier      = rtrim(odbc_result($result,"supplierid"));
             $suppliername  = rtrim(odbc_result($result,"suppliername"));
             $coderegion    = rtrim(odbc_result($result,"coderegion"));
             $jenisbarang   = rtrim(odbc_result($result,"jenisbarang"));
             $hscode        = rtrim(odbc_result($result,"hscode"));
             $jumlah_volume = rtrim(odbc_result($result,"jumlah_volume"));
            $pelabuhan_tujuan = rtrim(odbc_result($result,"pelabuhan_tujuan"));
            $eta             = new DateTime(rtrim(odbc_result($result,"eta")));
            $no_invoice     = rtrim(odbc_result($result,"no_invoice"));
            $shippingline   = rtrim(odbc_result($result,"shippingline"));
            $no_bl_awb      = rtrim(odbc_result($result,"no_bl_awb"));
            $container_no   = rtrim(odbc_result($result,"container_no"));
            $vessel_voyage = rtrim(odbc_result($result,"vessel_voyage"));
            $userinput     = rtrim(odbc_result($result,"userinput"));
            $document_files = rtrim(odbc_result($result,"document_files"));
            $DONumber       = rtrim(odbc_result($result,"DONumber"));
                $datas = [
                "ID_document"        => $ID_document,
                "Tanggal"       => date_format($Tanggal,"d M Y"),
                "forwaderid"    => $forwaderid,
                "forwadername"  => $forwadername,
                "pc"            => $pc,
                "importer"      => $importer,
                "jenisbarang"   => $jenisbarang,
                "userinput"     => $userinput,
                "alamat"        =>$alamat,
                "consignee"     =>$consignee,
                "supplier"      =>$supplier.", ".$suppliername." (".$coderegion.")",
                "hscode"        =>$hscode,
                "jumlah_volume" =>$jumlah_volume,
                "pelabuhan_tujuan"=>$pelabuhan_tujuan,
                "eta"            =>date_format($eta,"d M Y"),
                "no_invoice"     =>$no_invoice,
                "shippingline"   =>$shippingline,
                "no_bl_awb"      =>$no_bl_awb,
                "container_no"   =>$container_no,
                "vessel_voyage"  =>$vessel_voyage,
                "document_files" =>$document_files,
                "DONumber"       =>$DONumber,
                "judul"          =>"SURAT PEMBERITAHUAN KEDATANGAN BARANG  IMPORT",
                "perihal"        =>" Pemberitahuan Permohonan Penanganan Barang Import",
                "hormat"         =>"Dengan hormat",
                "dengan_hormat"  => "Bersama ini kami informasikan bahwa perusahaan kami akan menerima kedatangan barang import dengan rincian sebagai berikut:",
                "informasi"      =>"Informasi Barang Import",
                "label_dokumen"  =>"Dokumen Terlampir",
                "info_forwader"  =>"Dengan ini kami mohon bantuan pihak forwader untuk :",
                 "detail_info_fowader"  => implode(",",$this->pihak_fowader),
                 "alamat_pengirim"      => "Jl. Raya Bogor KM 38 No.77, Kelurahan Sukamaju, Kecamatan Cilodong, Kota Depok, Provinsi Jawa Barat, Indonesia (Kode Pos: 16415)",
                 "info_tambahan"        => "Apabila ada dokumen atau informasi tambahan yang diperlukan, silakan hubungi kami pada kontak berikut:",
                  "up"                  =>"Up. Bagian Import Operation",
                  "nama_pengirim"       => "PUTRI",
                  "jabatan_pengirim"    => "Import Staff / Logistic Department",
                  "notelp_pengirim"     => "+62 812-XXXX-XXXX",
                  "email_pengirim"      => "import@bestmegaindustri.co.id"


                
            ];
        }

        return $datas;

    }



    public function GetListLaporan(){
         try {
        $rawData = file_get_contents("php://input");

        $post = json_decode($rawData, true);
     
         $tgl_from  	= $this->setdate($this->test_input($post["tgl_from"]));
         $tgl_to  	    = $this->setdate($this->test_input($post["tgl_to"]))." 23:59:59";
         $userid        = $this->test_input($post["userid"]);

        $status = ($userid == "wardi" || $userid == "herman") ? "Y" : "N";

        // Siapkan query SQL

        $query ="USP_TamplilListLaporanImport '{$status}','{$tgl_from}','{$tgl_to}', '{$userid}'";
        $result = $this->db->baca_sql2($query);
  
        if (!$result) {
            throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
        }

        $datas = [];
        while (odbc_fetch_row($result)) {
             $ItemNo        = rtrim(odbc_result($result, 'ItemNo'));
             $Tanggal       =new DateTime(rtrim(odbc_result($result, 'Tanggal')));
             $forwaderid    = rtrim(odbc_result($result, 'forwaderid'));
             $pc            = rtrim(odbc_result($result, 'pc'));
             $importer      = rtrim(odbc_result($result,"importer"));
             $jenisbarang   = rtrim(odbc_result($result,"jenisbarang"));
             $userinput   = rtrim(odbc_result($result,"userinput"));
             $FlagPosting  = rtrim(odbc_result($result,"FlagPosting"));
             $FlagPrint    = rtrim(odbc_result($result,"FlagPrint"));

            $datas[] = [
                "ItemNo"        => $ItemNo,
                "Tanggal"       => date_format($Tanggal,"d-m-y"),
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
}
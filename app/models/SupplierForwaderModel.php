<?php

class SupplierForwaderModel extends Models {
        private $tbl_sup ="[bambi-bmi].[dbo].supplier";


    public function Tampildata(){

         $file ="CustomerID,CustName";
        $table = $this->tbl_sup;
        $table .=" WHERE customerclass = 'FW' and custstatus = 1";
        $table .= $this->orderby("CustomerID");
        $query = $this->select($file,$table);
        $result = $this->db->baca_sql2($query);

 
        // $expload = explode(",",$file);
        // 
        $datas = [];
        while(odbc_fetch_row($result)){
                $id =rtrim(odbc_result($result,'CustomerID'));
                $name =rtrim(odbc_result($result,'CustName'));
            $datas[] =[
                "id"=>$id,
                "name"=>$id ." | ".$name
            ];
            }
        //  $this->consol_war($datas);
          return $datas;


    }


    public function getDataDetail(){
        try {
        $rawData = file_get_contents("php://input");

        $post = json_decode($rawData, true);
            
        $supplierID = $this->test_input($post["supplierID"]);
        // Siapkan query SQL
        $file ="CustCoName,CustAddress,CustTelpNo,HandPhone";
        $table = $this->tbl_sup;
        $table .=" WHERE CustomerID ='{$supplierID}'";
        $query = $this->select($file,$table);
        
        $result = $this->db->baca_sql2($query);
  

        // Validasi hasil eksekusi query
        if (!$result) {
            throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
        }

        // Ambil data hasil query
        $datas = [];
        while (odbc_fetch_row($result)) {
             $CustCoName = rtrim(odbc_result($result, 'CustCoName'));
             $CustAddress   = rtrim(odbc_result($result, 'CustAddress'));
             $CustTelpNo   = rtrim(odbc_result($result, 'CustTelpNo'));
             $HandPhone   = rtrim(odbc_result($result, 'HandPhone'));

            $datas[] = [
                "CustCoName"  => $CustCoName,
                "CustAddress" => $CustAddress,
                "NoTlpon" => $CustTelpNo."/".$HandPhone,
                
            ];
        }
      //  $this->consol_war($datas);
        return $datas;

    } catch (Exception $e) {
        // Catat error log untuk debug
        error_log("Error in GetKatgori: " . $e->getMessage());

        // Kembalikan array kosong jika gagal
        return [];
    }
    }

}
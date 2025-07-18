<?php
date_default_timezone_set('Asia/Jakarta');
class PotransactionModel extends Models{
    private $table ="[bambi-bmi].[dbo].POTRANSACTION";
    private $table_dtl ="[bambi-bmi].[dbo].POTRANSACTIONDETAIL";
    private $table_pack ="[bambi-bmi].[dbo].POPAKINGLIST_KURS";
    protected $table_trs ="[bambi-bmi].[dbo].forwarder_transactions";


    
   public function Tampilpobysup() {
    try {
        // Get raw data from the input
        $rawData = file_get_contents("php://input");
        $post = json_decode($rawData, true);
        
        // Get the current year and sanitize supplier ID
        $tahun = date("Y");
        $supplierId = $this->test_input($post["supplierID"]);
        
        // Prepare the SQL query
        $file = "A.DOTransacID, A.DONumber";
        $table = $this->table . " AS A ";
        $table .= " WHERE NOT EXISTS (
            SELECT 1
            FROM $this->table_pack AS B
            WHERE A.DONumber = B.NoPo 
        )";
        $table .= " AND NOT EXISTS (
            SELECT 1
            FROM $this->table_trs AS C
            WHERE A.DONumber = C.DONumber 
        ) AND suppid = '{$supplierId}'";
        // Uncomment the following line if you want to filter by year
        // $table .= " AND YEAR(DODate) = '$tahun'";
        
        // Add order by clause
        $table .= $this->orderby("DONumber");
        
        // Execute the query
        $query = $this->select($file, $table);
     
          // $this->consol_war($query);
        // Fetch results
        $result = $this->db->baca_sql2($query);
        $datas = [];
        
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "DOTransacID" => rtrim(odbc_result($result, 'DOTransacID')),
                "DONumber" => rtrim(odbc_result($result, 'DONumber')),
            ];
        }

        return $datas;

    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error in Tampilpobysup: " . $e->getMessage());

        // Return an empty array if an error occurs
        return [];
    }
  }

        
    public function TampilEditpobysup(){
        try{

      
        $rawData = file_get_contents("php://input");
        $post = json_decode($rawData, true);
        
        // Get the current year and sanitize supplier ID
        $tahun = date("Y");
        $supplierId = $this->test_input($post["supplierID"]);
        $file ="A.DOTransacID,A.DONumber";
        $table = $this->table." AS A";
        $table .=" WHERE suppid = '{$supplierId}'";
        $table .= $this->orderby("DONumber");
        $query = $this->select($file,$table);
        
     
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while(odbc_fetch_row($result)){
        
            $datas[] =[
                "DOTransacID"=>rtrim(odbc_result($result,'DOTransacID')),
                "DONumber"=>rtrim(odbc_result($result,'DONumber')),
            ];
            }

             
          return $datas;
        } catch  (Exception $e) {
        // Log the error for debugging
        error_log("Error in Tampilpobysup: " . $e->getMessage());

        // Return an empty array if an error occurs
        return [];
     }
 }



        public function TampilDetailpo($post){
                   
        $DOTransacID = $this->test_input($post["DOTransacID"]);
            $file ="ItemNo,Partid,PartName,quantity,satuan";
            $table = $this->table_dtl;
            $table .=" WHERE DOTransacID='".$DOTransacID."'";
            $table .= $this->orderby("ItemNo");
            $query = $this->select($file,$table);
           //die(var_dump($query));
            $result = $this->db->baca_sql2($query);

          
            $datas = [];
            while(odbc_fetch_row($result)){
            
                $datas[] =[
                    "ItemNo"=>rtrim(odbc_result($result,'ItemNo')),
                    "Partid"=>rtrim(odbc_result($result,'Partid')),
                    "PartName"=>rtrim(odbc_result($result,'PartName')),
                    "satuan"=>rtrim(odbc_result($result,'satuan')),
                    "qty"=>number_format(rtrim(odbc_result($result,'quantity')), 0, ',', ','),
                ];
                }
    
           
              //  $this->consol_war($datas);
              return $datas;
        }


  
}
<?php

class UserModel  extends Models{
     private $table ="[um_db].[dbo].a_user";





        public function TampilData($post){
        
            if(isset($post["search"]))
            {
                $query = "SELECT id_user as id, id_cust as text FROM $this->table WHERE cabang='99' AND id_cust LIKE '%".$post["search"]."%'";
            }else{
                $query = "SELECT id_user as id, id_cust as text FROM $this->table where cabang='99'";
            }

    
          

           $result = $this->db->baca_sql2($query);
    
          
          
            $fulldata = [];
            while(odbc_fetch_row($result)){
            
                $id=rtrim(odbc_result($result,'id'));
                    $text=rtrim(odbc_result($result,'text'));

                    $fulldata[]=array(
                        'id'=>$id, 
                        'text'=>$text
                    );
            }
             
              return $fulldata;

        }


        public function getUserEmail($id_user){
            $query ="SELECT email_user FROM $this->table WHERE id_user='".$id_user."'";
            $sql =$this->db->baca_sql($query);
		    $email_user=odbc_result($sql,"email_user");
            return $email_user;
        }


        public function getUserName($id_user){
          
            $query ="SELECT id_cust FROM $this->table WHERE id_user='".$id_user."'";
            $sql =$this->db->baca_sql($query);
		    $nama_user =odbc_result($sql,"id_cust");
            return $nama_user;
        }


        public function getUserPengirimEmail($userid){
            $query ="SELECT email_user FROM $this->table WHERE email='".$userid."'";
            $sql =$this->db->baca_sql($query);
		    $email_user =odbc_result($sql,"email_user");
            return $email_user;
        }
}

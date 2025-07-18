<?php
class PotransactionController extends Controller{

	private $model;
    private $model_ts; 

    public function __construct()
    {
        $this->model = $this->model('PotransactionModel');
    }


    public function getpo(){

		
        try {
            $data = $this->model->Tampilpobysup(); // Assuming this method exists in your model
            // Check if data is empty
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

    public function geteditpo(){
   
     
          try {
            $data = $this->model->TampilEditpobysup(); // Assuming this method exists in your model
            // Check if data is empty
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

	


       
}
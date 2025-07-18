import { baseUrl } from "../config.js";
import {pageMode} from "./main.js";
class Potransaction {
  
    constructor(id) {
    if (!id) return;
    this.supplierID = id;
    this.pageMode =pageMode;
    this.renderData();
  }

  async renderData() {
    const datas ={
      supplierID: this.supplierID
    }
      
     let  url=(this.pageMode === "edit" || this.pageMode === "post" || this.pageMode ==="detail" || this.pageMode ==="lap_d") ? "potrans/geteditpo" : "potrans/getpo" ;
    
    try {
      const response = await fetch(`${baseUrl}/router/seturl`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "url":url
        },
        body:JSON.stringify(datas)
      });


      const data_result = await response.json();
       if (data_result?.data) {
           $("#nopo").empty();
            const isEditMode = this.pageMode === "edit" || this.pageMode === "post" || this.pageMode ==="detail" || this.pageMode ==="lap_d";
           if(isEditMode){
                this.SetSelectedPO(data_result);
           }else{
                  const $nopo = $("#nopo");
                  $nopo.append('<option value="" disabled selected>Please Select</option>');
                  data_result.data.forEach(item => {
                      const { DONumber, DOTransacID } = item;
                      $nopo.append(`<option value="${DOTransacID}">${DONumber}</option>`);
                  });
           }
        } else {
          console.warn("Data tidak ditemukan di response.");
        }

    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Gagal mengambil data!",
        text: "Cek koneksi atau coba beberapa saat lagi."
      });
    }
  }


  SetSelectedPO(data_result){
    const DOTransacID_old = $("#DOTransacID_old").val();
    const $nopo = $("#nopo");
                  $nopo.append('<option value="" disabled selected>Please Select</option>');
                  data_result.data.forEach(item => {
                      const { DONumber, DOTransacID } = item;
                      let isSelected =(DOTransacID == DOTransacID_old) ? 'selected' : '';
                      $nopo.append(`<option value="${DOTransacID}" ${isSelected}>${DONumber}</option>`);
                  });
                



  }
}


export default Potransaction;
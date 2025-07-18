import GetSupplierForwader from './SuppleirForwader.js';
import AttachAdd from './AttachAdd.js';
import Simpdatdata from './Simpdatdata.js';
import {baseUrl} from '../config.js';
import Updatedata from './Updatedata.js';
import Potransaction from './Potransaction.js';
import PostingData from './Postingdata.js';
import Deletedata  from './Deletedata.js';
//import {initKeypresInput} from './KeypresInput.js';

let uploadedFiles = []; 
export let pageMode = "";
document.addEventListener('DOMContentLoaded', function() {
     pageMode = getPageMode();
   
    initializeDatePicker();
    initialzeButton();
    initializeSelect2();
    new AttachAdd(uploadedFiles);
    //initKeypresInput();

});

// === Helper untuk mengecek mode ===
function getPageMode() {
    const pathSegments = window.location.pathname.split("/").filter(Boolean);

   const lastSegment = pathSegments.pop();
    return lastSegment;
}


  function initialzeButton(){
     $('#supplierforwade').on('change', function() {
       const val = $(this).val();
       new GetSupplierForwader(val); // Kirim val sebagai parameter
    });

     $('#supplier').on('change', function() {
       const val = $(this).val();
       new Potransaction(val); // Kirim val sebagai parameter
    });

    $("#CreateAdd").on("click",function(even){
        even.preventDefault();
        new Simpdatdata(uploadedFiles);
    })

    $("#kembali ,#batal").on("click",function(even){
        even.preventDefault();
        goBack();
    });

    $("#Update").on("click",function(even){
        even.preventDefault();
        new Updatedata(uploadedFiles)
    })
  
    $("#DeleteData").on("click",function(event){
       
        event.preventDefault();
         Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Hapus Data Ini!",
                type: "warning",
                showDenyButton: true,
                confirmButtonColor: "#DD6B55",
                denyButtonColor: "#757575",
                confirmButtonText: "Ya, Hapus!",
                denyButtonText: "Tidak, Batal!",
              }).then((result) =>{
                if (result.isConfirmed) {
                    new Deletedata();
                }
            }) 

    
    })

    $("#Postingdata").on("click",function(even){
        even.preventDefault();
        new PostingData();
    })
      if(pageMode =="edit" || pageMode =="post" || pageMode ==="detail" || pageMode ==="lap_d"){
        const supplier = $("#supplier").val();
        new Potransaction(supplier);
   
      }
  
  
 }


 


function initializeDatePicker() {
  
    let dafaultgl="";
    let dafauleta="";
    if(pageMode =="edit" || pageMode =="post" || pageMode ==="detail" || pageMode ==="lap_d" ){
        let tanggal_old = $("#tanggal_old").val();
       dafaultgl =tanggal_old;
        let eta_old = $("#eta_old").val();
        dafauleta =eta_old;
    }else{
        dafaultgl =new Date();
        dafauleta = new Date();
    }

    flatpickr("#tanggal", {
        dateFormat: "d/m/Y", // Desired format
        allowInput: true, // Allow manual input
        defaultDate:dafaultgl 
    });
   flatpickr("#eta", {
        dateFormat: "d/m/Y", // Desired format
        allowInput: true, // Allow manual input
        defaultDate: dafauleta
    });
    
}

function initializeSelect2() {
    $('#supplierforwade').select2({
        width: '100%',
        dropdownAutoWidth: true,
        placeholder: 'Please Select',
        containerCssClass: "form-control",
        theme: 'bootstrap-5',
    });

      $('#supplier').select2({
        width: '100%',
        dropdownAutoWidth: true,
        placeholder: 'Please Select',
        containerCssClass: "form-control",
        theme: 'bootstrap-5',
    });

      $('#nopo').select2({
        width: '100%',
        dropdownAutoWidth: true,
        placeholder: 'Please Select',
        containerCssClass: "form-control",
        theme: 'bootstrap-5',
    });
}



export function goBack() {
    window.location.replace(`${baseUrl}/import`);
}


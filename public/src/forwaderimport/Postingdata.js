import { baseUrl } from "../config.js";
import {goBack} from "./main.js";
class PostingData {
    constructor() {
        this.Posting();
    }

    Posting() {
        const ItemNo       = $("#ItemNo").val();
        const ID_document  = $("#ID_document").val();
 
     
 
        
        

        
      


        const data ={
            "ItemNo"       :ItemNo,
            "ID_document"    :ID_document,

        }

       const  formData = new FormData();
       formData.append("datahider",JSON.stringify(data));
     

       this.prosesPosting(formData);

    }

    validateField(value, fieldSelector, errorSelector, errorMessage) {
        if (!value) {
            $(errorSelector).text(errorMessage);
            $(fieldSelector).focus();
            return false;
        } else {
            $(errorSelector).text("");
            return true;
        }
    }


        prosesPosting(formData) {
        // Tampilkan loading SweetAlert
        Swal.fire({
            title: "Proses Posting Data...",
            text: "Harap tunggu sebentar",
            allowOutsideClick: false,
            didOpen: () => {
            Swal.showLoading();
            }
        });

    
        // Kirim AJAX request
        $.ajax({
            url: `${baseUrl}/router/seturl`,
            method: 'POST',
             headers: {
                "url": "forimport/postingdata"
            },
            data: formData,
            processData: false,        // Penting: Jangan proses FormData
            contentType: false,        // Penting: Biar browser set otomatis
            dataType: 'json',
            success: function(result) {
            Swal.close(); // Tutup loading
            console.log("Respon dari server:", result);

            const nilai = result.nilai;
            const pesan = result.error;

            if (nilai == 0) {
                Swal.fire({
                icon: "info",
                title: pesan || "Gagal Posting",
                showConfirmButton: true
                });
            } else {
                Swal.fire({
                icon: "success",
                title: pesan || "Berhasil diposting",
                showConfirmButton: false,
                timer: 3000
                }).then(() => {
                goBack(); // Fungsi kembali halaman, jika ada
                });
            }
            },
            error: function(xhr, status, error) {
            Swal.close(); // Tutup loading
            console.error("AJAX Error:", error);
            Swal.fire({
                icon: "error",
                title: "Gagal Posting Data!",
                text: "Cek koneksi internet atau coba beberapa saat lagi."
            });
            }
        });
        }


}

export default PostingData;

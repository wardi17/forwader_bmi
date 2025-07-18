import { baseUrl } from "../config.js";
import {goBack} from "./main.js";
class Deletedata {
    constructor() {
      
       this.hapusData();
    }

    hapusData() {
       
        const ID_document    = $("#ID_document").val();
        const ItemNo         = $("#ItemNo").val();


        const datas ={
            "ID_document"    :ID_document,
            "ItemNo"         :ItemNo

        }
       this.prosesHapus(datas)

    }



 


        prosesHapus(datas) {
        // Tampilkan loading SweetAlert
        Swal.fire({
            title: "Loading Data...",
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
                "url": "forimport/deletedata"
            },
            data: JSON.stringify(datas),
            dataType: 'json',
            success: function(result) {
            Swal.close(); // Tutup loading
            console.log("Respon dari server:", result);

            const nilai = result.nilai;
            const pesan = result.error;

            if (nilai == 0) {
                Swal.fire({
                icon: "info",
                title: pesan || "Gagal menghapus",
                showConfirmButton: true
                });
            } else {
                Swal.fire({
                icon: "success",
                title: pesan || "Berhasil dihapus",
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
                title: "Gagal Hapus Data!",
                text: "Cek koneksi internet atau coba beberapa saat lagi."
            });
            }
        });
        }


}

export default Deletedata;

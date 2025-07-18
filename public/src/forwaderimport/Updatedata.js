import { baseUrl } from "../config.js";
import {goBack} from "./main.js";
class Updatedata {
    constructor(uploadedFiles) {
        this.uploadedFiles = uploadedFiles;
       this.putData();
    }

    putData() {
        const tanggal       = $("#tanggal").val();
        const forwaderid    = $("#supplierforwade").val();
        const pc            = $("#pc").val();
        const notelpon      = $("#notelpon").val();
        const alamat        = $("#alamat").val();
        const importer      = $("#importer").val();
        const consignee     = $("#consignee").val();
        const supplier      = $("#supplier").val();
        const jenisbarang   = $("#jenisbarang").val();
        const hscode        = $("#hscode").val();
        const jumlah_volume = $("#jumlah_volume").val();
        const pelabuhan_tujuan = $("#pelabuhan_tujuan").val();
        const eta           = $("#eta").val();
        const no_invoice    = $("#no_invoice").val();
        const shippingline  = $("#shippingline").val();
        const no_bl_awb     = $("#no_bl_awb").val();
        const container_no  = $("#container_no").val();
        const vessel_voyage = $("#vessel_voyage").val();
        const DOTransacID   = $("#nopo").val();
        const DONumber      = $("#nopo").find(":selected").text().trim();
        const nama_files_old = this.getAttachedFileNames();
        const ID_document    = $("#ID_document").val();
        const ItemNo         = $("#ItemNo").val();



 

        

        // Validate Forwader ID
        // if (!this.validateField(forwaderid, "#supplierforwade", "#supplierforwadeError", "Forwader harus dipilih")) {
        //     return;
        // }

        // // Validate Supplier
        // if (!this.validateField(supplier, "#supplier", "#supplierError", "Supplier harus dipilih")) {
        //     return;
        // }

        // // Validate Jenis Barang
        // if (!this.validateField(jenisbarang, "#jenisbarang", "#jenisbarangError", "Jenis barang harus diisi")) {
        //     return;
        // }

        // Get Forwader Name
        const str = $("#supplierforwade").find(":selected").text();
        const forwadername = str.split("|")[1].trim();

        //Get supplier name and  rigion
          const str2       = $("#supplier").find(":selected").text();
        const split_2      = str2.split("|")[1].trim();
        const suppliername = split_2.split(",")[0].trim();
        const coderegion   = split_2.split(",")[1].trim().replace(/[()]/g, '');
      


        const data ={
            "tanggal"       :tanggal,
            "forwaderid"    :forwaderid,
            "forwadername"  :forwadername,
            "pc"            :pc,
            "notelpon"      :notelpon,
            "alamat"        :alamat,
            "importer"      :importer,
            "consignee"     :consignee,
            "supplier"      :supplier,
            "suppliername"  :suppliername,
            "coderegion"    :coderegion,
            "jenisbarang"   :jenisbarang,
            "hscode"        :hscode,
            "jumlah_volume" :jumlah_volume,
            "pelabuhan_tujuan":pelabuhan_tujuan,
            "eta"            :eta,
            "no_invoice"     :no_invoice,
            "shippingline"   :shippingline,
            "no_bl_awb"      :no_bl_awb,
            "container_no"   :container_no,
            "vessel_voyage"  :vessel_voyage,
            "DOTransacID"    :DOTransacID,
            "DONumber"       :DONumber,
            "nama_files_old" :nama_files_old,
            "ID_document"    :ID_document,
            "ItemNo"         :ItemNo

        }

        // if(this.uploadedFiles.length === 0){
        //        Swal.fire({
        //               position: 'top-center',
        //               icon: "info",
        //               title:"Pilih Harus di upload dulu !!",
        //               showConfirmButton: true,
        //               // timer: 1500
        //             })
        // }

       const  formData = new FormData();
       formData.append("datahider",JSON.stringify(data));
       this.uploadedFiles.forEach(fileObj =>{
            formData.append("files[]",fileObj.file);
       })

       this.prosesUpdate(formData);

    }
getAttachedFileNames() {
  const container = document.getElementById('tampil_attach');
  const fileLinks = container.querySelectorAll('a.text-decoration-none');

  const fileNames = Array.from(fileLinks).map(link => link.textContent.trim());

  return fileNames;
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


        prosesUpdate(formData) {
        // Tampilkan loading SweetAlert
        Swal.fire({
            title: "Menyimpan Data...",
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
                "url": "forimport/updatedata"
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
                title: pesan || "Gagal mengupdate",
                showConfirmButton: true
                });
            } else {
                Swal.fire({
                icon: "success",
                title: pesan || "Berhasil diUpdate",
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
                title: "Gagal Update Data!",
                text: "Cek koneksi internet atau coba beberapa saat lagi."
            });
            }
        });
        }


}

export default Updatedata;

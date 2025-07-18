import { baseUrl } from "../config.js";

class GetSupplierForwader {
  
    constructor(id) {
    if (!id) return;
    this.supplierID = id;
    this.renderData();
  }

  async renderData() {
    const datas ={
      supplierID: this.supplierID
    }

    try {
      const response = await fetch(`${baseUrl}/router/seturl`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "url": "forimport/getdetail"
        },
        body:JSON.stringify(datas)
      });


      const data_result = await response.json();
       if (data_result && data_result.data) {
          const result = data_result.data[0];
          const importer ="PT BEST MEGA INDUSTRI";
              // Isi input dan textarea hanya jika field-nya ada
          $("#pc").val(result.CustCoName || '');
          $("#notelpon").val(result.NoTlpon || '');
          $("#alamat").val(result.CustAddress || '');
          $("#importer").val(importer || '');
          $("#consignee").val(importer || '');
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
}


export default GetSupplierForwader;
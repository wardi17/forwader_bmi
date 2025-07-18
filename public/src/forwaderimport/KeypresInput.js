
export default function initKeypresInput(){

      $("#supplierforwade").blur(function() {
  
        let supplierforwade = $(this).val();
        $("#supplierforwadeError").text("");
        $("#supplierforwade").removeClass('focusedInput');
        if (supplierforwade === ""  || supplierforwade === undefined) {
                $("#supplierforwadeError").text("forwade harus di Pilih");
                } else {
                $("#supplierforwade").text("");
                }

    });

 $("#supplier").blur(function() {
  
        let supplier = $(this).val();
        $("#supplierError").text("");
        $("#supplier").removeClass('focusedInput');
        if (supplier === ""  || supplier === undefined) {
                $("#supplierError").text("supplier harus di Pilih");
                } else {
                $("#supplier").text("");
                }

    });

 $("#jenisbarang").blur(function() {
    const supplier = $("#supplier").val();
    let jenisbarang = $(this).val();
    if (supplier === "") {
      $("#supplierError").text("supplier harus di Pilih");
      $("#supplier").addClass('focusedInput');
    }else{
      $("#supplierError").text("");
      $("#supplier").removeClass('focusedInput');
      if (jenisbarang === "") {
			  $("#jenisbarangError").text("jenisbarang harus di isi");
			} else {
			  $("#jenisbarangError").text("");
			}
    }
    });

$("#hscode").blur(function() {
    const jenisbarang = $("#jenisbarang").val();
    let hscode = $(this).val();
    if (jenisbarang === "") {
      $("#jenisbarangError").text("jenisbarang harus di isi");
      $("#jenisbarang").addClass('focusedInput');
    }else{
      $("#jenisbarangError").text("");
      $("#jenisbarang").removeClass('focusedInput');
      if (hscode === "") {
			  $("#hscodeError").text("hscode harus di isi");
			} else {
			  $("#hscodeError").text("");
			}
    }
    });

    $("#jumlah_volume").blur(function() {
    const hscode = $("#hscode").val();
    let jumlah_volume = $(this).val();
    if (hscode === "") {
      $("#hscodeError").text("hscode harus di isi");
      $("#hscode").addClass('focusedInput');
    }else{
      $("#hscodeError").text("");
      $("#hscode").removeClass('focusedInput');
      if (jumlah_volume === "") {
			  $("#jumlah_volumeError").text("jumlah_volume harus di isi");
			} else {
			  $("#jumlah_volumeError").text("");
			}
    }
    });


 $("#pelabuan_tujuan").blur(function() {
    const jumlah_volume = $("#jumlah_volume").val();
    let pelabuan_tujuan = $(this).val();
    if (jumlah_volume === "") {
      $("#jumlah_volumeError").text("jumlah_volume harus di isi");
      $("#jumlah_volume").addClass('focusedInput');
    }else{
      $("#jumlah_volumeError").text("");
      $("#jumlah_volume").removeClass('focusedInput');
      if (pelabuan_tujuan === "") {
			  $("#pelabuan_tujuanError").text("pelabuan_tujuan harus di isi");
			} else {
			  $("#pelabuan_tujuanError").text("");
			}
    }
    });

 $("#no_invoice").blur(function() {
    const pelabuan_tujuan = $("#pelabuan_tujuan").val();
    let no_invoice = $(this).val();
    if (pelabuan_tujuan === "") {
      $("#pelabuan_tujuanError").text("pelabuan_tujuan harus di isi");
      $("#pelabuan_tujuan").addClass('focusedInput');
    }else{
      $("#pelabuan_tujuanError").text("");
      $("#pelabuan_tujuan").removeClass('focusedInput');
      if (no_invoice === "") {
			  $("#no_invoiceError").text("no_invoice harus di isi");
			} else {
			  $("#no_invoiceError").text("");
			}
    }
    });


     $("#shippingline").blur(function() {
    const no_invoice = $("#no_invoice").val();
    let shippingline = $(this).val();
    if (no_invoice === "") {
      $("#no_invoiceError").text("no_invoice harus di isi");
      $("#no_invoice").addClass('focusedInput');
    }else{
      $("#no_invoiceError").text("");
      $("#no_invoice").removeClass('focusedInput');
      if (shippingline === "") {
			  $("#shippinglineError").text("shippingline harus di isi");
			} else {
			  $("#shippinglineError").text("");
			}
    }
    });
}
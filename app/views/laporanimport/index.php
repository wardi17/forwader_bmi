<?php


?>
<style>
    #thead{
        background-color:#E7CEA6 !important;
        /* font-size: 8px;
        font-weight: 100 !important; */
        /*color :#000000 !important;*/
      }
      .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
		  background-color: #F3FEB8;
		}

    /* .table-striped{
      background-color:#E9F391FF !important;
    } */
    .dataTables_filter{
		 padding-bottom: 20px !important;
	}
    #frompacking{
        width:100%;
        height: 2% !important;
      margin: 0 auto;
  }

</style>
<div id="main">
<header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
<div class ="col-md-12 col-12">
        <div class="card">
            <div class="card-body">
            <div  class="page-heading mb-3">
                  <div class="page-title">
                   <h6 class="text-start">Laporan Detail</h6>
                 
                <!-- <h6>Hari : <span id="harikerja"></span></h6> -->
                  </div>
                </div>
                <div id="filterdata" class="row col-md-12">
                <input type="hidden" id="usernama" class="form-control" value="<?=trim($data["userid"])?>">
                <div style="width:19%;" class="row col-md-4">
                        <label  style="width:30%;" class="col-sm-2 col-form-label">From</label>
                                    <div  style="width:70%;" class ="col-md-6">
                                       <input type="date" class=" form-control" id="tgl_from" name="tgl_from">
                                    </div>
						              </div>
                         
                            <div style="width:19%;" class="row col-md-4">
                            <label style="width:25%;" class="col-sm-2 col-form-label">To</label>
                                    <div style="width:70%;" class = "col-md-6">
                                       <input type="date" class=" form-control" id="tgl_to" name="tgl_to">
                                    </div>
                            </div>
                                  
                        <div style="width:10%;"  class="col-sm-2">
                                    <button  type="submit" name="submit" class="submit btn btn-primary me-1 mb-3" id="Createdata">Submit</button>
                                  </div>
      </div>
               
                <div id="tabellist"></div> 
          
            </div>
                               
            </div>
            </div>
        </div>
  </div>

  <script>
    $(document).ready(function(){
      gettanggal();
 const userid = $("#usernama").val();
      $("#Createdata").on("click",function(event){
            event.preventDefault();
            let tgl_to = $("#tgl_to").val();
            let tgl_from = $("#tgl_from").val();
             let datas ={
                "tgl_from":tgl_from,
                "tgl_to":tgl_to,
                "userid":userid   
             }

          
            getData(datas);
        })
    }) //document ready

  function  gettanggal(){
	  let currentDate = new Date();
    // Mengatur tanggal pada objek Date ke 1 untuk mendapatkan awal bulan
    currentDate.setDate(1);
    // Membuat format tanggal YYYY-MM-DD
    let tgl_from = currentDate.toISOString().slice(0,10);
    let id_from ="tgl_from";
    // Menampilkan hasil
  
	
    let d = new Date();
      let month = d.getMonth()+1;
      let day = d.getDate();
      let  tgl_to =  d.getFullYear() +'-'+
					(month<10 ? '0' : '') + month + '-' +
				 (day<10 ? '0' : '') + day;
   
      let id_tgl_to ="tgl_to";
      SetTanggal(id_from,tgl_from)
      SetTanggal(id_tgl_to,tgl_to)

 

}

    SetTanggal=(id,tanggal)=>{
      
      let setid ="#"+id;
      flatpickr(setid, {
                  dateFormat: "d/m/Y", // Format yang diinginkan
                  allowInput: true ,// Memungkinkan input manual
                  defaultDate: new Date(tanggal)
              });
        
    }

  function getData(datas){

    $.ajax({
                  url:"<?=base_url?>/router/seturl",
                  data:JSON.stringify(datas),
                  method:"POST",
                  dataType: "json",
                  headers:{'url':'lapimport/getlaporan'},
                  success:function(result){
                    const data_result = result.data;
                    Set_Tabel(data_result);
                      
  
                  }
      });
  }

   function Set_Tabel(data_result) {
   
    let userid = $("#usernama").val();
    let datatabel = ``;

    datatabel += `
        <table id="tabel1" class='table table-striped table-hover' style='width:100%'>                    
            <thead id='thead' class='thead'>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Forwader ID</th>
                    <th>Importer</th>
                    <th>Jenis Barang</th>
                    <th>PC</th>
                    <th>User</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
    `;

    let no = 1;
    $.each(data_result, function(a, b) {
        datatabel += `
            <tr>
                <td>${no++}</td>
                <td style="width:10%">${b.Tanggal}</td>
                <td>${b.forwaderid}</td>
                <td>${b.importer}</td>
                <td>${b.jenisbarang}</td>
                <td>${b.pc}</td>
                <td>${b.userinput}</td>
        `;

            datatabel += `
                <td>
                    <form  id="frompacking" role="form" action="<?= base_url; ?>/laporanimport/lap_d" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="ItemNo" value="${b.ItemNo}">
                        <button  type="submit" class="btn btn-primary" title="Detail">
                            <i class="fa-solid fa-file-pen"></i>
                        </button>
                    </form>
                </td>
            `;
       

        datatabel += `</tr>`;
    });

    datatabel += `</tbody></table>`;
    $("#tabellist").empty().html(datatabel);
    Tampildatatabel();
}

        function  Tampildatatabel(){

          const id = "#tabel1";
          $(id).DataTable({
              order: [[0, 'asc']],
                responsive: true,
                "ordering": true,
                "destroy":true,
                pageLength: 5,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                fixedColumns:   {
                     // left: 1,
                      right: 1
                  },
                  
              })
        }

</script>
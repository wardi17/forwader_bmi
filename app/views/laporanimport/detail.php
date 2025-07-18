<?php
$userid = htmlspecialchars($data["userid"], ENT_QUOTES, 'UTF-8');
$supplierforwade = $data["supplierforwade"];
$supplier        = $data["supplier"];
$items           = $data["item"];
$selectedSupplierId = $items["supplierid"]; 
$selectedforwaderid = $items["forwaderid"];
$document        = $items["document_files"];

?>

<style>
     /* Untuk Chrome, Safari, Edge, dan Opera */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Untuk Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

.error {
  color: red;
}
    input[type="file"] {
        display: none;
    }
    .error {
        color: red;
    }
    .ldBar path.mainline {
        stroke-width: 10;
        stroke: #09f;
        stroke-linecap: round;
    }
    .ldBar path.baseline {
        stroke-width: 14;
        stroke: #f1f2f3;
        stroke-linecap: round;
        filter: url(#custom-shadow);
    }
    .loading-spinner {
        width: 30px;
        height: 30px;
        border: 2px solid indigo;
        border-radius: 50%;
        border-top-color: #0001;
        display: inline-block;
        animation: loadingspinner .7s linear infinite;
    }
    @keyframes loadingspinner {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .thead {
        background-color: #E7CEA6;
    }
    .table-hover tbody tr:hover td,
    .table-hover tbody tr:hover th {
        background-color: #F5DE14FF !important;
    }
    .table-striped > tbody > tr:nth-child(2n+1) > td,
    .table-striped > tbody > tr:nth-child(2n+1) > th {
        background-color: #BFECFF !important;
    }
    .focusedInput {
        border-color: rgba(82, 168, 236, .8);
        outline: 0;
        outline: thin dotted \9;
        box-shadow: 0 0 8px rgba(82, 168, 236, .6) !important;
    }
</style>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div id="formhider" class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="row col-md-12">
                    <div class="col-md-1">
                        <button id="kembali_lapdetail" type="button" class="btn btn-lg text-start">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    </div>
                    <div class="col-md-11">
                        <h5 class="text-center">Detail Data</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" id="username" class="form-control" value="<?= $userid ?>">
                <input type="hidden" id="tanggal_old" class="form-control" value="<?=$items["Tanggal"]?>">
                <input type="hidden" id="eta_old" class="form-control" value="<?=$items["eta"]?>">
                <input type="hidden" id="document_old" class="form-control" value="<?=$document?>"> 
                <input type="hidden" id="ItemNo" class="form-control" value="<?=$items["ItemNo"]?>">
                <input type="hidden" id="ID_document" class="form-control" value="<?=$items["ID_document"]?>">
                <input type="hidden" id="DOTransacID_old" class="form-control" value="<?=$items["DOTransacID"]?>">
                <form>
                    <!-- Date Input -->
                    <div class="row mb-2">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-2">
                            <input type="date" disabled id="tanggal"  class="form-control">
                        </div>
                    </div>

                    <!-- Forwader Selection -->
                    <div class="row mb-2">
                        <label for="supplierforwade" class="col-sm-2 col-form-label">Forwader</label>
                        <div class="col-sm-4">
                            <select disabled class="form-control" id="supplierforwade">
                                <option value="" disabled selected>Please Select</option>
                                <?php foreach ($supplierforwade as $file): 
                                    $kode = htmlspecialchars($file["id"], ENT_QUOTES, 'UTF-8');
                                    $nama = htmlspecialchars($file["name"], ENT_QUOTES, 'UTF-8');
                                     $isSelected = ($kode == $selectedforwaderid) ? 'selected' : '';
                                ?>
                                    <option value="<?= $kode ?>" <?= $isSelected ?> ><?= $nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="supplierforwadeError" class="error"></span>
                        </div>
                    </div>

                    <!-- PC Input -->
                    <div class="row mb-2">
                        <label for="pc" class="col-sm-2 col-form-label">PC</label>
                        <div class="col-sm-2">
                            <input disabled type="text" value="<?=$items["pc"]?>" id="pc" class="form-control">
                        </div>
                        <span id="pcError" class="error"></span>
                    </div>

                    <!-- Phone Number Input -->
                    <div class="row mb-2">
                        <label for="notelpon" class="col-sm-2 col-form-label">No Telpon</label>
                        <div class="col-sm-4">
                            <input disabled type="text"  value="<?=$items["notelpon"]?>" id="notelpon" class="form-control">
                        </div>
                        <span id="notelponError" class="error"></span>
                    </div>

                    <!-- Address Input -->
                    <div class="row mb-2">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-4">
                            <textarea disabled style="width: 150%;" id="alamat"  value="<?=$items["alamat"]?>" class="form-control"><?=$items["alamat"]?></textarea>
                            <span id="alamatError" class="error"></span>
                        </div>
                    </div>

                    <h6 class="mt-4"><i class="bi bi-box"></i> Import masih Barang Impor</h6>

                    <!-- Importer Input -->
                    <div class="row mb-2">
                        <label for="importer" class="col-sm-2 col-form-label">Importer</label>
                        <div class="col-sm-4">
                            <input disabled type="text" value="<?=$items["importer"]?>" id="importer" class="form-control">
                        </div>
                        <span id="importerError" class="error"></span>
                    </div>

                    <!-- Consignee Input -->
                    <div class="row mb-2">
                        <label for="consignee" class="col-sm-2 col-form-label">Consignee</label>
                        <div class="col-sm-4">
                            <input disabled type="text" value="<?=$items["consignee"]?>" id="consignee" class="form-control">
                        </div>
                        <span id="consigneeError" class="error"></span>
                    </div>

                    <!-- Supplier Selection -->
                    <div class="row mb-2">
                        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
                   <div class="col-sm-6">
                        <select  disabled class="form-control" id="supplier" name="supplier_id">
                            <option value="" disabled <?= empty($selectedSupplierId) ? 'selected' : '' ?>>Please Select</option>
                            <?php foreach ($supplier as $file): 
                                $kode = htmlspecialchars($file["id"], ENT_QUOTES, 'UTF-8');
                                $nama = htmlspecialchars($file["name"], ENT_QUOTES, 'UTF-8');
                                $isSelected = ($kode == $selectedSupplierId) ? 'selected' : '';
                            ?>
                                <option value="<?= $kode ?>" <?= $isSelected ?>><?= $nama ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span id="supplierError" class="error"></span>
                    </div>
                    </div>
                    <div id="selectpo"   class="row mb-12 mb-2">
                                        <label for="nopo" class="col-sm-2 col-form-label">NO PO</label>
                                                  <div  class=" col-sm-4">
                                                              <select disabled class="form-control" id="nopo">
                                                            </select>
                                                    <span id="nopoError" class="error"></span>
                       </div>
                    </div>
                    <!-- Item Type Input -->
                    <div class="row mb-2">
                        <label for="jenisbarang" class="col-sm-2 col-form-label">Jenis Barang</label>
                        <div class="col-sm-2">
                            <input  type="text" disabled value="<?=$items["jenisbarang"]?>"  id="jenisbarang" class="form-control">
                        </div>
                        <span id="jenisbarangError" class="error"></span>
                    </div>

                    <!-- HS Code Input -->
                    <div class="row mb-2">
                        <label for="hscode" disabled class="col-sm-2 col-form-label">HS code</label>
                        <div class="col-md-2">
                            <input type="text" disabled value="<?=$items["hscode"]?>" id="hscode" class="form-control">
                        </div>
                        <span id="hscodeError" class="error"></span>
                    </div>

                    <!-- Quantity & Volume Input -->
                    <div class="row mb-2">
                        <label for="jumlah_volume" class="col-sm-2 col-form-label">Jumlah & Volume</label>
                        <div class="col-md-2">
                            <input type="text" disabled value="<?=$items["jumlah_volume"]?>" id="jumlah_volume" class="form-control">
                        </div>
                        <span id="jumlah_volumeError" class="error"></span>
                    </div>

                    <!-- Destination Port Input -->
                    <div class="row mb-2">
                        <label for="pelabuhan_tujuan" class="col-sm-2 col-form-label">Pelabuhan Tujuan</label>
                        <div class="col-md-4">
                            <input type="text" disabled value="<?=$items["pelabuhan_tujuan"]?>" class="form-control" id="pelabuhan_tujuan">
                        </div>
                        <span id="pelabuhan_tujuanError" class="error"></span>
                    </div>

                    <!-- ETA Input -->
                    <div class="row mb-2">
                        <label for="eta" class="col-sm-2 col-form-label">ETA</label>
                        <div class="col-md-2">
                            <input type="date" disabled id="eta"  class="form-control">
                        </div>
                        <span id="etaError" class="error"></span>
                    </div>

                    <!-- Invoice Number Input -->
                    <div class="row mb-2">
                        <label for="no_invoice" class="col-sm-2 col-form-label">No.Invoice</label>
                        <div class="col-md-4">
                            <input class="form-control" disabled value="<?=$items["no_invoice"]?>" id="no_invoice">
                        </div>
                        <span id="no_invoiceError" class="error"></span>
                    </div>

                    <!-- Shipping Line Input -->
                    <div class="row mb-2">
                        <label for="shippingline" class="col-sm-2 col-form-label">Shipping Line</label>
                        <div class="col-md-4">
                            <input type="text" disabled value="<?=$items["shippingline"]?>"  id="shippingline" class="form-control">
                        </div>
                        <span id="shippinglineError" class="error"></span>
                    </div>

                    <!-- BL/AWB Number Input -->
                    <div class="row mb-2">
                        <label for="no_bl_awb" class="col-sm-2 col-form-label">No Bl/AWB</label>
                        <div class="col-md-4">
                            <input type="text" disabled id="no_bl_awb" value="<?=$items["no_bl_awb"]?>"  class="form-control">
                        </div>
                        <span id="nobl_awbError" class="error"></span>
                    </div>

                    <!-- Container Number Input -->
                    <div class="row mb-2">
                        <label for="container_no" class="col-sm-2 col-form-label">Container No.</label>
                        <div class="col-md-4">
                            <input type="text" disabled id="container_no" value="<?=$items["container_no"]?>"  class="form-control">
                        </div>
                        <span id="container_noError" class="error"></span>
                    </div>

                    <!-- Vessel/Voyage Input -->
                    <div class="row mb-2">
                        <label for="vessel_voyage" class="col-sm-2 col-form-label">Vessel/Voyage</label>
                        <div class="col-md-4">
                            <input type="text" disabled id="vessel_voyage" value="<?=$items["vessel_voyage"]?>"  class="form-control">
                        </div>
                        <span id="vessel_voyageError" class="error"></span>
                    </div>

                    <!-- Document Attachment -->
                    <div class="row mb-2">
                        <label for="attach" class="col-sm-2 col-form-label">Dokumen Terlampir</label>
                        <div style="display:none;" class="col-sm-8 mt-0">
                            <label style="cursor: pointer;" for="attach">
                                <i class="fa-solid fa-file-arrow-up fa-2x"></i>
                                <input class="col-md-1"  id="attach" type="file" multiple>
                            </label>
                        </div>
                        <div id="tampil_attach" class="row mt-0"></div>
                    </div>
                    <div class="col-md-6 text-end mt4">
                                           <button  class="btn btn-secondary me-1 mb-3" id="batal_lapdetail">Kembali</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
      $(document).on("click","#kembali_lapdetail ,#batal_lapdetail",function(even){
        even.preventDefault();
        goBackDetail();
    });


    function goBackDetail() {
    window.location.replace(`<?=base_url?>/laporanimport`);
}
</script>
<script type="module" src="<?= base_url; ?>/src/forwaderimport/main.js"></script> 

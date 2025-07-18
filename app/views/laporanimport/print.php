<?php

class FPDF_AutoWrapTable extends FPDF
{
    private $data = [];
    private $options = [
        'filename' => '',
        'destinationfile' => '',
        'paper_size' => 'A4',
        'orientation' => 'P'
    ];

    public function __construct($data = [], $options = [])
    {
        parent::__construct();
        $this->data = $data;
        $this->options = $options;
    }

    // Jarak atas untuk header
    private $headerMargin = 10;
    public function Header()
    {
        // Set posisi Y untuk header
        $this->SetY($this->headerMargin);

        // Set font untuk header
        $this->SetFont('Arial', 'B', 12);

        // Cetak judul
        $this->Cell(0, 10, '', 0, 1, 'C');

        // Kembali ke posisi Y setelah header
        $this->SetY($this->headerMargin + 10); // Menambahkan jarak tambahan jika diperlukan
    }

    public function rptDetailData()
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = $this->data["datas"];
        $this->AddPage();
        $this->SetAutoPageBreak(true, 30);
        $this->AliasNbPages();

        // Header information
        $judul          = $data["judul"];
        $ID_document    = $data["ID_document"];
        $Tanggal        = $data["Tanggal"];
        $perihal        = $data["perihal"];
        $hormat         = $data["hormat"];
        $dengan_hormat  = $data["dengan_hormat"];
        $pc             = $data["pc"];
        $forwadername   = $data["forwadername"];
        $alamat         = $data["alamat"];
        $informasi      = $data["informasi"];
        $importer       = $data["importer"];
        $consignee      = $data["consignee"];
        $supplier       = $data["supplier"];
        $jenisbarang    = $data["jenisbarang"];
        $hscode         = $data["hscode"];
        $jumlah_volume  = $data["jumlah_volume"];
        $pelabuhan_tujuan = $data["pelabuhan_tujuan"];
        $eta            = $data["eta"];
        $no_invoice     = $data["no_invoice"];
        $shippingline   = $data["shippingline"];
        $no_bl_awb      = $data["no_bl_awb"];
        $container_no   = $data["container_no"];
        $vessel_voyage = $data["vessel_voyage"];
        $label_dokumen  = $data["label_dokumen"];
        $document_files = $data["document_files"];
        $info_forwader  = $data["info_forwader"];
        $detail_info_fowader = $data["detail_info_fowader"];
        $alamat_pengirim     = $data["alamat_pengirim"];
        $info_tambahan       = $data["info_tambahan"];
        $up                  = $data["up"];
        $nama_pengirim       = $data["nama_pengirim"];
        $jabatan_pengirim    = $data["jabatan_pengirim"];
        $notelp_pengirim     = $data["notelp_pengirim"];
        $email_pengirim      = $data["email_pengirim"];
        $DONumber            = $data["DONumber"];


        $this->Ln(5);
        // Set font and print title
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(180, 5, $judul, 0, 1, 'L');
        // $this->Cell(190, 1, str_repeat("_", 200), 0, 0, 'C');
        $this->Cell(2, 5, '', 0, 1);

        // Print document details
        $this->printDetail('No. Dokumen', $ID_document, 50);
        $this->printDetail('Tanggal', $Tanggal, 50);
        $this->printDetail('Perihal', $perihal, 100);

        $this->Ln(5);
        // Kepada Yth. section
        $this->printRecipientSection($hormat, $dengan_hormat, $pc, $forwadername, $up, $alamat);
        $this->Ln(5);
        // Content section
        $this->printContentSection($informasi);
        $this->Ln(5);
        //detail 
        $this->printDetailIformasi('Importer', $importer, 50);
        $this->Ln(2);
        $this->printDetailIformasi('Consignee', $consignee, 50);
        $this->Ln(2);
        $this->printDetailIformasi('Supplier', $supplier, 120);
        $this->Ln(2);
        $this->printDetailIformasi('NO.PO', $DONumber, 100);
        $this->Ln(2);
        $this->printDetailIformasi('Jenis Barang', $jenisbarang, 50);
        $this->Ln(2);
        $this->printDetailIformasi('HS Code', $hscode, 50);
        $this->Ln(2);
        $this->printDetailIformasi('Jumlah & Volume', $jumlah_volume, 50);
        $this->Ln(2);
        $this->printDetailIformasi('Pelabuhan Tujuan', $pelabuhan_tujuan, 50);
        $this->Ln(2);
        $this->printDetailIformasi('ETA', $eta, 50);
        $this->Ln(2);
        $this->printDetailIformasi('No. Invoice', $no_invoice, 50);
        $this->Ln(2);
        $this->printDetailIformasi('Shipping Line', $shippingline, 50);
        $this->Ln(2);
        $this->printDetailIformasi('NO. BL/ AWB', $no_bl_awb, 50);
        $this->Ln(2);
        $this->printDetailIformasi('Container NO.', $container_no, 50);
        $this->Ln(2);
        $this->printDetailIformasi('Vessel / Voyage', $vessel_voyage, 50);

        $this->Ln(5);
        // dolumen telampir
        if (isset($document_files) && !empty($document_files)) {
            $this->printContentSection($label_dokumen);
            $this->Ln(2);
            $this->printdokumenttelampir($document_files);
            $this->Ln(5);
        }
        // info forwader
        $this->printContentinfo_forwader($info_forwader);
        $this->Ln(2);
        $this->printdetail_info_fowader($detail_info_fowader);
        $this->printAlm_kirimContentSection($alamat_pengirim);
        $this->Ln(2);
        $this->printContentinfo_forwader($info_tambahan);
        $this->Ln(2);
        //  footerd 
        $this->printContainerHormatkmai();
        $this->Ln(2);
        $this->printContentinfo_forwader($importer);
        $this->printContentinfo_forwader($nama_pengirim);
        $this->printContentinfo_forwader($jabatan_pengirim);
        $this->printContentinfo_forwader($notelp_pengirim);
        $this->printContentinfo_forwader($email_pengirim);
    }

    private function printContainerHormatkmai()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 5, 'Hormat kami,', 0, 1, 'L');
    }

    private function printDetail($label, $value, $lebar)
    {
        $this->SetFont('Arial', 'B', 10);
        $y = $this->GetY();
        $x = $this->GetX();
        $width = 30;

        $this->MultiCell($width, 5, $label, 0, 'L', false);
        $this->SetXY($x + $width, $y);
        $this->MultiCell(3, 5, ':', 0, 'L', false);
        $this->SetXY($x + $width + 3, $y);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell($lebar, 5, $value, 0, 'L', false);
    }

    private function printRecipientSection($hormat, $dengan_hormat, $pc, $forwadername, $up, $alamat)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 5, 'Kepada Yth.', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 5, $pc, 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 5, $forwadername, 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 5, $up, 0, 1, 'L');
        $this->Cell(30, 5, $alamat, 0, 1, 'L');

        $this->Ln(3);
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 5, $hormat . ",", 0, 1, 'L');
        $this->Ln(2);

        $this->MultiCell(0, 5, $dengan_hormat, 0, 'L');
    }

    private function printContentSection($informasi)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->MultiCell(0, 5, $informasi, 0, 'J');
    }

    private function printContentinfo_forwader($informasi)
    {
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, $informasi, 0, 'J');
    }

    private function printAlm_kirimContentSection($informasi)
    {
        $this->SetFont('Arial', 'B', 10);
        $y = $this->GetY();
        $x = $this->GetX();
        $this->SetXY($x + 5, $y);
        $this->MultiCell(150, 5, $informasi, 0, 'J');
    }

    private function printDetailIformasi($label, $value, $lebar)
    {
        $this->SetFont('Arial', 'B', 10);
        $y = $this->GetY();
        $x = $this->GetX();
        $width = 35;

        $this->MultiCell($width, 5, $label, 0, 'L', false);
        $this->SetXY($x + $width, $y);
        $this->MultiCell(3, 5, ':', 0, 'L', false);
        $this->SetXY($x + $width + 3, $y);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell($lebar, 5, $value, 0, 'L', false);
    }

    private function printdokumenttelampir($document_files)
    {

        if (isset($document_files) && !empty($document_files)) {
            $dokumenList = explode(",", $document_files);

            foreach ($dokumenList as $dokumen) {
                // Atur font untuk bullet/titik
                $firstPart = strtok($dokumen, '.');
                $this->SetFont('Arial', 'B', 10);
                $y = $this->GetY();
                $x = $this->GetX();
                $bulletWidth = 3;

                // Cek apakah posisi Y mendekati batas bawah halaman
                if ($y + 5 > $this->GetPageHeight() - $this->bMargin) {
                    $this->AddPage(); // Tambah halaman baru
                    $y = $this->GetY(); // Dapatkan posisi Y baru setelah menambah halaman
                }

                // Cetak bullet/titik
                $this->MultiCell($bulletWidth, 5, ".", 0, 'L', false);

                // Geser posisi X setelah bullet
                $this->SetXY($x + $bulletWidth, $y);

                // Atur font untuk isi dokumen
                $this->SetFont('Arial', '', 10);
                if ($y + 5 > $this->GetPageHeight() - $this->bMargin) {
                    $this->AddPage(); // Tambah halaman baru jika perlu
                    $y = $this->GetY(); // Dapatkan posisi Y baru setelah menambah halaman
                }
                $this->MultiCell(100, 5, rtrim($firstPart), 0, 'L', false);
            }
        }
    }


    private function printdetail_info_fowader($info)
    {
        if (isset($info)) {
            $infoList = explode(",", $info);

            $no = 1;
            foreach ($infoList as $item) {
                // Atur font untuk bullet/titik
                $this->SetFont('Arial', 'B', 10);
                $y = $this->GetY();
                $x = $this->GetX();
                $bulletWidth = 5;

                // Cetak bullet/titik
                $this->MultiCell($bulletWidth, 5, $no++ . ".", 0, 'L', false);

                // Geser posisi X setelah bullet
                $this->SetXY($x + $bulletWidth, $y);

                // Atur font untuk isi dokumen
                $this->SetFont('Arial', '', 10);
                $this->MultiCell(150, 5, $item, 0, 'L', false);
            }
        }
    }


    public function printPDF()
    {
        if ($this->options['paper_size'] == "F4") {
            $a = 8.3 * 72; // 1 inch = 72 pt
            $b = 13.0 * 72;
            new FPDF($this->options['orientation'], "pt", [$a, $b]);
        } else {
            $this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
        }

        $this->SetAutoPageBreak(false);
        $this->AliasNbPages();
        $this->SetFont("helvetica", "B", 10);
        $this->rptDetailData();
        $this->Output($this->options['filename'], $this->options['destinationfile']);
    }

    private $widths;
    private $aligns;

    public function SetWidths($w)
    {
        $this->widths = $w;
    }

    public function SetAligns($a)
    {
        $this->aligns = $a;
    }

    public function Row($data)
    {
        $nb = 0;
        foreach ($data as $i => $value) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $value));
        }
        $h = 5 * $nb;

        $this->CheckPageBreak($h);

        foreach ($data as $i => $value) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();

            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 5, $value, 1, $a);
            $this->SetXY($x + $w, $y);
        }

        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    public function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;

        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    private function replace_name($data)
    {
        return str_replace("&amp;", "", $data);
    }
} // End of class



// Options for PDF generation
$options = [
    'filename' => '', // Name of the file to save, leave empty for browser output
    'destinationfile' => '', // I=inline browser (default), F=local file, D=download
    'paper_size' => 'F4', // Paper size: F4, A3, A4, A5, Letter, Legal
    'orientation' => 'P' // Orientation: P=portrait, L=landscape
];

$tabel = new FPDF_AutoWrapTable($data, $options);
$tabel->printPDF();

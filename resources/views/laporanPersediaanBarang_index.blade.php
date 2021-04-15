<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new PDF("L","cm","A4");

$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
$pdf->SetX(4);            
$pdf->MultiCell(19.5,0.5,'TOKO ANDATU 5758',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'Telpon : 08562345394',0,'L');    
$pdf->SetFont('Arial','B',10);
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'JL. SADANG NO. 103, BANDUNG, JAWA BARAT',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'email : andatutrading5758@gmail.com',0,'L');
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(25.5,0.7,"Laporan Persediaan Barang",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Di cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Kode Barang', 1, 0, 'C');
$pdf->Cell(7, 0.8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(4.5, 0.8, 'Qty', 1, 0, 'C');
$pdf->Cell(4.5, 0.8, 'Santuan', 1, 0, 'C');
$pdf->Cell(4.5, 0.8, 'Harga Beli', 1, 0, 'C');
$pdf->Cell(4.5, 0.8, 'Harga Jual', 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$no=1;
$query=mysql_query("select * from barang");
while($lihat=mysql_fetch_array($query)){
	$pdf->Cell(1, 0.8, $no , 1, 0, 'C');
	$pdf->Cell(7, 0.8, $lihat['nama'],1, 0, 'C');
	$pdf->Cell(3, 0.8, $lihat['jenis'], 1, 0,'C');
	$pdf->Cell(4, 0.8, $lihat['suplier'],1, 0, 'C');
	$pdf->Cell(4.5, 0.8, $lihat['modal'], 1, 0,'C');
	$pdf->Cell(4.5, 0.8, $lihat['harga'],1, 0, 'C');
	$pdf->Cell(2, 0.8, $lihat['jumlah'], 1, 1,'C');

	$no++;
}

$pdf->Output("laporan_buku.pdf","I");

?>
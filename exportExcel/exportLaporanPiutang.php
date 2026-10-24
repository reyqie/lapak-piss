<?php
    include "../connection.php";
    require_once '../libs/PHPExcel/Classes/PHPExcel.php'; 
    // Load library PHPExcel

	$year	= date('Y');
	$mtype	= $_POST['mtype'];
	$date 	= date("d M Y");

    // Query untuk mengambil data
    if($mtype=='Semua'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$totalMerchant = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif'");
	}
	elseif($mtype=='Buah'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		m.merchant_type = 'Buah' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$totalMerchant = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		m.merchant_type = 'Buah'");
	}
	elseif($mtype=='Sayur'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		m.merchant_type = 'Sayur' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$totalMerchant = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		m.merchant_type = 'Sayur'");
	}
	elseif($mtype=='Lainnya'){
		$sql = "select m.merchant_id, m.merchant_name 
		from merchant m, lapak l, rent r
		where m.merchant_id = r.merchant_id and
		l.lapak_id = r.lapak_id and
		m.merchant_status = 'Aktif' and
		m.merchant_type = 'Lainnya' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		group by m.merchant_id
		order by l.block_id, l.lapak_no";
		$totalMerchant = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		m.merchant_type = 'Lainnya'");
	}

    $query 	= mysql_query($sql);

    // Buat objek PHPExcel
    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle("Laporan Data Piutang");

    // Menulis Informasi di Atas Tabel
    $sheet->setCellValue("A1", "LAPORAN DATA PIUTANG PER PEDAGANG");
    $sheet->setCellValue("A3", "JUMLAH PEDAGANG");
    $sheet->setCellValue("A4", "JENIS PEDAGANG");
    $sheet->setCellValue("B3", " : ");
    $sheet->setCellValue("B4", " : ");
    $sheet->setCellValue("C3", $totalMerchant . ' Orang');
    $sheet->setCellValue("C4",$mtype);

    // Membuat text bold
    $sheet->getStyle("A1:B4")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A1:B4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A3:A4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    // Merge cell
    $sheet->mergeCells("A1:H1");

    // Menulis header
    $sheet->setCellValue("A6", "NO")
          ->setCellValue("B6", "KODE")
          ->setCellValue("C6", "NAMA PEDAGANG")
          ->setCellValue("D6", "LAPAK")
          ->setCellValue("E6", "LUAS")
          ->setCellValue("F6", "TOTAL HARGA (RP)")
          ->setCellValue("G6", "UANG MUKA (RP)")
          ->setCellValue("H6", "PIUTANG (RP)");

    // Mengatur warna latar belakang hijau untuk header
    // $sheet->getStyle('A6:I6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle('A6:I6')->getFill()->getStartColor()->setRGB('7FBF7F'); // Warna Hijau

    // Membuat Text Bold
    $sheet->getStyle("A6:H6")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah, kecuali kolom E (Pedagang)
    $sheet->getStyle('A6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no			= 1;
    $row        = 7;

    // Looping untuk mengambil dan menuliskan data
    while ($data = mysql_fetch_array($query)) {
        $sql2 	= mysql_query("select l.lapak_name from rent r, lapak l
					where r.lapak_id = l.lapak_id and 
					r.merchant_id = '".$data['merchant_id']."' and
					r.rent_sts2 != 'Pindah'
					order by l.lapak_no desc ");
					$string	= "";
					$counter= 0;
					while($dataLapak=mysql_fetch_array($sql2)){
						if($counter!=0){
							$string = ", ".$string;
						}
						$string = $dataLapak['lapak_name'].$string;
						$counter++;
					}
					$lapak 	= "".$string;
					
					$sql3 	= mysql_query("select sum(l.lapak_size) as size, sum(l.lapak_total) as total,
					sum(r.rent_dp) as dp, sum(r.leftover) as lo
					from rent r, lapak l
					where r.lapak_id = l.lapak_id and 
					r.merchant_id = '".$data['merchant_id']."' and
					r.rent_sts != 'Batal' and
					r.rent_sts2 != 'Batal' and
					r.rent_sts2 != 'pindah'");
					$counter= 0;
					while($dataSize=mysql_fetch_array($sql3)){
						$size = $dataSize['size'];
						$total = $dataSize['total'];
						$dp = $dataSize['dp'];
						$lo = $dataSize['lo'];
						$counter++;
					}

        // Meratakan semua teks ke tengah, kecuali kolom G (Pedagang)
        $sheet->getStyle('A:H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set alignment khusus untuk kolom G (Pedagang) ke kiri
        $sheet->getStyle('C:D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Menulis data per baris
        $sheet->setCellValue("A" . $row, $no)
              ->setCellValue("B" . $row, $data['merchant_id'])
              ->setCellValue("C" . $row, $data['merchant_name'])
              ->setCellValue("D" . $row, $lapak)
              ->setCellValue("E" . $row, $size . ' M2')
              ->setCellValue("F" . $row, $total)
              ->setCellValue("G" . $row, $dp)
              ->setCellValue("H" . $row, $lo);
            
        // Membuat format menjadi number
        $sheet->getStyle("E" . $row . ":H" . $row)->getNumberFormat()->setFormatCode('#,##0');

        $no++;
        $row++;
    }

    // Menulis total pada baris terakhir
    if ($row > 7) {
        $sheet->mergeCells("A" . $row . ":E" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("F" . $row, "=SUM(F7:F" . ($row - 1) . ")")
              ->setCellValue("G" . $row, "=SUM(G7:G" . ($row - 1) . ")")
              ->setCellValue("H" . $row, "=SUM(H7:H" . ($row - 1) . ")");
    } else {
        $sheet->mergeCells("A" . $row . ":E" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("F" . $row,  0)
              ->setCellValue("G" . $row,  0)
              ->setCellValue("H" . $row,  0);
    }

    // Mengatur warna latar belakang kuning untuk baris total
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->getStartColor()->setRGB('FFFF00'); // Warna Kuning

    // Membuat Text Bold
    $sheet->getStyle("A" . $row . ":H" . $row)->getFont()->setBold(true);

    // Meratakan teks "TOTAL" ke tengah
    $sheet->getStyle("A" . $row . ":H" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Membuat format menjadi number
    $sheet->getStyle("F" . $row . ":H" . $row)->getNumberFormat()->setFormatCode('#,##0');

    // Menambahkan border pada seluruh tabel
    $sheet->getStyle("A6:H" . $row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan Data Piutang Per Pedagang' . ' (' .$mtype. ')_' . date('d M Y') . '.xls"');
    header('Cache-Control: max-age=0');

    // Menyimpan dan mendownload file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>

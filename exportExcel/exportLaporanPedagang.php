<?php
    include "../connection.php";
    require_once '../libs/PHPExcel/Classes/PHPExcel.php'; 
    // Load library PHPExcel

	$year	= date('Y');
	$mtype	= $_POST['mtype'];
	$sts	= $_POST['sts'];
	$date 	= date("d M Y");

    // Query untuk mengambil data
    if($sts=='Semua'){
		if($mtype=='Semua'){
			$sql 	= "select * from merchant order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant");
		}
		else{
			$sql 	= "select * from merchant where merchant_type = '".$mtype."' order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant 
			where merchant_type = '".$mtype."'");
		}
	}
	else{
		if($mtype=='Semua'){
			$sql 	= "select * from merchant where merchant_status = '".$sts."' order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant where merchant_status = '".$sts."'");
		}
		else{
			$sql 	= "select * from merchant where merchant_type = '".$mtype."' and merchant_status = '".$sts."'
			order by merchant_id";
			$total 	= executeScalar("select count(merchant_id) from merchant 
			where merchant_type = '".$mtype."' and merchant_status = '".$sts."'");
		}
	}

    $query 	= mysql_query($sql);

    // Buat objek PHPExcel
    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle("Laporan Data Pedagang");

    // Menulis Informasi di Atas Tabel
    $sheet->setCellValue("A1", "LAPORAN DATA PEDAGANG PER JENIS JUALAN");
    $sheet->setCellValue("A3", "JUMLAH PEDAGANG");
    $sheet->setCellValue("A4", "STATUS PEDAGANG");
    $sheet->setCellValue("B3", " : ");
    $sheet->setCellValue("B4", " : ");
    $sheet->setCellValue("C3", $total . ' Orang');
    $sheet->setCellValue("C4",$sts);

    // Membuat text bold
    $sheet->getStyle("A1:B4")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A1:B4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A3:A4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    // Merge cell
    $sheet->mergeCells("A1:I1");

    // Menulis header
    $sheet->setCellValue("A6", "NO")
          ->setCellValue("B6", "KODE")
          ->setCellValue("C6", "NAMA PEDAGANG")
          ->setCellValue("D6", "TELP RUMAH")
          ->setCellValue("E6", "HANDPHONE")
          ->setCellValue("F6", "ALAMAT")
          ->setCellValue("G6", "LAPAK")
          ->setCellValue("H6", "JENIS PEDAGANG")
          ->setCellValue("I6", "STATUS");

    // Mengatur warna latar belakang hijau untuk header
    // $sheet->getStyle('A6:I6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle('A6:I6')->getFill()->getStartColor()->setRGB('7FBF7F'); // Warna Hijau

    // Membuat Text Bold
    $sheet->getStyle("A6:I6")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah, kecuali kolom E (Pedagang)
    $sheet->getStyle('A6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no			= 1;
    $row        = 7;

    // Looping untuk mengambil dan menuliskan data
    while ($data = mysql_fetch_array($query)) {
        if($data['phone1']!=''){
            $p1 = $data['phone1'];
        }
        else{
            $p1 = '-';
        }
        if($data['phone2']!=''){
            $p2 = $data['phone2'];
        }
        else{
            $p2 = '-';
        }
        
        $sql2 	= mysql_query("select l.lapak_name from rent r, lapak l
                where r.lapak_id = l.lapak_id and 
                r.merchant_id = '".$data['merchant_id']."' and
                r.rent_sts2 != 'Pindah'
                order by l.lapak_name limit 7");
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

        // Meratakan semua teks ke tengah, kecuali kolom G (Pedagang)
        $sheet->getStyle('A:I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set alignment khusus untuk kolom G (Pedagang) ke kiri
        $sheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Menulis data per baris
        $sheet->setCellValue("A" . $row, $no)
              ->setCellValue("B" . $row, $data['merchant_id'])
              ->setCellValue("C" . $row, $data['merchant_name'])
              ->setCellValue("D" . $row, $p1)
              ->setCellValue("E" . $row, $p2)
              ->setCellValue("F" . $row, $data['address1'])
              ->setCellValue("G" . $row, $lapak)
              ->setCellValue("H" . $row, $data['merchant_type'])
              ->setCellValue("I" . $row, $data['merchant_status']);
            
        // Membuat format menjadi number
        // $sheet->getStyle("I" . $row . ":I" . $row)->getNumberFormat()->setFormatCode('#,##0');

        // Perhitungan total
        // if ($data['weighing_sts'] != 'Batal' && $data['weighing_sts'] != 'Dipecah' && $data['weighing_sts'] != 'Digabung') {
        //     $weight_in += $data['weight_in'];
        //     $weight_out += $data['weight_out'];
        //     $noncommodity += $data['noncommodity'];
        //     $rafaksi += $data['rafaksi'];
        //     $netto += $data['netto'];
        // }

        $no++;
        $row++;
    }

    // Menulis total pada baris terakhir
    // if ($row > 7) {
    //     $sheet->mergeCells("A" . $row . ":H" . $row); 
    //     $sheet->setCellValue("A" . $row, "TOTAL")
    //           ->setCellValue("I" . $row, "=SUM(I7:I" . ($row - 1) . ")")
    //           ->setCellValue("J" . $row, "=SUM(J7:J" . ($row - 1) . ")");
    // } else {
    //     $sheet->mergeCells("A" . $row . ":H" . $row); 
    //     $sheet->setCellValue("A" . $row, "TOTAL")
    //           ->setCellValue("I" . $row,  0)
    //           ->setCellValue("J" . $row,  0);
    // }

    // Mengatur warna latar belakang kuning untuk baris total
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->getStartColor()->setRGB('FFFF00'); // Warna Kuning

    // Membuat Text Bold
    // $sheet->getStyle("A" . $row . ":J" . $row)->getFont()->setBold(true);

    // Meratakan teks "TOTAL" ke tengah
    // $sheet->getStyle("A" . $row . ":J" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Membuat format menjadi number
    // $sheet->getStyle("I" . $row . ":J" . $row)->getNumberFormat()->setFormatCode('#,##0');

    // Menambahkan border pada seluruh tabel
    $sheet->getStyle("A6:I" . $row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan Data Pedagang Per Jenis Jualan' . ' (' .$mtype. ')_' . date('d M Y') . '.xls"');
    header('Cache-Control: max-age=0');

    // Menyimpan dan mendownload file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>

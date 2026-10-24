<?php
    include "../connection.php";
    require_once '../libs/PHPExcel/Classes/PHPExcel.php'; 
    // Load library PHPExcel

	$year	= date('Y');
    $block  = $_POST['block'];
	$date 	= date("d M Y");
    $total 	= executeScalar("select count(distinct(m.merchant_id)) from merchant m, lapak l, rent r 
                            where m.merchant_id = r.merchant_id and
                            l.lapak_id = r.lapak_id and
                            m.merchant_status = 'Aktif' and
                            (r.rent_sts2 != 'Batal' && r.rent_sts2 != 'Pindah') and
                            l.block_id = '".$_POST['block']."'");

    // Query untuk mengambil data
    $sql 	= "select * from merchant m, lapak l, rent r 
                where m.merchant_id = r.merchant_id and
                l.lapak_id = r.lapak_id and
                (r.rent_sts2 != 'Batal' && r.rent_sts2 != 'Pindah') and
                m.merchant_status = 'Aktif' and
                l.block_id = '".$_POST['block']."' 
                order by l.lapak_no";

    $query 	= mysql_query($sql);

    // Buat objek PHPExcel
    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle("Laporan Data Pedagang");

    // Menulis Informasi di Atas Tabel
    $sheet->setCellValue("A1", "LAPORAN DATA PEDAGANG BLOK " . $block);
    $sheet->setCellValue("A3", "JUMLAH PEDAGANG");
    $sheet->setCellValue("B3", " : ");
    $sheet->setCellValue("C3", $total . ' Orang');

    // Membuat text bold
    $sheet->getStyle("A1:B3")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A1:B3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A3:A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    // Merge cell
    $sheet->mergeCells("A1:H1");

    // Menulis header
    $sheet->setCellValue("A5", "NO")
          ->setCellValue("B5", "KODE")
          ->setCellValue("C5", "NAMA PEDAGANG")
          ->setCellValue("D5", "TELP RUMAH")
          ->setCellValue("E5", "HANDPHONE")
          ->setCellValue("F5", "ALAMAT")
          ->setCellValue("G5", "LAPAK")
          ->setCellValue("H5", "JENIS PEDAGANG");

    // Mengatur warna latar belakang hijau untuk header
    // $sheet->getStyle('A5:I5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle('A5:I5')->getFill()->getStartColor()->setRGB('7FBF7F'); // Warna Hijau

    // Membuat Text Bold
    $sheet->getStyle("A5:H5")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah, kecuali kolom E (Pedagang)
    $sheet->getStyle('A5:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no			= 1;
    $row        = 6;

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

        // Meratakan semua teks ke tengah, kecuali kolom G (Pedagang)
        $sheet->getStyle('A:H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set alignment khusus untuk kolom G (Pedagang) ke kiri
        $sheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Menulis data per baris
        $sheet->setCellValue("A" . $row, $no)
              ->setCellValue("B" . $row, $data['merchant_id'])
              ->setCellValue("C" . $row, $data['merchant_name'])
              ->setCellValue("D" . $row, $p1)
              ->setCellValue("E" . $row, $p2)
              ->setCellValue("F" . $row, $data['address1'])
              ->setCellValue("G" . $row, $data['lapak_name'])
              ->setCellValue("H" . $row, $data['merchant_type']);
            
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
    $sheet->getStyle("A5:H" . $row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan Data Pedagang Blok' . ' (' .$block. ')_' . date('d M Y') . '.xls"');
    header('Cache-Control: max-age=0');

    // Menyimpan dan mendownload file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>

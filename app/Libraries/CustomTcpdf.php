<?php

namespace App\Libraries;

use TCPDF;

class CustomTcpdf extends TCPDF
{
  // Override Header() method
  public function Header()
  {
    // Path ke file logo
    // $image_file = base_url('logo.png');
    // // Menambahkan logo pada header
    // $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    // // Menentukan font untuk header
    // $this->SetFont('helvetica', 'B', 12);

    // // Menambahkan teks header
    // $this->Cell(0, 15, 'BUNGA DESA', 0, 1, 'R', 0, '', 0, false, 'T', 'M');
  }

  // Override Footer() method jika Anda ingin menambahkan footer
  public function Footer()
  {
    // Posisi di 15 mm dari bawah
    $this->SetY(-15);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Nomor halaman
    $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 0, 'C');
  }
}
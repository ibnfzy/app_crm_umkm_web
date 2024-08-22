<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>BUNGA DESA</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="BUNGA DESA" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link href="/web_assets/img/favicon.ico" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap"
    rel="stylesheet">

  <!-- CSS Libraries -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="/web_assets/lib/slick/slick.css" rel="stylesheet">
  <link href="/web_assets/lib/slick/slick-theme.css" rel="stylesheet">

  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.css'
    integrity='sha512-WxRv0maH8aN6vNOcgNFlimjOhKp+CUqqNougXbz0E+D24gP5i+7W/gcc5tenxVmr28rH85XHF5eXehpV2TQhRg=='
    crossorigin='anonymous' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css'
    integrity='sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=='
    crossorigin='anonymous' />
  <!-- Template Stylesheet -->
  <link href="/web_assets/css/style.css" rel="stylesheet">
</head>

<body>
  <?php
  $db = \Config\Database::connect();
  $get = $db->table('informasi_toko')->where('id_informasi_toko', 1)->get()->getRowArray();
  ?>
  <?= $this->include('web/layouts/navbar'); ?>

  <?= $this->renderSection('content'); ?>

  <?= $this->include('web/layouts/footer'); ?>

  <div class="floating-button">
    <a href="https://wa.me/<?= $get['kontak_wa'] ?>" target="_blank">
      <i class="fab fa-whatsapp fa-2x"></i>
      <span class="text">Hubungi Kami</span>
    </a>
  </div>

  <!-- Back to Top -->
  <a href="/#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- JavaScript Libraries -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'
    integrity='sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=='
    crossorigin='anonymous'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.js'
    integrity='sha512-w4LAuDSf1hC+8OvGX+CKTcXpW4rQdfmdD8prHuprvKv3MPhXH9LonXX9N2y1WEl2u3ZuUSumlNYHOlxkS/XEHA=='
    crossorigin='anonymous'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js'
    integrity='sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=='
    crossorigin='anonymous'></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="/web_assets/lib/easing/easing.min.js"></script>
  <script src="/web_assets/lib/slick/slick.min.js"></script>

  <!-- Template Javascript -->
  <script src="/web_assets/js/main.js"></script>

  <?= $this->renderSection('script'); ?>

  <script>
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  </script>

  <?php
  if (session()->getFlashdata('dataMessage')) {
    foreach (session()->getFlashdata('dataMessage') as $item) {
      echo '<script>toastr["' .
        session()->getFlashdata('type-status') . '"]("' . $item . '")</script>';
    }
  }
  if (session()->getFlashdata('message')) {
    echo '<script>toastr["' .
      session()->getFlashdata('type-status') . '"]("' . session()->getFlashdata('message') . '")</script>';
  }
  ?>
</body>

</html>
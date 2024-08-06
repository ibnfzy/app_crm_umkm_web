<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Registrasi</title>
  <!-- Font Awesome -->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css'
    integrity='sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=='
    crossorigin='anonymous' />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <style>
  .divider:after,
  .divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
  }

  .h-custom {
    height: calc(100% - 73px);
  }

  @media (max-width: 450px) {
    .h-custom {
      height: 100%;
    }
  }

  #map {
    height: 400px;
    width: 100%;
  }
  </style>
</head>

<body>

  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="/panel_assets/img/people.jpg" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <h1 class="my-2">Customer Registrasi</h1>
          <form action="/Login/Auth" method="post">
            <input type="hidden" name="lat">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="text" class="form-control form-control-lg" name="nama" id="nama" />
              <label class="form-label" for="nama">Nama Lengkap</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="email" class="form-control form-control-lg" name="email" id="email" />
              <label class="form-label" for="email">Email</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
              <input type="password" class="form-control form-control-lg" name="password" id="password" />
              <label class="form-label" for="password">Password</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-3">
              <input type="password" class="form-control form-control-lg" name="konfirmasi_password"
                id="konfirmasi_password" />
              <label class="form-label" for="konfirmasi_password">Konfirmasi Password</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="text" class="form-control form-control-lg" name="alamat" id="alamat" required />
              <label class="form-label" for="alamat">Alamat Lengkap</label>
            </div>

            <div id="map"></div><br><br>

            <div class="text-center text-lg-start pt-2">
              <button class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            </div>

          </form>

          <hr>
          <span class="mx-1">Sudah punya akun? <a href="/CustomerAuth">Login Disini</a></span> /
          <span class="mx-1">Kembali ke <a href="/">Halaman Utama</a></span>
        </div>
      </div>
    </div>
  </section>

  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js'
    integrity='sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=='
    crossorigin='anonymous'></script>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Inisialisasi peta
    var map = L.map('map').setView([-6.200000, 106.816666], 8);

    // Menambahkan tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Marker untuk menunjukkan lokasi yang dipilih
    var marker = L.marker([-6.200000, 106.816666]).addTo(map);

    // Fungsi untuk memperbarui alamat berdasarkan koordinat
    function updateAddress(lat, lng) {
      var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          if (data.address) {
            var address =
              `${data.address.road}, ${data.address.city}, ${data.address.state}, ${data.address.country}, ${data.address.postcode}`;
            document.getElementById('alamat').value = address;
          } else {
            document.getElementById('alamat').value = "Alamat tidak ditemukan";
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Fungsi untuk memperbarui peta berdasarkan alamat
    function updateMap(address) {
      var url = `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${address}`;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            var lat = data[0].lat;
            var lon = data[0].lon;
            var latlng = new L.LatLng(lat, lon);
            marker.setLatLng(latlng);
            map.setView(latlng, 13);
          } else {
            alert("Alamat tidak ditemukan, ");
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Event listener untuk klik pada peta
    map.on('click', function(e) {
      var lat = e.latlng.lat;
      var lng = e.latlng.lng;
      marker.setLatLng(e.latlng);
      updateAddress(lat, lng);
    });

    // Event listener untuk perubahan pada input alamat
    document.getElementById('alamat').addEventListener('change', function() {
      var address = this.value;
      updateMap(address);
    });
  });

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
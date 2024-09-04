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
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css'
    integrity='sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=='
    crossorigin='anonymous' />
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
          <form action="/CustomerAuth/Register" method="post" id="form">
            <!-- <input type="hidden" name="kota" id="kota"> -->
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="text" class="form-control form-control-lg" name="nama_customer" id="nama_customer"
                required />
              <label class="form-label" for="nama_customer">Nama Lengkap</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="email" class="form-control form-control-lg" name="email_customer" id="email_customer"
                required />
              <label class="form-label" for="email_customer">Email</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
              <input type="password" class="form-control form-control-lg" name="password" id="password" required />
              <label class="form-label" for="password">Password</label>
            </div>

            <span id="message" class="text-danger"></span>
            <div data-mdb-input-init class="form-outline mb-3">
              <input type="password" class="form-control form-control-lg" name="confirm_password"
                id="confirm_password" />
              <label class="form-label" for="confirm_password">Konfirmasi Password</label>
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">+62</span>
              <input type="text" class="form-control" placeholder="Nomor Whatsapp (Penerima Pemesanan)" name="no_wa"
                required />
            </div>

            <div class="form-outline mb-4">
              <label class="form-label" for="kota">Pilih Kota Pengiriman</label>
              <select name="kota" id="kota" class="form-select form-select-lg mb-3">
                <?php foreach ($kota_tersedia as $key => $item) : ?>
                <option value="<?= $key ?>"><?= $key ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div data-mdb-input-init class="form-outline mb-3">
              <textarea class="form-control form-control-lg" name="alamat" id="alamat" placeholder="Alamat Lengkap"
                required rows="5"></textarea>
              <label class="form-label" for="confirm_password">Alamat Lengkap</label>
            </div>

            <!-- <div data-mdb-input-init class="input-group mb-4">
              <textarea class="form-control form-control-lg" name="alamat" id="alamat" placeholder="Alamat Lengkap" required rows="5"></textarea>
              <button class="btn btn-outline-secondary" type="button" id="locateBtn" data-mdb-ripple-init data-mdb-ripple-color="dark">
                Dapatkan Lokasi
              </button>
            </div> -->

            <!-- <span class="badge rounded-pill badge-warning mb-3" id="info">Contoh penulisan alamat : Nama Jalan, Kota/Kab, Provinsi</span>

            <div id="map" class="mb-2"></div>
            <span class="badge rounded-pill badge-warning mb-3" id="info">info: fitur map belum terlalu akurat</span> -->

            <div class="text-center text-lg-start pt-2">
              <button class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" type="submit"
                id="submitbtn">Login</button>
              <button class="btn btn-warning btn-lg" id="cekKesediaan" type="button"
                style="padding-left: 2.5rem; padding-right: 2.5rem;" hidden="true">Cek kesediaan pengiriman</button>
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
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'
    integrity='sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=='
    crossorigin='anonymous'></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>

  <!-- sweetalert -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'
    integrity='sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=='
    crossorigin='anonymous'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js'
    integrity='sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=='
    crossorigin='anonymous'></script>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

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

  <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Inisialisasi peta
    var map = L.map('map').setView([-6.200000, 106.816666], 8);

    const kota_tersedia = <?= json_encode($kota_tersedia) ?>;
    let kota = '';

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
            kota = data.address.city;
            document.getElementById('kota').value = kota;

          } else {
            document.getElementById('alamat').value = "Alamat tidak ditemukan pada map API ()";
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
          }

        })
        .catch(error => console.error('Error:', error));
    }

    // Fungsi untuk menggunakan lokasi GPS pengguna
    function locateUser() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
          var latlng = new L.LatLng(lat, lng);
          marker.setLatLng(latlng);
          map.setView(latlng, 13);
          updateAddress(lat, lng);
        }, function() {
          swal({
            title: 'Lokasi Tidak Ditemukan',
            text: 'Lokasi tidak dapat ditemukan. Pastikan GPS Anda aktif.',
            icon: 'error',
            button: 'OK',
          });
        });
      } else {
        swal({
          title: 'Geo Lokasi tidak support pada browser ini',
          icon: 'error',
          button: 'OK',
        });
      }
    }

    // Event listener untuk klik pada peta
    map.on('click', function(e) {
      var lat = e.latlng.lat;
      var lng = e.latlng.lng;
      marker.setLatLng(e.latlng);
      updateAddress(lat, lng);
    });

    // Event listener untuk tombol "Gunakan Lokasi Saya"
    document.getElementById('locateBtn').addEventListener('click', function() {
      locateUser();
    });

    // Event listener untuk cek kesediaan pengiriman
    document.getElementById('cekKesediaan').addEventListener('click', function() {
      const checkKetersediaan = kota_tersedia.hasOwnProperty(kota)

      if (!checkKetersediaan) {
        swal({
          title: 'Kota Tidak Tersedia',
          text: 'Kota anda belum tersedia untuk pengiriman, hubungi admin untuk informasi lebih lanjut.',
          icon: 'error',
          button: 'OK',
        })
      } else {
        const tarif = kota_tersedia[kota]
        swal({
          title: 'Kota Tersedia',
          text: 'Kota anda tersedia untuk pengiriman. dengan Tarif pengiriman Rp ' + tarif + '.',
          icon: 'success',
          button: 'OK',
        })

        document.getElementById('submitbtn').removeAttribute('hidden')
        document.getElementById('cekKesediaan').setAttribute('hidden', 'true')
      }
    })

    // Event listener untuk perubahan pada input alamat
    document.getElementById('alamat').addEventListener('input', function() {
      var address = this.value;
      updateMap(address);
      document.getElementById('submitbtn').setAttribute('hidden', 'true');
      document.getElementById('cekKesediaan').removeAttribute('hidden');

    });

    document.getElementById('form').addEventListener('submit', function(e) {
      e.preventDefault();
      const password = document.getElementById('password').value
      const password_konfirmasi = document.getElementById('confirm_password').value
      if (password != password_konfirmasi) {
        swal({
          title: 'Password Tidak Sama',
          icon: 'error',
          button: 'OK',
        })
        return
      }
      this.submit()
    })
  });
  </script>
</body>

</html>
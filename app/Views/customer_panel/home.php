<?= $this->extend('customer_panel/base'); ?>

<?= $this->section('content'); ?>

<!-- Section: Main chart -->
<section class="my-4">
  <div class="row">
    <div class="col-3 col-md-3">
      <div class="card my-1">
        <div class="card card-primary card-outline">
          <div class="card-header bg-primary">
            <h3 class="card-title text-light">Profile Pelanggan</h3>
          </div>
          <div class="card-body box-profile">

            <h3 class="profile-username text-center mt-1 text-primary"><?= session()->get('dataCustomer')['nama_customer']; ?></h3>

            <p class="text-muted text-center"><a href="#" data-mdb-ripple-init
                data-mdb-modal-init data-mdb-target="#ubahInformasi"><i class="fa fa-pencil"></i> Edit</a></p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Kontak</b> <span class="float-end">
                  <?= preg_replace('/(\d{2})(\d{10})/m', "+$1 $2", session()->get('dataCustomer')['no_wa']); ?></span>
              </li>
              <li class="list-group-item">
                <b>Email</b> <span class="float-end"><?= session()->get('dataCustomer')['email_customer']; ?></span>
              </li>
              <li class="list-group-item">
                <b>Kota</b> <span class="float-end"><?= session()->get('dataCustomer')['nama_kota']; ?></span>
              </li>
              <li class="list-group-item">
                <b>Tarif Pengiriman</b> <span class="float-end">Rp <?= number_format(session()->get('dataCustomer')['tarif'], 0, ',', '.'); ?></span>
              </li>
              <li class="list-group-item">
                <b>Alamat</b> <span class="float-end"><?= session()->get('dataCustomer')['alamat']; ?></span>
              </li>
            </ul>
          </div>

          <!-- /.card-body -->
        </div>
      </div>

      <button class="btn btn-primary col-12 my-2" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalPassword"><i class="fa fa-pencil"></i> Ubah Password</button>
    </div>
    <div class="col-9 col-md-9">
      <div class="card">
        <div class="card-body table-responsive">
          <h5 class="card-title">Selesaikan Pembayaran</h5>
          <table class="table table-bordered table-sm" id="datatables">
            <thead>
              <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Nama</th>
                <th>Total Belanjaan</th>
                <th>Total Bayar</th>
                <th>Tanggal Checkout</th>
                <th>Status Transaksi</th>
                <th>Invoice</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataPembayaran as $key => $item) : ?>
                <tr>
                  <td><?= $key + 1; ?></td>
                  <td><?= $item['id_unique_transaksi']; ?></td>
                  <td><?= $item['nama_customer']; ?></td>
                  <td><?= $item['total_kuantitas_belanja']; ?></td>
                  <td>Rp <?= number_format($item['total_bayar_belanja'], 0, ',', '.'); ?></td>
                  <td><?= $item['tanggal_checkout']; ?></td>
                  <td><?= $item['status_transaksi']; ?></td>
                  <td><a href="/CustomerPanel/Invoice/<?= $item['id_transaksi']; ?>" class="btn btn-sm btn-primary">Invoice</td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</section>
<!-- Section: Main chart -->

<!-- Modal -->
<div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="modalPasswordLabel">Ubah Password Akun</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/CustomerPanel/Password" method="post" id="formPassword">
        <div class="modal-body">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="password" id="password" class="form-control" name="password" required>
            <label for="password" class="form-label">Password Baru</label>
          </div>
          <span class="text-danger" id="password-error"></span>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="password" id="password_konfirmasi" class="form-control" name="password_konfirmasi" required>
            <label for="password_konfirmasi" class="form-label">Password Baru Konfirmasi</label>
          </div>
          <span class="text-danger" id="password-konfirmasi-error"></span>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ubahInformasi" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Ubah Informasi Toko</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/CustomerPanel/Informasi" method="post">
        <div class="modal-body">
          <input type="hidden" name="kota" id="kota" value="<?= session()->get('dataCustomer')['nama_kota'] ?>">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="nama_customer" class="form-control" name="nama_customer" value="<?= session()->get('dataCustomer')['nama_customer'] ?>" required>
            <label for="nama_customer" class="form-label">Nama Customer</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="email" id="email_customer" class="form-control" name="email_customer" value="<?= session()->get('dataCustomer')['email_customer'] ?>" required>
            <label for="email_customer" class="form-label">Email</label>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">+62</span>
            <input
              type="text"
              class="form-control"
              placeholder="Nomor Whatsapp (Penerima Pemesanan)"
              value="<?= preg_replace('/(\d{2})(\d{10})/m', "$2", session()->get('dataCustomer')['no_wa']); ?>"
              name="no_wa" required />
          </div>

          <div data-mdb-input-init class="input-group mb-4">
            <textarea class="form-control form-control-lg" name="alamat" id="alamat" placeholder="Alamat Lengkap" required rows="5"><?= session()->get('dataCustomer')['alamat']; ?></textarea>
            <button class="btn btn-outline-secondary" type="button" id="locateBtn" data-mdb-ripple-init data-mdb-ripple-color="dark">
              Dapatkan Lokasi
            </button>
          </div>

          <span class="badge rounded-pill badge-warning mb-3" id="info">Contoh penulisan alamat : Nama Jalan, Kota/Kab, Provinsi</span>

          <div id="map" class="mb-2 d-block"></div>
          <span class="badge rounded-pill badge-warning mb-3" id="info">info: fitur map belum terlalu akurat</span>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button id="submitbtn" type="submit" class="btn btn-primary" data-mdb-ripple-init hidden="true">Simpan</button>
          <button class="btn btn-warning btn-lg" id="cekKesediaan" type="button" style="padding-left: 2.5rem; padding-right: 2.5rem;">Cek kesediaan pengiriman</button>
        </div>
      </form>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
  document.getElementById('ubahInformasi').addEventListener("show.mdb.modal", function() {
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
            document.getElementById('submitbtn').setAttribute('hidden', 'true');
            document.getElementById('cekKesediaan').removeAttribute('hidden');

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
            document.getElementById('submitbtn').setAttribute('hidden', 'true');
            document.getElementById('cekKesediaan').removeAttribute('hidden');
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

      document.getElementById('submitbtn').setAttribute('hidden', 'true');
      document.getElementById('cekKesediaan').removeAttribute('hidden');
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
    document.getElementById('alamat').addEventListener('change', function() {
      var address = this.value;
      updateMap(address);
      console.log('test');

      document.getElementById('submitbtn').setAttribute('hidden', 'true');
      document.getElementById('cekKesediaan').removeAttribute('hidden');

    });

    setTimeout(function() {
      map.invalidateSize();
    }, 10);
  });

  $('#formPassword').submit(function(e) {
    e.preventDefault();
    if ($('#password').val() != $('#password_konfirmasi').val()) {
      $('#password-konfirmasi-error').text('Password tidak sama');
      return;
    }

    if ($('#password').val().length < 5) {
      $('#password-error').text('Password harus lebih dari 5 karakter');
      return;
    }
    $('#formPassword').unbind('submit').submit();
  });
</script>

<?= $this->endSection(); ?>
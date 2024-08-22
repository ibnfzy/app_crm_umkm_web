<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<!-- Section: Main chart -->
<section class="my-4">
  <div class="row">
    <div class="col-3 col-md-3">
      <div class="card my-1">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <h3 class="profile-username text-center mt-1 text-primary">
              <?= strtoupper(session()->get('dataToko')['nama_toko']); ?>
            </h3>

            <p class="text-muted text-center"><i class="fa fa-pencil"></i> Edit</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Kontak</b> <span class="float-end">
                  <?= preg_replace('/(\d{2})(\d{10})/m', "+$1 $2", session()->get('dataToko')['kontak_wa']); ?></span>
              </li>
              <li class="list-group-item">
                <b>Alamat</b> <span class="float-end"><?= session()->get('dataToko')['alamat']; ?></span>
              </li>
              <li class="list-group-item">
                <b>Rekening Toko</b> <span class="float-end"><?= session()->get('dataToko')['rekening_toko']; ?></span>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <button class="btn btn-primary" data-mdb-ripple-init data-mdb-toggle="modal" data-mdb-target="#modalPassword"><i class="fa fa-pencil"></i> Ubah Password</button>
      <div class="card card-primary my-3">
        <div class="card-header bg-primary">
          <h3 class="card-title text-light">Informasi Toko</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-book mr-1"></i> Tentang</strong>

          <p class="text-muted">
            <?= session()->get('dataToko')['tentang']; ?>
          </p>

        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-9 col-md-9">
      <div class="card">
        <div class="card-body table-responsive">
          <h5 class="card-title">Validasi Pembayaran Customer</h5>
          <table class="table table-bordered table-sm" id="datatables">
            <thead>
              <tr>
                <th>No.</th>
                <th>ID Customer</th>
                <th>Nama</th>
                <th>Total Belanjaan</th>
                <th>Total Bayar</th>
                <th>Tanggal Checkout</th>
                <th>Status Transaksi</th>
                <th>Hubungi Customer</th>
                <th>Invoice</th>
                <th>Validasi Bukti Pemabayaran</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataTransaksiValidasi as $key => $item) : ?>
                <tr>
                  <td><?= $key + 1; ?></td>
                  <td><?= $item['id_unique_transaksi']; ?></td>
                  <td><?= $item['nama_customer']; ?></td>
                  <td><?= $item['total_kuantitas_belanja']; ?></td>
                  <td>Rp <?= number_format($item['total_bayar_belanja'], 0, ',', '.'); ?></td>
                  <td><?= $item['tanggal_checkout']; ?></td>
                  <td><?= $item['status_transaksi']; ?></td>
                  <td><a href="/CustomerPanel/Invoice/<?= $item['id_transaksi']; ?>" class="btn btn-sm btn-primary">Invoice</td>
                  <td><button class="btn btn-primary" onclick="validasi('<?= $item['id_unique_transaksi'] ?>', '<?= $item['bukti_bayar'] ?>')">Validasi</button></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="uploadBukti" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Validasi Bukti Pembayaran</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Validasi" method="post">
        <div class="modal-body">
          <input type="hidden" name="id_transaksi" id="id_transaksi">

          <div class="mb-4">
            <a href="#" data-fancybox="bukti_bayar" id="bukti_bayar-fancybox">
              <img src="#" alt="" width="100%" id="bukti_bayar">
            </a>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Validasi</button>
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
      <form action="/OperatorPanel/Informasi" method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="username" class="form-control" name="username" value="<?= session()->get('username') ?>" required>
            <label for="username" class="form-label">Username Login</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="nama_toko" class="form-control" name="nama_toko" value="<?= session()->get('dataToko')['nama_toko'] ?>" required>
            <label for="nama_toko" class="form-label">Nama Toko</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="kontak_wa" class="form-control" name="kontak_wa" value="<?= session()->get('dataToko')['kontak_wa'] ?>" required>
            <label for="kontak_wa" class="form-label">Kontak Whatsapp</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="alamat" id="alamat" class="form-control" required>
              <?= session()->get('dataToko')['alamat'] ?>
            </textarea>
            <label for="alamat" class="form-label">Alamat</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="rekening_toko" id="rekening_toko" class="form-control" required>
              <?= session()->get('dataToko')['rekening_toko'] ?>
            </textarea>
            <label for="rekening_toko" class="form-label">Rekening Toko</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="tentang" id="tentang" class="form-control" required>
              <?= session()->get('dataToko')['tentang'] ?>
            </textarea>
            <label for="tentang" class="form-label">Tentang</label>
          </div>

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
<div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="modalPasswordLabel">Ubah Password Akun</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Password" method="post" id="formPassword">
        <div class="modal-body">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="password" id="password" class="form-control" name="password" required>
            <label for="password" class="form-label">Password Baru</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="password" id="password_konfirmasi" class="form-control" name="password_konfirmasi" required>
            <label for="password_konfirmasi" class="form-label">Password Baru Konfirmasi</label>
            <span class="text-danger" id="password-error"></span>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
  function openModal(id_transaksi, file) {
    const modal = new mdb.Modal(document.getElementById('uploadBukti'));
    document.getElementById('id_transaksi').value = id_transaksi;
    document.getElementById('bukti_bayar').src = '/uploads/' + file;
    document.getElementById('bukti_bayar-fancybox').href = '/uploads/' + file;
    modal.show();
  }

  $('#formPassword').submit(function(e) {
    e.preventDefault();
    if ($('#password').val() != $('#password_konfirmasi').val()) {
      $('#password-error').text('Password tidak sama');
      return;
    }
    $('#formPassword').unbind('submit').submit();
  });
</script>

<?= $this->endSection(); ?>
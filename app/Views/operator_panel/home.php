<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<!-- Section: Main chart -->
<section class="my-4">
  <div class="row">
    <div class="col-3 col-md-3">
      <div class="card my-1">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img width="100" class="profile-user-img img-fluid rounded-circle border border-3 border-primary"
                src="/web_assets/img/product-1.jpg" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center mt-1 text-primary">BUNGA DESA</h3>

            <p class="text-muted text-center"><i class="fa fa-pencil"></i> Edit</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Kontak</b> <span class="float-end">32</span>
              </li>
              <li class="list-group-item">
                <b>Alamat</b> <span class="float-end">32</span>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <div class="card card-primary my-3">
        <div class="card-header bg-primary">
          <h3 class="card-title text-light">Informasi Toko</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-book mr-1"></i> Tentang</strong>

          <p class="text-muted">
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis, risus quis malesuada aliquet, erat
            nibh iaculis leo, vitae blandit nisl nibh a lectus. Vestibulum ante ipsum primis in faucibus orci luctus et
            ultrices posuere cubilia curae; Aenean id lacus a nisl iaculis pretium. Nulla facilisi. Nullam egestas, nunc
            at tincidunt scelerisque, sem sapien dignissim nisi, id aliquam nisl nunc vitae sem. Donec laoreet, nunc
            vitae scelerisque iaculis, nunc nulla lacinia eros, at sollicitudin purus nisi at nibh. Sed euismod, nibh
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

            </tbody>
          </table>
        </div>
      </div>
    </div>
</section>
<!-- Section: Main chart -->

<?= $this->endSection(); ?>
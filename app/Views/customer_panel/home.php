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


            <h3 class="profile-username text-center mt-1 text-primary"><?= session()->get('nama_customer'); ?></h3>

            <p class="text-muted text-center"><i class="fa fa-pencil"></i> Edit</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Kontak</b> <span class="float-end"><?= session()->get('no_wa'); ?></span>
              </li>
              <li class="list-group-item">
                <b>Alamat</b> <span class="float-end"><?= session()->get('alamat'); ?></span>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
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

<?= $this->endSection(); ?>
<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<?php
$level = '0';

if ($dataTransaksiCount >= 3) {
  $level = '1';
}

if ($dataTransaksiCount >= 5) {
  $level = '2';
}

if ($dataTransaksiCount >= 8) {
  $level = '3';
}
?>

<section class="row mx-2">
  <div class="card col-3 mx-3">
    <div class="card-body">
      <h3>
        Total Transaksi : <?= $dataTransaksiCount; ?>
      </h3>
    </div>
  </div>
  <div class="card col-3 mx-3">
    <div class="card-body">
      <h3>
        Level Kupon : <?= $level; ?>
      </h3>
    </div>
  </div>
  <div class="card col-3">
    <div class="card-body">
      <small class="form-text text-muted">level kupon berdasarkan transaksi
        <ul>
          <li>Level 1 : >= 3 Transaksi</li>
          <li>Level 2 : >= 5 Transaksi</li>
          <li>Level 3 : >= 8 Transaksi</li>
        </ul>
      </small>
    </div>
  </div>
</section>

<section class="my-4">
  <div class="card mb-2">
    <div class="card-header">
      <h3>
        Transaksi Pelanggan
      </h3>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered datatable">
        <thead>
          <tr>
            <th>No.</th>
            <th>Total Belanjaan</th>
            <th>Total Bayar</th>
            <th>Tanggal Checkout</th>
            <th>Status Transaksi</th>
            <th>Invoice</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dataTransaksi as $key => $item) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $item['total_kuantitas_belanja'] ?></td>
            <td><?= $item['total_bayar_belanja'] ?></td>
            <td><?= $item['tanggal_checkout'] ?></td>
            <td><?= $item['status_transaksi'] ?></td>
            <td>
              <a href="/OperatorPanel/Invoice/<?= $item['id_transaksi'] ?>" class="btn btn-info">Invoice</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3>
        Kupon Pelanggan
      </h3>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered datatable">
        <thead>
          <tr>
            <th>No.</th>
            <th>ID Kupon</th>
            <th>Diskon</th>
            <th>Maximal Potongan</th>
            <th>Level Kupon</th>
            <th>Expired pada</th>
            <th>Deskripsi Kupon</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1; ?></td>
            <td><?= $item['id_unique_kupon']; ?></td>
            <td><?= $item['discount_kupon']; ?>%</td>
            <td>Rp <?= number_format($item['max_nominal_kupon'], 0, ',', '.'); ?></td>
            <td><?= $item['level_kupon']; ?></td>
            <td><?= $item['expired_at']; ?></td>
            <td><?= $item['deskripsi_kupon']; ?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
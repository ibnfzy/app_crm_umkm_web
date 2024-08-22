<?= $this->extend('customer_panel/base'); ?>

<?= $this->section('content'); ?>

<section class="my-4">
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
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
          <?php foreach ($data as $key => $item) : ?>
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
</section>

<?= $this->endSection(); ?>
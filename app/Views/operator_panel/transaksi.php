<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<section class="my-4">
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
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
          <?php foreach ((array) $data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $item['id_unique_customer'] ?></td>
            <td><?= $item['nama_customer'] ?></td>
            <td><?= $item['total_kuantitas_belanja'] ?></td>
            <td><?= $item['total_bayar_belanja'] ?></td>
            <td><?= $item['tanggal_checkout'] ?></td>
            <td><?= $item['status_transaksi'] ?></td>
            <td>
              <a href="#" class="btn btn-success">Hubungi Customer</a>
            </td>
            <td>
              <button class="btn btn-info">Invoice</button>
            </td>
            <td>
              <a href="#" class="btn btn-warning">Bukti Pembayaran</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
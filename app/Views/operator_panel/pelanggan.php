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
            <th>Email</th>
            <th>Total Transaksi</th>
            <th>Detail</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ((array) $data as $key => $item) : ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><?= $item['id_unique_customer'] ?></td>
              <td><?= $item['nama_customer'] ?></td>
              <td><?= $item['email_customer'] ?></td>
              <td><?= $item['total_transaksi'] ?? 0 ?></td>
              <td>
                <a href="/OperatorPanel/Pelanggan/<?= $item['id_unique_customer'] ?>"
                  class="btn btn-primary btn-sm">Detail</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
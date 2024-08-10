<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<section class="my-4">
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary">Tambah Data</button>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>No.</th>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Harga Promo</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ((array) $data as $i => $item) : ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $item['id_unique_produk'] ?></td>
            <td><?= $item['nama_produk'] ?></td>
            <td>Rp <?= number_format($item['harga_produk'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($item['harga_promo'], 0, ',', '.') ?></td>
            <td>
              <a href="/operator_panel/produk/edit/<?= $item['id_produk'] ?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="/operator_panel/produk/delete/<?= $item['id_produk'] ?>" class="btn btn-sm btn-danger">Delete</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
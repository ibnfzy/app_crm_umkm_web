<?= $this->extend('customer_panel/base'); ?>

<?= $this->section('content'); ?>

<section class="my-4">
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>No.</th>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Nama Customer</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
            <tr>
              <td><?= $key + 1; ?></td>
              <td><?= $item['id_unique_produk']; ?></td>
              <td><?= $item['nama_produk']; ?></td>
              <td><?= $item['nama_customer']; ?></td>
              <td><?= $item['rating']; ?></td>
              <td><?= $item['review']; ?></td>
              <td>
                <a href="/CustomerPanel/Review/<?= $item['id_detail_review']; ?>" class="btn btn-danger btn-sm">Hapus</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
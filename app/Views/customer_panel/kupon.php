<?= $this->extend('customer_panel/base'); ?>

<?= $this->section('content'); ?>

<section class="my-4">
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
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
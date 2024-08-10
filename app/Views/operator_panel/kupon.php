<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<section class="my-4">
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>No.</th>
            <th>ID Kupon</th>
            <th>Deskripsi Kupon</th>
            <th>Max Nominal Potongan</th>
            <th>Discount Kupon</th>
            <th>Level Kupon</th>
            <th>Tanggal Kupon Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ((array) $data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $item['id_kupon'] ?></td>
            <td><?= $item['deskripsi_kupon'] ?></td>
            <td><?= $item['max_nominal_potongan'] ?></td>
            <td><?= $item['discount_kupon'] ?></td>
            <td><?= $item['level_kupon'] ?></td>
            <td><?= $item['created_at'] ?></td>
            <td>
              <a href="<?= base_url('operator_panel/kupon/edit/' . $item['id_kupon']) ?>"
                class="btn btn-sm btn-warning">Edit</a>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
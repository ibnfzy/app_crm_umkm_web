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
            <th>Total Belanjaan</th>
            <th>Max Nominal Potongan</th>
            <th>Discount Kupon</th>
            <th>Level Kupon</th>
            <th>Tanggal Kupon Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
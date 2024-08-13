<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<section class="my-4">
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#tambah">Tambah
        Data</button>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>No.</th>
            <th>Kota/Kabupaten</th>
            <th>Tarif</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ((array) $data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= ucwords($item['nama_kota']) ?></td>
            <td>Rp. <?= number_format($item['tarif'], 0, ',', '.') ?></td>
            <td>
              <button onclick="edit('<?= $item['id_ongkir'] ?>', '<?= $item['nama_kota'] ?>', '<?= $item['tarif'] ?>')"
                class="btn btn-warning btn-sm">Edit</button>
              <a href="/OperatorPanel/Ongkos_kirim/delete/<?= $item['id_ongkir'] ?>"
                class="btn btn-danger btn-sm">Delete</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Tambah Data</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Ongkos_kirim" method="post">
        <div class="modal-body">
          <div class="mb-4">
            <label for="nama_kota" class="form-label">Nama Kota / Kabupaten</label>
            <input type="text" id="nama_kota" class="form-control" name="nama_kota" required>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_produk">Tarif</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control" id="tarif" placeholder="Tarif" required />
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="editLabel">Ubah Data</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Ongkos_kirim" method="post">
        <input type="hidden" id="id_ongkir" name="id_ongkir">
        <div class="modal-body">
          <div class="mb-4">
            <label for="nama_kota" class="form-label">Nama Kota / Kabupaten</label>
            <input type="text" id="nama_kota-edit" class="form-control" name="nama_kota" required>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_produk">Tarif</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control" id="tarif-edit" placeholder="Tarif" required />
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
const edit = (id, nama_kota, tarif) => {
  $('#id_ongkir').val(id);
  $('#nama_kota_edit').val(nama_kota);
  $('#tarif_edit').val(tarif);
  var modal = new mdb.Modal(document.getElementById('edit'));

  modal.show();
};
</script>

<?= $this->endSection(); ?>
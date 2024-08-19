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
            <th>Gambar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ((array) $data as $key => $item) : ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><img src="/Uploads/<?= $item['file'] ?>" width="100px" alt=""></td>
              <td>
                <button onclick="edit('<?= $item['id_slider'] ?>', '<?= $item['file'] ?>')"
                  class="btn btn-warning btn-sm">Edit</button>
                <a href="/OperatorPanel/Slider/<?= $item['id_slider'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
      <form action="/OperatorPanel/Slider" method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <div class="mb-4">
            <label for="files" class="form-label">Gambar Slider</label>
            <input type="file" id="file" class="form-control" name="file" accept="image/jpg, image/jpeg, image/png"
              multiple required>
            <small class="form-text text-muted">Max file size 2MB/file</small>
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
      <form action="/OperatorPanel/Slider/edit" method="post" enctype="multipart/form-data">
        <input type="hidden" id="id_slider" name="id_slider">
        <div class="modal-body">

          <div class="mb-4">
            <img src="#" alt="" id="img" class="img-fluid">
          </div>

          <div class="mb-4">
            <label for="files" class="form-label">Gambar Slider</label>
            <input type="file" id="file-edit" class="form-control" name="file" accept="image/jpg, image/jpeg, image/png"
              multiple required>
            <small class="form-text text-muted">Max file size 2MB/file</small>
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
  const edit = (id_slider, file) => {
    $('#id_slider').val(id_slider);
    $('#img').attr('src', '/Uploads/' + file);
    var modal = new mdb.Modal(document.getElementById('edit'));

    modal.show();
  };
</script>

<?= $this->endSection(); ?>
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
                <button type="button" onclick="" class="btn btn-sm btn-primary">Edit</button>
                <a href="/OperatorPanel/Produk/<?= $item['id_produk'] ?>" class="btn btn-sm btn-danger">Delete</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Tambah Data</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Produk" method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="id_unique_produk" class="form-control" name="id_unique_produk" required>
            <label for="id_unique_produk" class="form-label">ID Produk</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="nama_produk" class="form-control" name="nama_produk" required>
            <label for="nama_produk" class="form-label">Nama Produk</label>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_produk">Harga Produk</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_produk" id="harga_produk" placeholder="Harga Produk"
                required />
            </div>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_promo">Harga Promo</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_promo" id="harga_promo" placeholder="Harga Promo"
                required />
              <small class="form-text text-muted" id="error_harga_promo"></small>
            </div>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="number" id="stok" class="form-control" name="stok" required>
            <label for="stok" class="form-label">Stok Produk</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
            <label for="stok" class="form-label">Deskripsi Produk</label>
          </div>

          <div class="mb-4">
            <label for="files" class="form-label">Gambar Produk <span class="text-info">*Rekomendasi pilih >= 3 gambar
              </span></label>
            <input type="file" id="files" class="form-control" name="files" multiple required>
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

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="editLabel">Edit Data</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Produk/edit" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="text" id="id_produk" name="id_produk" hidden>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="id_unique_produk_edit" class="form-control" name="id_unique_produk" required>
            <label for="id_unique_produk" class="form-label">ID Produk</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="nama_produk_edit" class="form-control" name="nama_produk" required>
            <label for="nama_produk" class="form-label">Nama Produk</label>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_produk">Harga Produk</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_produk" id="harga_produk_edit" placeholder="Harga Produk"
                required />
            </div>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_promo">Harga Promo</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_promo" id="harga_promo_edit" placeholder="Harga Promo"
                required />
              <small class="form-text text-muted" id="error_harga_promo"></small>
            </div>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="number" id="stok_edit" class="form-control" name="stok" required>
            <label for="stok" class="form-label">Stok Produk</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="deskripsi" id="deskripsi_edit" class="form-control" required></textarea>
            <label for="stok" class="form-label">Deskripsi Produk</label>
          </div>

          <div class="mb-4">
            <label for="files" class="form-label">Gambar Produk <span class="text-info">*Rekomendasi pilih >= 3 gambar
              </span></label>
            <input type="file" id="files_edit" class="form-control" name="files" multiple required>
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
  $('#harga_promo').on('keyup', function() {
    var harga_produk = $('#harga_produk').val();
    var harga_promo = $('#harga_promo').val();

    if (parseInt(harga_promo) > parseInt(harga_produk)) {
      $('#error_harga_promo').text('Harga promo harus lebih kecil dari harga produk');
      $('#error_harga_promo').addClass('text-danger');
    } else {
      $('#error_harga_promo').text('');
      $('#error_harga_promo').removeClass('text-danger');
    }
  });

  $('#harga_promo_edit').on('keyup', function() {
    var harga_produk = $('#harga_produk_edit').val();
    var harga_promo = $('#harga_promo_edit').val();

    if (parseInt(harga_promo) > parseInt(harga_produk)) {
      $('#error_harga_promo_edit').text('Harga promo harus lebih kecil dari harga produk');
      $('#error_harga_promo_edit').addClass('text-danger');
    } else {
      $('#error_harga_promo_edit').text('');
      $('#error_harga_promo_edit').removeClass('text-danger');
    }
  })

  const edit = (id, id_unique_produk, nama_produk, harga_produk, harga_promo, stok, deskripsi) => {
    var modal = new mdb.Modal(document.getElementById('edit'));

    document.getElementById('id_unique_produk').value = id_unique_produk;
    document.getElementById('nama_produk').value = nama_produk;
    document.getElementById('harga_produk').value = harga_produk;
    document.getElementById('harga_promo').value = harga_promo;
    document.getElementById('stok').value = stok;
    document.getElementById('deskripsi').value = deskripsi;

    modal.show();
  };
</script>
<?= $this->endSection(); ?>
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
            <th>Stok</th>
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
              <td><?= $item['stok'] ?></td>
              <td>Rp <?= number_format($item['harga_produk'], 0, ',', '.') ?></td>
              <td>Rp <?= number_format($item['harga_promo'], 0, ',', '.') ?></td>
              <td>
                <div class="btn-group">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" data-mdb-dropdown-init data-mdb-ripple-init
                      aria-expanded="false">
                      Edit
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="#"
                          onclick="edit('<?= $item['id_produk'] ?>', '<?= $item['id_unique_produk'] ?>', '<?= $item['nama_produk'] ?>', '<?= $item['harga_produk'] ?>', '<?= $item['harga_promo'] ?>', '<?= $item['stok'] ?>', '<?= $item['deskripsi'] ?>')"
                          class="dropdown-item bg-primary text-white">Edit Produk</a>
                      </li>
                      <li>
                        <a href="#" onclick="manageImages('<?= $item['id_produk'] ?>')"
                          class="dropdown-item bg-primary text-white">Kelola
                          Gambar</a>
                      </li>
                    </ul>
                  </div>
                  <a href="/OperatorPanel/Produk/<?= $item['id_produk'] ?>" class="btn btn-sm btn-danger">Delete</a>
                  <a href="/OperatorPanel/Produk/Laporan/<?= $item['id_produk'] ?>" class="btn btn-sm btn-primary">Laporan
                    Produk</a>
                </div>
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
                name="harga_produk" required />
            </div>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_promo">Harga Promo</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_promo" name="harga_promo" id="harga_promo"
                placeholder="Harga Promo" required />
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
            <input type="file" id="files" class="form-control" name="files[]" accept="image/jpg, image/jpeg, image/png"
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
                name="harga_produk" required />
            </div>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_promo">Harga Promo</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_promo" id="harga_promo_edit" placeholder="Harga Promo"
                name="harga_promo" required />
              <small class="form-text text-muted" id="error_harga_promo"></small>
            </div>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="number" id="stok_edit" class="form-control" name="stok" required>
            <label for="stok_edit" class="form-label">Stok Produk</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="deskripsi" id="deskripsi_edit" class="form-control" required></textarea>
            <label for="stok" class="form-label">Deskripsi Produk</label>
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


<!-- Modal Manage Images -->
<div class="modal fade" id="manageImagesModal" tabindex="-1" aria-labelledby="manageImagesModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="manageImagesModalLabel">Kelola Gambar</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row" id="imageGrid">
          <!-- Contoh gambar dalam grid -->

          <!-- Tambahkan lebih banyak gambar dalam grid sesuai kebutuhan -->
        </div>
        <button class="btn btn-success" onclick="" id="addImage">Add Image</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Image -->
<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addImageModalLabel">Tambah gambar baru</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" action="/OperatorPanel/upload_images" method="post">
          <input type="hidden" name="id_produk" id="idProduk">
          <div class="mb-4">
            <label for="files" class="form-label">Gambar Produk</label>
            <input type="file" id="files" class="form-control" name="files[]" accept="image/jpg, image/jpeg, image/png"
              multiple required>
            <small class="form-text text-muted">Max file size 2MB/file</small>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
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

    document.getElementById('id_unique_produk_edit').value = id_unique_produk;
    document.getElementById('nama_produk_edit').value = nama_produk;
    document.getElementById('harga_produk_edit').value = harga_produk;
    document.getElementById('harga_promo_edit').value = harga_promo;
    document.getElementById('stok_edit').value = stok;
    document.getElementById('deskripsi_edit').value = deskripsi;
    document.getElementById('id_produk').value = id;

    modal.show();
  };

  const manageImages = (id_produk) => {
    var modal = new mdb.Modal(document.getElementById('manageImagesModal'));

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      let text = ""

      const resObj = JSON.parse(this.responseText);

      if (resObj['data'].length == 0) {
        text = `
        <div class="col-md-12 mb-4">
          <div class="position-relative">
            <p class="text-center">Tidak ada gambar</p>
          </div>
        </div>

      `
      } else {
        for (let d in resObj['data']) {
          fileUrl = '/uploads/' + resObj['data'][d].file;
          idDetailGambar = resObj['data'][d].id_detail_gambar;

          text += `
      <div class="col-md-4 mb-4">
            <div class="position-relative">
              <img src="${fileUrl}" class="img-fluid img-thumbnail" alt="Image">
              <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-mdb-toggle="modal" onclick="deleteImage('${idDetailGambar}')"></button>
            </div>
          </div>
      `
        }
      }

      document.getElementById('imageGrid').innerHTML = text;
      $('#addImage').attr('onclick', `addImage('${id_produk}')`);
      modal.show();
    }

    xmlhttp.open('GET', '<?= base_url('OperatorPanel/manage_images'); ?>/' + id_produk);
    xmlhttp.send();
  };

  const deleteImage = (id_detail_gambar) => {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      const resObj = JSON.parse(this.responseText);
      const idProduk = resObj['id_produk'];
      $('#manageImagesModal').modal('hide');
      manageImages(idProduk);
    }
    xmlhttp.open('GET', '<?= base_url('OperatorPanel/delete_image'); ?>/' + id_detail_gambar);
    xmlhttp.send();
  };

  const addImage = (id_produk) => {
    const modal = new mdb.Modal(document.getElementById('addImageModal'));

    $('#manageImagesModal').modal('hide');
    document.getElementById('idProduk').value = id_produk;
    modal.show();
  };
</script>
<?= $this->endSection(); ?>
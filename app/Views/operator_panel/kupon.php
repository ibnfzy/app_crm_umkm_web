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
              <button type="button" onclick="" class="btn btn-sm btn-primary">Edit</button>
              <a href="/OperatorPanel/Kupon/<?= $item['id_kupon'] ?>" class="btn btn-sm btn-danger">Delete</a>
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
      <form action="/OperatorPanel/Produk" method="post">
        <div class="modal-body">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="id_unique_produk" class="form-control" name="id_unique_produk" required>
            <label for="id_unique_produk" class="form-label">ID Kupon</label>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_produk">Max Nominal Potongan</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_produk" id="harga_produk" placeholder="Harga Produk"
                required />
            </div>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_promo">Discount</label>
            <div class="input-group">
              <input type="number" class="form-control harga_promo" id="harga_promo" placeholder="Harga Promo"
                required />
              <div class="input-group-text">%</div>
              <small class="form-text text-muted" id="error_harga_promo"></small>
            </div>
          </div>

          <div class="form-outline mb-4">
            <select name="level" id="level" class="form-select">
              <option value="0">Level 0 (Untuk Customer Baru)</option>
              <option value="1">Level 1 (3x Transaksi)</option>
              <option value="2">Level 2 (5x Transaksi)</option>
              <option value="3">Level 3 (10x Transaksi)</option>
            </select>
            <label for="level" class="form-label">Level Kupon</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="deskripsi_kupon" id="deskripsi_kupon" class="form-control" required></textarea>
            <label for="stok" class="form-label">Deskripsi Kupon</label>
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
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Tambah Data</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Produk/edit" method="post">
        <div class="modal-body">
          <input type="hidden" name="id_kupon" id="id_kupon">
          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="id_unique_produk_edit" class="form-control" name="id_unique_produk" required>
            <label for="id_unique_produk_edit" class="form-label">ID Kupon</label>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_produk">Max Nominal Potongan</label>
            <div class="input-group">
              <div class="input-group-text">Rp.</div>
              <input type="number" class="form-control harga_produk" id="harga_produk_edit" placeholder="Harga Produk"
                required />
            </div>
          </div>

          <div class="col-12 mb-4">
            <label class="visually-hidden" for="harga_promo_edit">Discount</label>
            <div class="input-group">
              <input type="number" class="form-control harga_promo" id="harga_promo_edit" placeholder="Harga Promo"
                required />
              <div class="input-group-text">%</div>
              <small class="form-text text-muted" id="error_harga_promo"></small>
            </div>
          </div>

          <div class="form-outline mb-4">
            <select name="level" id="level_edit" class="form-select">
              <option value="0">Level 0 (Untuk Customer Baru)</option>
              <option value="1">Level 1 (3x Transaksi)</option>
              <option value="2">Level 2 (5x Transaksi)</option>
              <option value="3">Level 3 (10x Transaksi)</option>
            </select>
            <label for="level_edit" class="form-label">Level Kupon</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <textarea name="deskripsi_kupon" id="deskripsi_kupon_edit" class="form-control" required></textarea>
            <label for="deskripsi_kupon_edit" class="form-label">Deskripsi Kupon</label>
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
const edit = (id, id_unique_produk, level, deskripsi, nominal) => {
  $('#id_kupon').val(id);
  $('#id_unique_produk_edit').val(id_unique_produk);
  $('#level_edit').val(level);
  $('#deskripsi_kupon_edit').val(deskripsi);
  $('#harga_promo_edit').val(nominal);
  var modal = new mdb.Modal(document.getElementById('edit'));

  modal.show();
};
</script>

<?= $this->endSection(); ?>
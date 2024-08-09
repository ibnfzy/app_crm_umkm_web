<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>
<?php $db = \Config\Database::connect(); ?>

<!-- Product List Start -->
<div class="product-view">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">

          <?php if (count($data) == 0) : ?>
          <div class="col-md-12" style="padding: 15px; text-align: center;">Data tidak ditemukan</div>
          <?php endif ?>

          <?php foreach ((array) $data as $item) : ?>

          <?php
            $getImg = $db->table('produk_detail_gambar')->where('id_produk', $item['id_produk'])->orderBy('id_detail_gambar', 'RANDOM')->get()->getRowArray();
            ?>

          <div class="col-md-3">
            <div class="product-item">
              <div class="product-title">
                <a href="/Katalog/<?= $item['id_produk']; ?>">
                  <?= $item['nama_produk']; ?>
                </a>
                <div class="ratting">
                  <i class="fa fa-star text-warning"></i>
                  <i class="fa fa-star text-warning"></i>
                  <i class="fa fa-star text-warning"></i>
                  <i class="fa fa-star text-warning"></i>
                  <i class="fa fa-star text-warning"></i>
                </div>
              </div>
              <div class="product-image">
                <a href="#">
                  <img src="/uploads/<?= $getImg['file']; ?>" alt="Product Image" loading="lazy">
                </a>
                <div class="product-action">
                  <a href="/Katalog/<?= $item['id_produk']; ?>"><i class="fa fa-eye"></i></a>
                </div>
              </div>
              <div class="product-price">
                <?php if ($item['harga_promo'] != 0) : ?>
                <h3>
                  Rp <?= number_format($item['harga_promo'], 0, ',', '.'); ?> <span
                    style="text-decoration: line-through; color: red">Rp
                    <?= number_format($item['harga_produk'], 0, ',', '.'); ?> </span>
                </h3>
                <?php else : ?>
                <h3>
                  Rp <?= number_format($item['harga_produk'], 0, ',', '.'); ?>
                </h3>
                <?php endif ?>
              </div>
            </div>
          </div>
          <?php endforeach ?>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- Product List End -->

<?= $this->endSection(); ?>
<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<?php
$db = \Config\Database::connect();


?>

<div class="contact">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="contact-info">
          <h2>Toko Kami</h2>
          <h3><i class="fa fa-map-marker"></i><?= $data['alamat']; ?></h3>
          <h3><i class="fa fa-phone"></i>+<?= $data['kontak_wa']; ?></h3>
          <h3><i class="fa fa-envelope"></i><?= $data['rekening_toko']; ?></h3>
          <p>
            <?= $data['tentang']; ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="product mb-4">
  <div class="section-header">
    <h1>Rekomendasi Produk</h1>
  </div>

  <div class="row align-items-center product-slider product-slider-4">

    <?php foreach ((array) $dataRekom as $item) : ?>

      <?php
      $getImg = $db->table('produk_detail_gambar')->where('id_produk', $item['id_produk'])->orderBy('id_detail_gambar', 'RANDOM')->get()->getRowArray();
      ?>

      <div class="col-lg-3" style="max-width: 100%;">
        <div class="product-item">
          <div class="product-title">
            <a href="/Katalog/<?= $item['id_produk']; ?>">
              <?= $item['nama_produk']; ?>
            </a>
            <div class="ratting">
              ⭐⭐⭐⭐⭐
            </div>
          </div>
          <div class="product-image">
            <a href="/Katalog/1">
              <img src="/uploads/<?= $getImg['file']; ?>" alt="Product Image">
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

    <?php
    endforeach
    ?>

  </div>
</div>

<?= $this->endSection(); ?>
<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<?php
$db = \Config\Database::connect();


?>

<div class="review">
  <div class="container-fluid">
    <h1>Testimoni</h1>

    <?php if (empty($data)) : ?>
      <div class="col-md-12 bg-white p-5">
        <p class="text-center">Belum ada testimoni.</p>
      </div>
    <?php endif ?>

    <div class="row align-items-center review-slider normal-slider">

      <?php foreach ($data as $item) : ?>
        <div class="col-md-6">
          <div class="review-slider-item">
            <div class="review-img">
              <img src="https://www.pngrepo.com/png/102030/180/user.png" alt="Image">
            </div>
            <div class="review-text">
              <h2><?= $item['nama_customer']; ?></h2>
              <h3>Membeli produk <?= $item['nama_produk']; ?></h3>
              <div class="ratting">
                <?php for ($i = 0; $i < $item['rating']; $i++) : ?>
                  <i class="fa fa-star text-warning"></i>
                <?php endfor; ?>
              </div>
              <p>
                <?= $item['review']; ?>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach ?>

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
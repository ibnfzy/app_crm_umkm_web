<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>
<?php
$db = \Config\Database::connect();
?>
<!-- Main Slider Start -->
<div class="header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="header-slider normal-slider">

          <div class="header-slider-item">
            <img src="/web_assets/img/slider-1.jpg" alt="Slider Image" />
          </div>

          <div class="header-slider-item">
            <img src="/web_assets/img/slider-2.jpg" alt="Slider Image" />
          </div>

          <div class="header-slider-item">
            <img src="/web_assets/img/slider-3.jpg" alt="Slider Image" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Main Slider End -->

<hr>

<!-- Call to Action Start -->
<div class="call-to-action">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1>Selamat Datang di website Bunga Desa</h1>
      </div>
      <div class="col-md-6">
        <p class="text-white">
          <!-- $toko['tentang'] -->
          Lorem ipsum dolor sit amet consectetur adipisicing elit.
          Consequuntur, nemo.
        </p>
      </div>
    </div>
  </div>
</div>
<!-- Call to Action End -->

<!-- Featured Product Start -->
<div class="featured-product product">
  <div class="container-fluid">
    <div class="section-header">
      <h1>Produk Bunga Desa</h1>
    </div>
    <div class="row align-items-center product-slider product-slider-4">
      <?php foreach ((array) $dataProduk as $item) : ?>

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
</div>
<!-- Featured Product End -->
<?= $this->endSection(); ?>
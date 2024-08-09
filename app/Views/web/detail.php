<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<?php $db = \Config\Database::connect(); ?>

<!-- Product Detail Start -->
<div class="product-detail">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-md-9">
          <div class="product-detail-top">
            <div class="row align-items-center">
              <div class="col-md-5">
                <div class="product-slider-single normal-slider">

                  <?php foreach ((array) $dataImg as $item) : ?>
                  <img src="/Uploads/<?= $item['file'] ?>" alt="Product Image">
                  <?php endforeach ?>

                </div>
                <div class="product-slider-single-nav normal-slider">

                  <?php foreach ((array) $dataImg as $item) : ?>
                  <div class="slider-nav-img"><img src="/Uploads/<?= $item['file'] ?>" alt="Product Image"></div>
                  <?php endforeach ?>

                </div>
              </div>
              <form action="#" method="POST">
                <input type="hidden" name="id_produk_detail" id="id_produk_detail" value="#">
                <div class="">
                  <div class="product-content">
                    <div class="title">
                      <h2>
                        <?= $data['nama_produk']; ?>
                      </h2>
                    </div>
                    <div class="ratting">
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      ( 0 )
                    </div>
                    <div class="price">
                      <h4>Price:</h4>
                      <p id="price"> Rp <?= number_format($data['harga_promo'], 0, ',', '.'); ?>
                        <span class="text-danger">Rp <?= number_format($data['harga_produk'], 0, ',', '.'); ?></span>
                      </p>
                    </div>
                    <div class="price">
                      <h4>Stok:</h4>
                      <p id="stok">
                        <?= $data['stok']; ?>
                      </p>
                    </div>
                    <div class="quantity">
                      <h4>Kuantitas:</h4>
                      <div class="qty">
                        <button type="button" class="btn-minus"><i class="fa fa-minus"></i></button>
                        <input type="text" value="1" name="qty">
                        <button type="button" class="btn-plus"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>

                    <div class="action">
                      <button type="submit" class="btn"><i class="fa fa-shopping-cart"></i>Tambah Ke keranjang</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="row product-detail-bottom">
          <div class="col-lg-12">
            <ul class="nav nav-pills nav-justified">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#description">Deskripsi Produk</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#reviews">Reviews ( 3 )
                </a>
              </li>
            </ul>

            <div class="tab-content">

              <div id="description" class="container tab-pane active">
                <!-- <h4>Product description</h4> -->
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc vel interdum tristique,
                  eros metus venenatis nibh, in tincidunt nunc nisi eu nibh. Sed vitae nibh sed nisl mattis tincidunt.
                  Sed vitae nunc eget nibh aliquam ultricies. Sed feugiat, sem et dapibus tristique, velit nibh aliquam
                  nunc, sed facilisis nibh nunc id eros. Sed euismod, nunc vel interdum tristique, eros metus venenatis
                  nibh, in tincidunt nunc nisi eu nibh.</p>
              </div>

              <div id="reviews" class="container tab-pane fade">

                <div class="reviews-submitted">
                  <div class="reviewer">
                    TEST - <span>
                      32-12-2021
                    </span>
                  </div>
                  <div class="ratting">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc vel interdum tristique,
                    eros metus venenatis nibh, in tincidunt nunc nisi eu nibh. Sed vitae nibh sed nisl mattis tincidunt.
                    Sed vitae nunc eget nibh aliquam ultricies. Sed feugiat, sem et dapibus tristique, velit nibh
                    aliquam nunc, sed facilisis nibh nunc id eros. Sed euismod, nunc vel interdum tristique, eros metus
                    venenatis nibh, in tincidunt nunc nisi eu nibh.</p>
                </div>

                <!-- <div class="reviews-submitted">
                  <p>Review Kosong</p>
                </div> -->

              </div>
            </div>
          </div>
        </div>

        <div class="product">
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
      </div>
    </div>
  </div>
</div>
<!-- Product Detail End -->

<?= $this->endSection(); ?>
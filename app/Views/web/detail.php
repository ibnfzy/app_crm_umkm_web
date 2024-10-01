<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<?php
$db = \Config\Database::connect();

$home = new \App\Controllers\Home;
$star = $home->review_star($data['id_produk']);
$total_star = $home->total_review($data['id_produk']);
$review = $home->review($data['id_produk']);
$pbagi = count($review);

?>

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
                  <img src="/uploads/<?= $item['file'] ?>" alt="Product Image">
                  <?php endforeach ?>

                </div>
                <div class="product-slider-single-nav normal-slider">

                  <?php foreach ((array) $dataImg as $item) : ?>
                  <div class="slider-nav-img"><img src="/uploads/<?= $item['file'] ?>" alt="Product Image"></div>
                  <?php endforeach ?>

                </div>
              </div>
              <form action="<?= base_url('Cart/Add'); ?>" method="POST">
                <input type="hidden" name="id_produk" id="id_produk" value="<?= $data['id_produk']; ?>">
                <div class="">
                  <div class="product-content">
                    <div class="title">
                      <h2>
                        <?= $data['nama_produk']; ?>
                      </h2>
                    </div>
                    <div class="ratting">
                      <?= $star; ?>
                      (
                      <?= $total_star; ?> )
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
                        <button type="button" class="btn-minus" id="btn-minus"><i class="fa fa-minus"></i></button>
                        <input type="text" value="1" name="qty" id="qty">
                        <button type="button" class="btn-plus" id="btn-plus"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>

                    <div class="action">
                      <button type="submit" class="btn"><i class="fa fa-shopping-cart px-2"></i>Tambah Ke
                        keranjang</button>
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
                <a class="nav-link active" data-toggle="pill" href="#description"
                  style="color: white !important;">Deskripsi Produk</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#reviews" style="color: white !important;">Reviews (
                  <?= $total_star; ?> )
                </a>
              </li>
            </ul>

            <div class="tab-content">

              <div id="description" class="container tab-pane active">
                <!-- <h4>Product description</h4> -->
                <?= $data['deskripsi']; ?>
              </div>

              <div id="reviews" class="container tab-pane fade">

                <?php if ($review == null) : ?>
                <div class="reviews-submitted">
                  <p>Review Kosong</p>
                </div>
                <?php endif ?>

                <?php foreach ($review as $item) : ?>
                <?php $cust = $home->getDataCustomerSingle($item['id_customer']); ?>
                <div class="reviews-submitted">
                  <div class="reviewer">
                    <?= $cust['nama_customer']; ?> - <span>
                      <?= $item['created_at']; ?>
                    </span>
                  </div>
                  <div class="ratting">
                    <?php for ($i = 0; $i < $item['rating']; $i++): ?>
                    <i class="fa fa-star"></i>
                    <?php endfor ?>
                  </div>
                  <p>
                    <?= $item['review']; ?>
                  </p>
                </div>
                <?php endforeach ?>

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

<?= $this->section('script'); ?>

<script>
const updateQty = () => {
  let qty = $('#qty').val();
  const stok = parseInt($('#stok').text(), 10);

  if (qty > stok) {
    $('#qty').val(stok);
  }
}

$('#qty').on('change', updateQty);

$('#btn-plus').on('click', updateQty);

$('#btn-minus').on('click', updateQty);
</script>

<?= $this->endSection(); ?>
<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>
<?php $db = \Config\Database::connect(); ?>

<!-- Product List Start -->
<div class="product-view">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">

          <!-- <div class="col-md-12" style="padding: 15px; text-align: center;">Data tidak ditemukan</div> -->

          <div class="col-md-3">
            <div class="product-item">
              <div class="product-title">
                <a href="#">
                  TEST
                </a>
                <div class="ratting">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>

                </div>
              </div>
              <div class="product-image">
                <a href="#">
                  <img src="/web_assets/img/product-1.jpg" alt="Product Image">
                </a>
                <div class="product-action">
                  <a href="#"><i class="fa fa-eye"></i></a>
                </div>
              </div>
              <div class="product-price">
                <h3>
                  Rp. 200
                </h3>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- Product List End -->

<?= $this->endSection(); ?>
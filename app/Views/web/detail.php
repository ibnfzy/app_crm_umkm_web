<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

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

                  <img src="/web_assets/img/product-1.jpg" alt="Product Image">

                  <img src="/web_assets/img/product-1.jpg" alt="Product Image">

                  <img src="/web_assets/img/product-1.jpg" alt="Product Image">

                  <img src="/web_assets/img/product-1.jpg" alt="Product Image">

                </div>
                <div class="product-slider-single-nav normal-slider">

                  <div class="slider-nav-img"><img src="/web_assets/img/product-1.jpg" alt="Product Image"></div>

                  <div class="slider-nav-img"><img src="/web_assets/img/product-1.jpg" alt="Product Image"></div>

                  <div class="slider-nav-img"><img src="/web_assets/img/product-1.jpg" alt="Product Image"></div>

                </div>
              </div>
              <form action="#" method="POST">
                <input type="hidden" name="id_produk_detail" id="id_produk_detail" value="#">
                <div class="">
                  <div class="product-content">
                    <div class="title">
                      <h2>
                        TEST
                      </h2>
                    </div>
                    <div class="ratting">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      ( 0 )
                    </div>
                    <div class="price">
                      <h4>Price:</h4>
                      <p id="price"> Rp
                        2000.000
                      </p>
                    </div>
                    <div class="price">
                      <h4>Stok:</h4>
                      <p id="stok">
                        23
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

            <div class="col-lg-3" style="max-width: 100%;">
              <div class="product-item">
                <div class="product-title">
                  <a href="#">
                    TEST
                  </a>
                  <div class="ratting">
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
                    Rp. 20
                  </h3>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Product Detail End -->

<?= $this->endSection(); ?>
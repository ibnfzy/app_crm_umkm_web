<!-- Nav Bar Start -->
<?php $cart = \Config\Services::cart(); ?>
<div class="nav">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
      <a href="<?= base_url() ?>#" class="navbar-brand">MENU</a>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav mr-auto">
          <a href="<?= base_url() ?>" class="nav-item nav-link">Home</a>
          <a href="<?= base_url('Katalog') ?>" class="nav-item nav-link">Katalog Produk</a>
          <a href="<?= base_url('OperatorPanel') ?>" class="nav-item nav-link">Login Operator</a>
        </div>
        <div class="navbar-nav ml-auto px-5">
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Akun</a>
            <div class="dropdown-menu">
              <?php if (session()->get('logged_in_customer')) : ?>
                <a href="<?= base_url('CustomerPanel') ?>" class="dropdown-item text-white">Customer Panel</a>
                <a href="<?= base_url('CustomerAuth/Logoff') ?>" class="dropdown-item text-white">Logout</a>
              <?php else : ?>
                <a href="<?= base_url('CustomerAuth') ?>" class="dropdown-item text-white">Login</a>
                <a href="<?= base_url('CustomerAuth/Register') ?>" class="dropdown-item text-white">Register</a>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</div>
<!-- Nav Bar End -->

<style>
  a.dropdown-item:hover {
    background-color: #0f7dc5;
  }
</style>

<!-- Bottom Bar Start -->
<div class="bottom-bar">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-3">
        <div class="logo">
          <a href="<?= base_url() ?>">
            <h5 class="font-weight-bold text-lg-center">BUNGA DESA</h5>
          </a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="search">
          <form action="<?= base_url('Search'); ?>" method="POST">
            <input type="text" placeholder="Cari berdasarkan nama produk" name="search">
            <button><i class="fa fa-search"></i></button>
          </form>
        </div>
      </div>
      <div class="col-md-3">
        <div class="user">
          <a href="<?= base_url('Cart') ?>" class="btn cart">
            <i class="fa fa-shopping-cart"></i>
            <span>(
              0 )
              <!-- $cart->totalItems(); -->
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Bottom Bar End -->
<!-- Sidebar -->
<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
      <a href="/OperatorPanel/Profile" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init
        aria-current="true">
        <i class="fa-solid fa-store fa-fw me-3"></i>
        <span>Profile Toko <span class="badge badge-info ms-2">8</span></span>
      </a>
      <a href="/OperatorPanel/Produk" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init>
        <i class="fa-solid fa-box-open fa-fw me-3"></i>
        <span>Produk </span>
      </a>
      <a href="/OperatorPanel/Kupon" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init>
        <i class="fa-solid fa-tags fa-fw me-3"></i>
        <span>Kupon</span></a>
      <a href="/OperatorPanel/Transaksi" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init>
        <i class="fa-solid fa-cart-shopping fa-fw me-3"></i>
        <span>Transaksi</span></a>
      <a href="/OperatorPanel/Pelanggan" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init>
        <i class="fa-solid fa-users fa-fw me-3"></i>
        <span>Pelanggan</span></a>
      <a href="/OperatorPanel/Review" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init>
        <i class="fa-solid fa-comment-dots fa-fw me-3"></i>
        <span>Review</span></a>
      <a href="/OperatorPanel/Ongkos_kirim" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init="">
        <i class="fa-solid fa-truck fa-fw me-3"></i>
        <span>Ongkos Kirim</span>
      </a>
      <a href="/OperatorPanel/Slider" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init="">
        <i class="fa-solid fa-images fa-fw me-3"></i>
        <span>Slider</span>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-2" data-mdb-ripple-init="" data-mdb-modal-init
        data-mdb-target="#laporan">
        <i class="fa-regular fa-file-pdf fa-fw me-3"></i>
        <span>Laporan Transaksi (Bulanan)</span>
      </a>
    </div>
  </div>
</nav>
<!-- Sidebar -->

<!-- Modal -->
<div class="modal fade" id="laporan" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Laporan Bulanan</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Laporan/Bulanan" method="post" enctype="application/x-www-form-urlencoded">
        <div class="modal-body">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="month" id="bulan" class="form-control" name="bulan" required>
            <label for="bulan" class="form-label">Pilih Bulan</label>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Proses</button>
        </div>
      </form>

    </div>
  </div>
</div>
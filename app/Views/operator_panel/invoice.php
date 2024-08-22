<?= $this->extend('operator_panel/base'); ?>

<?= $this->section('content'); ?>

<?php
$controler = new \App\Controllers\CustomerPanel;
$hargaArr = [];
?>

<section class="my-4">
  <button class="btn btn-primary my-2" onclick="window.location='/OperatorPanel/Transaksi'">Kembali</button>
  <div class="card" id="invoice">
    <div class="card-body">
      <div class="container mb-5 mt-3">
        <div class="row d-flex align-items-baseline mb-5">
          <div class="col-xl-9">
            <h3>Detail Transaksi / Invoice</h3>
            <p style="color: #7e8d9f;font-size: 20px;">Invoice <strong>ID: #<?= $data_transaksi['id_unique_transaksi'] ?></strong></p>
            <!-- <h4>Bunga Desa</h4> -->
          </div>
          <div class="col-xl-3">
            <button class="btn btn-secondary float-end no-print" data-mdb-ripple-init data-mdb-ripple-color="light" onclick="printDiv('invoice')">Print</button>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-xl-8">
              <ul class="list-unstyled">
                <li class="text-muted">Kepada: <span style="color:#8f8061 ;"><?= $data_customer['nama_customer']; ?></span></li>
                <li class="text-muted"><?= $data_customer['alamat']; ?></li>
                <li class="text-muted"><?= $data_customer['nama_kota']; ?></li>
                <li class="text-muted"><i class="fas fa-phone"></i>
                  <?= preg_replace('/(\d{2})(\d{11})/m', "+$1 $2", $data_customer['no_wa']); ?></li>
              </ul>
            </div>
            <div class="col-xl-4">
              <p class="text-muted">Detail</p>
              <ul class="list-unstyled">
                <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061 ;"></i> <span
                    class="fw-bold">Tanggal Beli: </span> <?= $data_transaksi['tanggal_checkout']; ?></li>
                <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061;"></i> <span
                    class="me-1 fw-bold">Status:</span>
                  <span class="badge bg-warning text-black fw-bold">
                    <?= $data_transaksi['status_transaksi']; ?></span>
                </li>
              </ul>
            </div>
          </div>
          <?php foreach ($data_detail as $item) : ?>
            <?php
            $gambarProduk = $controler->getRandomImageProduk($item['id_produk']);
            $hargaArr[] = $item['subtotal'];
            ?>
            <div class="row my-2 mx-1 justify-content-center">
              <div class="col-md-2 mb-4 mb-md-0">
                <div class="
                        bg-image
                        ripple
                        rounded-5
                        mb-4
                        overflow-hidden
                        d-block
                        " data-ripple-color="light">
                  <img src="/uploads/<?= $gambarProduk['file'] ?>"
                    class="w-100" height="100px" alt="#" />
                  <a href="#!">
                    <div class="hover-overlay">
                      <div class="mask" style="background-color: hsla(0, 0%, 98.4%, 0.2)"></div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-md-7 mb-4 mb-md-0">
                <p class="fw-bold"><?= $item['nama_produk']; ?></p>
                <p class="mb-1">
                  <span class="text-muted me-2">Kuantitas:</span><span><?= $item['kuantitas']; ?></span> <br>
                  <span class="text-muted me-2">Harga Produk:</span><span>Rp <?= number_format($item['harga_produk_beli'], 0, ',', '.') ?></span>
                </p>
              </div>
              <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="mb-2">
                  <span class="align-middle">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></span>
                </h5>
              </div>
            </div>
          <?php endforeach ?>
          <hr>
          <div class="row">
            <div class="col-xl-8">
              <p class="ms-3">
                Silahkan lakukan pembayaran dengan transfer ke rekening berikut: <br>
                <span class="badge bg-primary fw-bold"> BRI 1234567890 a.n. Bunga Desa</span>
              </p>
            </div>
            <?php

            $potongan = array_sum($hargaArr) * ($data_transaksi['diskon'] / 100);
            if ($potongan > $data_transaksi['max_potongan']) {
              $potongan = $data_transaksi['max_potongan'];
            }

            ?>
            <div class="col-xl-3">
              <ul class="list-unstyled">
                <li class="text-muted ms-3"><span class="text-black me-4">Diskon</span><?= $data_transaksi['diskon']; ?>%</li>
                <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span>Rp <?= number_format(array_sum($hargaArr), 0, ',', '.'); ?></li>
                <li class="text-muted ms-3"><span class="text-black me-4">Potongan</span>Rp <?= number_format($potongan, 0, ',', '.'); ?></li>
                <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Ongkos Kirim</span>Rp <?= number_format($data_customer['tarif'], 0, ',', '.'); ?></li>
              </ul>
              <p class="text-black float-start"><span class="text-black me-3"> Total Amount</span><span
                  style="font-size: 25px;">Rp <?= number_format($data_transaksi['total_bayar_belanja'], 0, ',', '.'); ?></span></p>
            </div>
          </div>
          <div class="col-12">
            <?php if ($data_transaksi['status_transaksi'] == 'Menunggu validasi bukti pembayaran') : ?>
              <button type="button" class="btn btn-primary btn-lg btn-block no-print" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#uploadBukti">Lihat Bukti Pembayaran</button>
            <?php endif ?>

            <?php if ($data_transaksi['status_transaksi'] == 'Pembayaran diterima, menunggu pesanan diproses') : ?>
              <button type="button" class="btn btn-primary btn-lg btn-block no-print" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#proses_pesanan">Proses pesanan</button>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="uploadBukti" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Validasi Bukti Pembayaran</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Validasi" method="post">
        <div class="modal-body">
          <input type="hidden" name="id_transaksi" value="<?= $data_transaksi['id_transaksi']; ?>">

          <div class="mb-4">
            <a href="/uploads/<?= $data_transaksi['bukti_bayar']; ?>" data-fancybox="bukti_bayar">
              <img src="/uploads/<?= $data_transaksi['bukti_bayar']; ?>" alt="" width="100%">
            </a>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Validasi</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="proses_pesanan" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="tambahLabel">Proses Pesanan</h5>
        <button type="button" class="btn-close bg-white" data-mdb-ripple-init data-mdb-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Proses" method="post">
        <div class="modal-body">
          <input type="hidden" name="id_transaksi" value="<?= $data_transaksi['id_transaksi']; ?>">

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="text" id="nama_ekspedisi" class="form-control" name="nama_ekspedisi" required>
            <label for="nama_ekspedisi" class="form-label">Nama Ekspedisi</label>
          </div>

          <div class="form-outline mb-4" data-mdb-input-init>
            <input type="number" id="nomor_resi" class="form-control" name="nomor_resi" required>
            <label for="nomor_resi" class="form-label">Nomor Resi</label>
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
  function printDiv(divId) {
    // Ambil elemen div yang ingin dicetak
    var divToPrint = document.getElementById(divId);

    // Buat jendela baru
    var newWin = window.open('', 'Print-Window');

    // Dapatkan semua stylesheet yang digunakan pada halaman
    var css = '';
    for (var i = 0; i < document.styleSheets.length; i++) {
      if (document.styleSheets[i].href) {
        css += '<link rel="stylesheet" type="text/css" href="' + document.styleSheets[i].href + '">';
      }
    }

    // Tulis isi HTML ke dalam jendela baru
    newWin.document.open();
    newWin.document.write('<html><head><title>Print</title>');
    newWin.document.write(css);
    newWin.document.write('</head><body>');
    newWin.document.write(divToPrint.innerHTML);
    newWin.document.write('</body></html>');
    newWin.document.close();

    // Tunggu sampai dokumen selesai dimuat, kemudian cetak
    setTimeout(function() {
      newWin.print();
      newWin.close();
    }, 1000);
  };
</script>

<?= $this->endSection(); ?>
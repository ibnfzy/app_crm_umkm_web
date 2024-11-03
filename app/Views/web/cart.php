<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<?php

$cart = \Config\Services::cart();
$db = \Config\Database::connect();
$home = new \App\Controllers\Home;
$total = [];
?>

<div class="cart-page">
  <div class="container-fluid">
    <div class="col lg 12">
      <!-- php while (session()->get('stok_status') == 'Tidak Mencukupi') : -->

      <!-- php session()->set('stok_status', null); -->
      <!-- php endwhile; -->

      <?php while (session()->get('stok_status') == 'Tidak Mencukupi') : ?>
        <div class="alert alert-warning alert-dismissible fade show py-2" role="alert">
          <strong>Ada Stok Produk tidak cukup!</strong> kuantitas produk automatis menyusuaikan stok yang ada
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <?php session()->set('stok_status', null); ?>
      <?php endwhile; ?>

      <?php if ($notice_delete) : ?>
        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
          <strong>Pemberitahuan!</strong> Kuantitas produk pada keranjangmu melebihi stok produk, dan automatis terhapus,
          silahkan tambahkan ulang produk
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif ?>

      <!--php if ($notice_delete) : -->

      <!-- php endif -->

    </div>
    <form action="<?= base_url('Cart/Update'); ?>" method="post">
      <div class="row">
        <div class="col-lg-8">
          <div class="cart-page-inner">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Subtotal</th>
                    <th>Hapus</th>
                  </tr>
                </thead>
                <tbody class="align-middle">
                  <?php $q = 1; ?>

                  <?php if ($cart->totalItems() == 0) : ?>
                    <tr>
                      <td colspan="6" class="text-center">Keranjangmu Kosong</td>
                    </tr>
                  <?php endif ?>

                  <?php foreach ($cart->contents() as $i => $item) : ?>

                    <?php $subTotal = $item['price'] * $item['qty']; ?>

                    <?php $total[] = $subTotal; ?>

                    <input type="hidden" name="rowid[<?= $item['rowid'] ?>]" value="<?= $item['rowid'] ?>">
                    <input type="hidden" name="stok[<?= $item['rowid'] ?>]" value="<?= $item['stok'] ?>">
                    <input type="hidden" name="qtybutton[<?= $item['rowid'] ?>]" value="<?= $item['qty'] ?>">
                    <tr>
                      <td>
                        <div class="img">
                          <a href="#"><img src="/uploads/<?= $item['gambar'] ?>" alt="Image"></a>
                          <p>
                            <a href="#">
                              <?= $item['name']; ?>
                            </a>
                          </p>
                        </div>
                      </td>
                      <td>
                        <?= $item['stok']; ?>
                      </td>
                      <td>Rp. <?= number_format($item['price'], 0, ',', '.'); ?>
                      </td>
                      <td>
                        <div class="qty">
                          <button type="button" class="btn-minus" id="btn-minus-<?= $q ?>"
                            data-stok="<?= $item['stok'] ?>"><i class="fa fa-minus"></i></button>
                          <input id="qty<?= $q ?>" type="text" value="<?= $item['qty']; ?>" name="qtybutton[<?= $i ?>]"
                            data-stok="<?= $item['stok'] ?>">
                          <button type="button" class="btn-plus" id="btn-plus-<?= $q ?>"><i class="fa fa-plus"
                              data-stok="<?= $item['stok'] ?>"></i></button>
                        </div>
                      </td>
                      <td>Rp. <?= number_format($subTotal, 0, ',', '.'); ?></td>
                      <td>
                        <a href="/Cart/Delete/<?= $item['rowid'] ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php $q++; ?>
                  <?php endforeach ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <?php
        $discount = session()->get('discount_kupon') ? session()->get('discount_kupon') : 0;
        $max_discount = session()->get('max_nominal_kupon') ? session()->get('max_nominal_kupon') : 0;
        $total_harga = array_sum($total);
        $ongkir = $home->getDataOngkirCustomer($dataCustomer['id_ongkir']);
        $potongan = $total_harga * ($discount / 100);
        if ($potongan > $max_discount) {
          $potongan = $max_discount;
        }

        $grandTotal = $total_harga - $potongan + $ongkir['tarif'];
        ?>

        <div class="col-lg-4">
          <div class="cart-page-inner">
            <div class="row">
              <div class="col-md-12">
                <div class="py-3">
                  <?php if (session()->get('discount_kupon') != 0 || session()->get('discount_kupon') != null) : ?>
                    <button class="btn bg-success text-white" data-toggle="modal" data-target="#voucher" type="button"
                      data-idCustKupon="<?= session()->get('id_customer_kupon'); ?>">Kupon Diskon
                      <?= session()->get('discount_kupon'); ?>% terpakai</button>
                  <?php else : ?>
                    <button class="btn btn-outlined-danger" data-toggle="modal" data-target="#voucher" type="button">Pilih
                      Voucher</button>
                  <?php endif ?>
                </div>
              </div>
              <div class="col-md-12">
                <div class="cart-summary">
                  <div class="cart-content">
                    <h1>Detail Keranjang</h1>
                    <p>Diskon<span><?= $discount; ?>%</span></p>
                    <p>Sub Total<span>Rp <?= number_format($total_harga, 0, ',', '.'); ?></span></p>
                    <p>Potongan<span> Rp <?= number_format($potongan, 0, ',', '.'); ?></span></p>
                    <p>Biaya Pengiriman<span>Rp <?= number_format($ongkir['tarif'], 0, ',', '.'); ?></span></p>
                    <h2>Grand Total<span>Rp <?= number_format($grandTotal, 0, ',', '.'); ?></span></h2>
                  </div>
                  <div class="cart-btn row">
                    <button type="submit">Update Keranjang</button>
                    <button type="button" class="btn btn-outlined-danger text-white"
                      onclick="modalShow()">Checkout</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>

    <div class="product pt-1 pb-5">
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

<!-- Modal -->
<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('CustomerPanel/Checkout'); ?>" method="get">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Yakin pesanan sudah sesuai?, pesanan tidak bisa diubah setelah diproses
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Proses</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="voucher" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="voucherModalLabel">Pilih Voucher</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="voucherForm" action="<?= base_url('Cart/ApplyVoucher'); ?>" method="post">
          <!-- List of Vouchers -->
          <div class="list-group">
            <?php foreach ($dataKupon as $voucher) : ?>
              <style>
                .bg-gradient {
                  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
                }

                .bg-gradient-selected {
                  background: linear-gradient(to bottom, #c6efce, #a5d6a7);
                }
              </style>
              <label
                class="list-group-item px-5 <?= $voucher['id_customer_kupon'] == session()->get('id_customer_kupon') ? 'bg-gradient-selected' : 'bg-gradient' ?>"
                ;?>">
                <input type="radio" class="form-check-input me-2" name="voucher_id"
                  value="<?= $voucher['id_customer_kupon']; ?>"
                  <?= $voucher['id_customer_kupon'] == session()->get('id_customer_kupon') ? 'checked' : ''; ?>> Max
                Potongan Rp.
                <?= number_format($voucher['max_nominal_kupon'], 0, ',', '.'); ?> - Diskon:
                <?= $voucher['discount_kupon']; ?>% <br>
                Deskripsi : <?= $voucher['deskripsi_kupon']; ?>
              </label>
            <?php endforeach; ?>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" form="voucherForm">Gunakan</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  function modalShow() {
    $('#requestVal').val($('#request').val());
    $('#konfirmasi').modal('show');
  }
</script>
<?= $this->endSection(); ?>
<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<div class="cart-page">
  <div class="container-fluid">
    <div class="col lg 12">
      <!-- php while (session()->get('stok_status') == 'Tidak Mencukupi') : -->

      <!-- php session()->set('stok_status', null); -->
      <!-- php endwhile; -->

      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Ada Stok Produk tidak cukup!</strong> kuantitas produk automatis menyusuaikan stok yang ada
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <br>

      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Pemberitahuan!</strong> Kuantitas produk pada keranjangmu melebihi stok produk, dan automatis terhapus,
        silahkan tambahkan ulang produk
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

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
                    <th>Total</th>
                    <th>Hapus</th>
                  </tr>
                </thead>
                <tbody class="align-middle">

                  <!-- <tr>
                    <td colspan="7">Keranjang Kosong</td>
                  </tr> -->

                  <!-- php foreach ($cart->contents() as $data) : ?>
                    <input type="hidden" name="rowid[$i;]" value="$data['rowid'];">
                    <input type="hidden" name="stok[$i;]" value="$data['stok'];">
                    <input type="hidden" value="$data['qty'];" name="qtybutton[$i]">
                    [data]
                     $total[] = $subTotal;
                    $i++; >
                   endforeach -->

                  <tr>
                    <td>
                      <div class="img">
                        <a href="#"><img src="/web_assets/img/product-1.jpg" alt="Image"></a>
                        <p>
                          <a href="#">
                            TEST
                          </a>
                        </p>
                      </div>
                    </td>
                    <td>
                      3
                    </td>
                    <td>Rp. 321
                    </td>
                    <td>
                      <div class="qty">
                        <button type="button" class="btn-minus"><i class="fa fa-minus"></i></button>
                        <input type="text" value="1" name="qtybutton[1]">
                        <button type="button" class="btn-plus"><i class="fa fa-plus"></i></button>
                      </div>
                    </td>
                    <td>Rp. 43</td>
                    <td>
                      <a href="#"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cart-page-inner">
            <div class="row">
              <div class="col-md-12">
                <div class="coupon">
                  <a class="btn btn-outlined-danger p-3" href="<?= base_url('Panel/Cart/Simpan'); ?>">Simpan
                    Keranjang</a>
                </div>
              </div>
              <div class="col-sm-12">
                <textarea class="form-control" name="request" id="request" cols="10" rows="3"
                  placeholder="Pesan untuk penjual (Seperti Request Nama)"></textarea>
              </div>
              <div class="col-md-12">
                <div class="cart-summary">
                  <div class="cart-content">
                    <h1>Detail Keranjang</h1>
                    <p>Diskon<span>10%</span></p>
                    <p>Sub Total<span>Rp 1000</span></p>
                    <p>Potongan<span>Rp1000</span></p>
                    <p>Biaya Pengiriman<span>Rp 1000</span></p>
                    <h2>Grand Total<span>Rp 1000</span></h2>
                  </div>
                  <div class="cart-btn">
                    <button type="submit">Update Keranjang</button>
                    <a class="btn btn-outlined-danger p-3" onclick="modalShow()">Checkout</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('Panel/Checkout'); ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="request" id="requestVal">
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
function modalShow() {
  $('#requestVal').val($('#request').val());
  $('#konfirmasi').modal('show');
}
</script>
<?= $this->endSection(); ?>
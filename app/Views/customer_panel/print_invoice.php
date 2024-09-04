<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
</head>

<body>
  <?php
  $controler = new \App\Controllers\CustomerPanel;
  $hargaArr = [];
  ?>

  <table style="width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
    <tr>
      <td style="width: 70%;">
        <p style="margin: 0; text-align: left">
          <span style="font-weight: bold; font-size: 32px"><a href="<?= base_url(''); ?>"
              style="text-decoration: none; color: #000;"><?= $dataToko['nama_toko']; ?></a></span><br>
          <span style="font-size: 21px">Invoice/Detail Transaksi</span><br><?= $dataToko['alamat']; ?><br>Telp.
          <?= preg_replace("/^(\d{2})(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3-$4", $dataToko['kontak_wa']); ?>
        </p>
      </td>
      <td style="width: 30%; text-align: right;">
        <!-- Ganti path ke gambar logo dengan path absolut atau base64 -->
        <a href="<?= base_url(''); ?>">
          <img src="<?= $img ?>" alt="Logo" width="100">
        </a>
      </td>
    </tr>
  </table>

  <!-- Menggunakan tabel untuk menyampingkan "Kepada" dan "Keterangan Transaksi" -->
  <table style="width: 100%; margin-bottom: 20px;">
    <tr>
      <td style="width: 50%; vertical-align: top;">
        <h3 style="margin: 0; padding: 0;">Kepada:</h3>
        <p style="margin: 5px 0;"><?= $dataCustomer['nama_customer']; ?> <br>
          <?= $dataCustomer['alamat']; ?> <br>
          <?= $dataCustomer['nama_kota']; ?> <br>
          <?= preg_replace('/(\d{2})(\d{10})/m', "+$1 $2", $dataCustomer['no_wa']); ?>
        </p>
      </td>

      <td style="width: 50%; vertical-align: top;">
        <h3 style="margin: 0; padding: 0;">Keterangan Transaksi:</h3>
        <p style="margin: 5px 0;">Nomor Transaksi: <?= $dataTransaksi['id_unique_transaksi']; ?> <br>
          Tanggal Transaksi: <?= $dataTransaksi['tanggal_checkout']; ?> <br>
          Metode Pembayaran: Transfer Bank
        </p>
      </td>
    </tr>
  </table>

  <div style="margin-bottom: 20px;">
    <h3 style="margin: 0; padding: 0;">Detail Transaksi:</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
      <thead>
        <tr>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Nama Produk</th>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Kuantitas</th>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Harga Satuan</th>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($dataDetail as $item) : ?>
        <?php $hargaArr[] = $item['subtotal'];; ?>
        <tr>
          <td style="padding: 8px;"><?= $item['nama_produk']; ?></td>
          <td style="padding: 8px;"><?= $item['kuantitas']; ?></td>
          <td style="padding: 8px;">Rp <?= number_format($item['harga_produk_beli'], 0, ',', '.') ?></td>
          <td style="padding: 8px;">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
        </tr>
        <?php endforeach ?>

        <?php
        $potongan = array_sum($hargaArr) * ($dataTransaksi['diskon'] / 100);
        if ($potongan > $dataTransaksi['max_potongan']) {
          $potongan = $dataTransaksi['max_potongan'];
        }
        ?>

        <tr>
          <td colspan="3" style="padding: 8px; text-align: right; border-top: 1px solid #ddd;">Diskon</td>
          <td style="padding: 8px; border-top: 1px solid #ddd;"><?= $dataTransaksi['diskon']; ?>%</td>
        </tr>
        <tr>
          <td colspan="3" style="padding: 8px; text-align: right;">SubTotal</td>
          <td style="padding: 8px;">Rp
            <?= number_format(array_sum($hargaArr), 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Potongan</td>
          <td style="padding: 8px; font-weight: bold;">Rp
            <?= number_format($potongan, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Ongkos Kirim</td>
          <td style="padding: 8px; font-weight: bold;">Rp
            <?= number_format($dataCustomer['tarif'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Total Amount</td>
          <td style="padding: 8px; font-weight: bold;">Rp
            <?= number_format($dataTransaksi['total_bayar_belanja'], 0, ',', '.'); ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <p style="text-align: center; margin-top: 30px;">Terima kasih telah berbelanja dengan kami!</p>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Transaksi Produk</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 20px;">

  <!-- Header dengan Logo -->
  <table style="width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 0px;">
    <tr>
      <td style="width: 70%;">
        <p style="margin: 0; text-align: left">
          <span style="font-weight: bold; font-size: 32px"><a href="<?= base_url(''); ?>"
              style="text-decoration: none; color: #000;"><?= $informasiToko['nama_toko']; ?></a></span><br><span
            style="font-size: 21px">Laporan Transaksi Produk</span><br><?= $informasiToko['alamat']; ?><br>Telp.
          <?= preg_replace("/^(\d{2})(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3-$4", $informasiToko['kontak_wa']); ?>
        </p>
      </td>
      <td style="width: 30%; text-align: right; vertical-align: middle">
        <!-- Ganti path ke gambar logo dengan path absolut atau base64 -->
        <a href="<?= base_url(''); ?>">
          <img src="<?= $img ?>" alt="Logo" width="100">
        </a>
      </td>
    </tr>
  </table>

  <!-- Informasi Produk -->
  <p style="margin: 0">
  <h2 style="margin-bottom: 0px">Informasi Produk</h2>
  <strong>Nama Produk:</strong> <?= $getProduk['nama_produk']; ?> <br>
  <strong>Kode Produk:</strong> <?= $getProduk['id_unique_produk']; ?> <br>
  <strong>Harga:</strong> Rp <?= number_format($getProduk['harga_produk'], 0, ',', '.'); ?> <br>
  <strong>Harga Promo:</strong> Rp
  <?= number_format($getProduk['harga_promo'], 0, ',', '.'); ?> <br>
  <strong>Stok:</strong> <?= $getProduk['stok']; ?>
  </p>

  <!-- Tabel Transaksi -->
  <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead>
      <tr>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">No</th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Tanggal Transaksi
        </th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Nama Customer
        </th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Jumlah</th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Harga Satuan</th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; ?>
      <?php if (empty($data)) : ?>
      <tr>
        <td colspan="5" style="padding: 8px; border: 1px solid #000; text-align: center;">Tidak ada data</td>
      </tr>
      <?php endif ?>

      <?php foreach ($data as $key => $item) : ?>
      <?php $total += $item['subtotal']; ?>
      <tr>
        <td style="padding: 8px; border: 1px solid #000;"><?= $key + 1; ?></td>
        <td style="padding: 8px; border: 1px solid #000;"><?= $item['tanggal_checkout']; ?></td>
        <td style="padding: 8px; border: 1px solid #000;"><?= $item['nama_customer']; ?></td>
        <td style="padding: 8px; border: 1px solid #000;"><?= $item['kuantitas']; ?></td>
        <td style="padding: 8px; border: 1px solid #000;">Rp
          <?= number_format($item['harga_produk_beli'], 0, ',', '.'); ?></td>
        <td style="padding: 8px; border: 1px solid #000;">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
      </tr>
      <?php endforeach ?>

      <tr>
        <td colspan="5" style="padding: 8px; border: 1px solid #000; text-align: right; font-weight: bold;">Total</td>
        <td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Rp
          <?= number_format($total, 0, ',', '.'); ?></td>
      </tr>
    </tbody>
  </table>
</body>

</html>
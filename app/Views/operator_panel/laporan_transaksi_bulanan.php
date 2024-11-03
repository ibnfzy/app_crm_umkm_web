<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    Laporan Transaksi Bulanan
  </title>
</head>

<body>
  <table style="width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 40px;">
    <tr>
      <td style="width: 70%;">
        <p style="margin: 0; text-align: left">
          <span style="font-weight: bold; font-size: 32px"><a href="<?= base_url(''); ?>"
              style="text-decoration: none; color: #000;"><?= $informasiToko['nama_toko']; ?></a></span><br>
          <span style="font-size: 21px">Laporan Transaksi
            Bulanan</span><br><?= $informasiToko['alamat']; ?><br>Telp.
          <?= preg_replace("/^(\d{2})(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3-$4", $informasiToko['kontak_wa']); ?>
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
  <p style="margin: 0; color: white">TEST</p>

  <!-- Tabel Transaksi -->
  <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead>
      <tr>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">No</th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Tanggal Transaksi
        </th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Nama Customer
        </th>
        <th style="padding: 8px; border: 1px solid #000; background-color: #007bff; color: #ffffff;">Nama Produk
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
        <td style="padding: 8px; border: 1px solid #000;"><?= $item['nama_produk']; ?></td>
        <td style="padding: 8px; border: 1px solid #000;"><?= $item['kuantitas']; ?></td>
        <td style="padding: 8px; border: 1px solid #000;">Rp
          <?= number_format($item['harga_produk_beli'], 0, ',', '.'); ?></td>
        <td style="padding: 8px; border: 1px solid #000;">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?>
        </td>
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
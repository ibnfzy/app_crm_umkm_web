<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
</head>

<body>
  <table style="width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
    <tr>
      <td style="width: 70%;">
        <p style="margin: 0; text-align: left">
          <span style="font-weight: bold; font-size: 32px"><a href="<?= base_url(''); ?>"
              style="text-decoration: none; color: #000;"><?= $informasiToko['nama_toko']; ?></a></span><br>
          <span style="font-size: 21px">Invoice/Detail Transaksi</span><br><?= $informasiToko['alamat']; ?><br>Telp.
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

  <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <div style="width: 48%;">
      <h3 style="margin: 0; padding: 0;">Kepada:</h3>
      <p style="margin: 5px 0;">Nama Penerima</p>
      <p style="margin: 5px 0;">Alamat Penerima</p>
      <p style="margin: 5px 0;">Kota, Kode Pos</p>
      <p style="margin: 5px 0;">Negara</p>
    </div>

    <div style="width: 48%;">
      <h3 style="margin: 0; padding: 0;">Keterangan Transaksi:</h3>
      <p style="margin: 5px 0;">Nomor Transaksi: 123456789</p>
      <p style="margin: 5px 0;">Tanggal Transaksi: 01 September 2024</p>
      <p style="margin: 5px 0;">Metode Pembayaran: Transfer Bank</p>
    </div>
  </div>

  <div style="margin-bottom: 20px;">
    <h3 style="margin: 0; padding: 0;">Detail Transaksi:</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
      <thead>
        <tr>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Deskripsi</th>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Jumlah</th>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Harga Satuan</th>
          <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding: 8px;">Produk A</td>
          <td style="padding: 8px;">2</td>
          <td style="padding: 8px;">Rp 100,000</td>
          <td style="padding: 8px;">Rp 200,000</td>
        </tr>
        <tr>
          <td style="padding: 8px;">Produk B</td>
          <td style="padding: 8px;">1</td>
          <td style="padding: 8px;">Rp 150,000</td>
          <td style="padding: 8px;">Rp 150,000</td>
        </tr>
        <tr>
          <td colspan="3" style="padding: 8px; text-align: right; border-top: 1px solid #ddd;">Subtotal</td>
          <td style="padding: 8px; border-top: 1px solid #ddd;">Rp 350,000</td>
        </tr>
        <tr>
          <td colspan="3" style="padding: 8px; text-align: right;">Ongkos Kirim</td>
          <td style="padding: 8px;">Rp 50,000</td>
        </tr>
        <tr>
          <td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Total</td>
          <td style="padding: 8px; font-weight: bold;">Rp 400,000</td>
        </tr>
      </tbody>
    </table>
  </div>

  <p style="text-align: center; margin-top: 30px;">Terima kasih telah berbelanja dengan kami!</p>
</body>

</html>
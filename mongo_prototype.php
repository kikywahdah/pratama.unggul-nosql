<?php
require 'vendor/autoload.php';

// Membuat koneksi ke database
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->klinik;

// Memasukkan sampel data
// a) Koleksi Pasien
$db->pasien->insertOne([
    "nik" => "7310123456780001",
    "nama_lengkap" => "Alif Nurdin",
    "tempat_lahir" => "Barru",
    "tanggal_lahir" => "2001-08-04",
    "jenis_kelamin" => "Laki-laki",
    "alamat" => "Jl. Andalas No. 10",
    "no_telepon" => "082134567890"
]);

// b) Koleksi Obat
$db->obat->insertOne([
    "kode_obat" => "SML",
    "nama_obat" => "Sanmol",
    "jenis" => "Tablet",
    "harga" => 5000,
    "stok" => 100,
    "tanggal_masuk" => "2025-01-08",
    "tanggal_kadaluarsa" => "2026-01-08",
    "nomor_batch" => "SL5K010825"
]);

// c) Koleksi Rekam Medis
$db->rekam_medis->insertOne([
    "no_rekam_medis" => "RM-001KPU",
    "nik_pasien" => "7310123456780001",
    "id_dokter" => "2412493",
    "tanggal_periksa" => "2025-07-07",
    "keluhan" => "Sakit kepala",
    "diagnosis" => "Migrain",
    "pengobatan" => ["Sanmol", "Proris"],
    "keterangan" => "Disarankan istirahat cukup dan minum obat sesuai resep"
]);

// d) Koleksi Transaksi
$db->transaksi->insertOne([
    "id_pembayaran" => "1",
    "no_rekam_medis" => "RM-001KPU",
    "tanggal_pembayaran" => "2025-07-07",
    "biaya_konsultasi" => 250000,
    "total_biaya" => 298000
]);

$db->user->insertOne([
    "id_user" => "2412493",
    "nama_user" => "dr. Ratnasari",
    "username" => "KPURatnasari",
    "password" => "hashed_password",
    "level" => "DOKTER"
]);

// QUERY 1: Data pasien berdasarkan NIK
$pasien = $db->pasien->findOne(['nik' => '7310123456780001']);

// QUERY 2: Obat dengan stok < 150
$obat_list = $db->obat->find(['stok' => ['$lt' => 150]]);

// QUERY 3: Rekam medis oleh dokter ID 2412493
$rekam_medis_list = $db->rekam_medis->find(['id_dokter' => '2412493']);

// QUERY 4: Transaksi dengan total biaya > 250000
$transaksi_list = $db->transaksi->find(['total_biaya' => ['$gt' => 250000]]);

// QUERY 5: User dengan level "DOKTER"
$user_list = $db->user->find(['level' => 'DOKTER']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Output Query Sistem Klinik</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f0f2f5; }
        h2 { background: #007bff; color: white; padding: 10px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f8f9fa; }
        .not-found { color: red; font-style: italic; }
    </style>
</head>
<body>

    <h1>📊 Hasil 5 Query MongoDB - Sistem Klinik</h1>

    <!-- QUERY 1 -->
    <h2>Data Pasien Berdasarkan NIK</h2>
    <?php if ($pasien): ?>
    <table>
        <tr><th>NIK</th><td><?= $pasien['nik'] ?></td></tr>
        <tr><th>Nama Lengkap</th><td><?= $pasien['nama_lengkap'] ?></td></tr>
        <tr><th>Tempat Lahir</th><td><?= $pasien['tempat_lahir'] ?></td></tr>
        <tr><th>Tanggal Lahir</th><td><?= $pasien['tanggal_lahir'] ?></td></tr>
        <tr><th>Jenis Kelamin</th><td><?= $pasien['jenis_kelamin'] ?></td></tr>
        <tr><th>Alamat</th><td><?= $pasien['alamat'] ?></td></tr>
        <tr><th>No. Telepon</th><td><?= $pasien['no_telepon'] ?></td></tr>
    </table>
    <?php else: ?>
        <p class="not-found">Data pasien tidak ditemukan.</p>
    <?php endif; ?>

    <!-- QUERY 2 -->
    <h2>Obat dengan Stok Kurang dari 150</h2>
    <table>
        <thead>
            <tr><th>Kode Obat</th><th>Nama</th><th>Jenis</th><th>Stok</th><th>Harga</th></tr>
        </thead>
        <tbody>
        <?php foreach ($obat_list as $obat): ?>
            <tr>
                <td><?= $obat['kode_obat'] ?></td>
                <td><?= $obat['nama_obat'] ?></td>
                <td><?= $obat['jenis'] ?></td>
                <td><?= $obat['stok'] ?></td>
                <td>Rp <?= number_format($obat['harga'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- QUERY 3 -->
    <h2>Rekam Medis oleh Dokter ID 2412493</h2>
    <table>
        <thead>
            <tr><th>No Rekam Medis</th><th>NIK Pasien</th><th>Tanggal Periksa</th><th>Keluhan</th><th>Diagnosis</th></tr>
        </thead>
        <tbody>
        <?php foreach ($rekam_medis_list as $rekam): ?>
            <tr>
                <td><?= $rekam['no_rekam_medis'] ?></td>
                <td><?= $rekam['nik_pasien'] ?></td>
                <td><?= $rekam['tanggal_periksa'] ?></td>
                <td><?= $rekam['keluhan'] ?></td>
                <td><?= $rekam['diagnosis'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- QUERY 4 -->
    <h2>Transaksi dengan Total Biaya > Rp250.000</h2>
    <table>
        <thead>
            <tr><th>ID Pembayaran</th><th>No Rekam Medis</th><th>Tanggal Pembayaran</th><th>Total Biaya</th></tr>
        </thead>
        <tbody>
        <?php foreach ($transaksi_list as $trx): ?>
            <tr>
                <td><?= $trx['id_pembayaran'] ?></td>
                <td><?= $trx['no_rekam_medis'] ?></td>
                <td><?= $trx['tanggal_pembayaran'] ?></td>
                <td>Rp <?= number_format($trx['total_biaya'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- QUERY 5 -->
    <h2>User dengan Level "DOKTER"</h2>
    <table>
        <thead>
            <tr><th>ID User</th><th>Nama</th><th>Username</th><th>Level</th></tr>
        </thead>
        <tbody>
        <?php foreach ($user_list as $u): ?>
            <tr>
                <td><?= $u['id_user'] ?></td>
                <td><?= $u['nama_user'] ?></td>
                <td><?= $u['username'] ?></td>
                <td><?= $u['level'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>

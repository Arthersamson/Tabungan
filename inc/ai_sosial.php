<?php
include_once dirname(__FILE__) . "/upgrade_kas_sosial.php";

$koneksi->query("CREATE TABLE IF NOT EXISTS target_kas_sosial (
    id_target INT(11) NOT NULL AUTO_INCREMENT, 
    nama_target VARCHAR(100) NOT NULL DEFAULT 'Target Kas Sosial',
    target_nominal BIGINT(20) NOT NULL DEFAULT 0, 
    target_tanggal DATE NULL,
    dibuat_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    diperbarui_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id_target)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$ai_target_sosial = null;
$q = $koneksi->query("SELECT * FROM target_kas_sosial ORDER BY id_target DESC LIMIT 1"); 
if ($q) {
    $ai_target_sosial = $q->fetch_assoc();
}

if (isset($_POST['simpan_target_sosial'])) {
    $nama = trim($_POST['nama_target_sosial'] ?? 'Target Kas Sosial'); 
    $nominal = (int)preg_replace('/[^0-9]/', '', $_POST['target_nominal_sosial'] ?? '');
    $tanggal = !empty($_POST['target_tanggal_sosial']) ? $_POST['target_tanggal_sosial'] : null; 
    
    if ($nama === '') {
        $nama = 'Target Kas Sosial';
    }
    
    if ($nominal > 0) {
        if ($ai_target_sosial) {
            $st = $koneksi->prepare("UPDATE target_kas_sosial SET nama_target=?, target_nominal=?, target_tanggal=? WHERE id_target=?");
            $st->bind_param("sisi", $nama, $nominal, $tanggal, $ai_target_sosial['id_target']);
        } else {
            $st = $koneksi->prepare("INSERT INTO target_kas_sosial(nama_target, target_nominal, target_tanggal) VALUES(?,?,?)");
            $st->bind_param("sis", $nama, $nominal, $tanggal);
        }
        $st->execute();
        $st->close();
        echo "<script>window.location.href='index.php?page=rekap_ks&target=tersimpan';</script>";
        exit;
    }
}

$q = $koneksi->query("SELECT * FROM target_kas_sosial ORDER BY id_target DESC LIMIT 1");
if ($q) {
    $ai_target_sosial = $q->fetch_assoc();
}

$ai_masuk_sosial = 0;
$ai_keluar_sosial = 0;

$q = $koneksi->query("SELECT COALESCE(SUM(masuk),0) total FROM kas_sosial WHERE jenis='Masuk'");
if ($q && ($d = $q->fetch_assoc())) {
    $ai_masuk_sosial = (float)$d['total'];
}

$q = $koneksi->query("SELECT COALESCE(SUM(keluar),0) total FROM kas_sosial WHERE jenis='Keluar'");
if ($q && ($d = $q->fetch_assoc())) {
    $ai_keluar_sosial = (float)$d['total'];
}

$ai_saldo_sosial = $ai_masuk_sosial - $ai_keluar_sosial;
$ai_bulan_sosial = [];
$start = new DateTime('first day of -5 months');
$end = new DateTime('first day of next month');

$q = $koneksi->query("SELECT DATE_FORMAT(tgl_ks,'%Y-%m') bulan, COALESCE(SUM(masuk),0) masuk, COALESCE(SUM(keluar),0) keluar FROM kas_sosial WHERE tgl_ks>='" . $start->format('Y-m-d') . "' AND tgl_ks<'" . $end->format('Y-m-d') . "' GROUP BY DATE_FORMAT(tgl_ks,'%Y-%m') ORDER BY bulan ASC");

if ($q) {
    while ($d = $q->fetch_assoc()) {
        $ai_bulan_sosial[$d['bulan']] = (float)$d['masuk'] - (float)$d['keluar'];
    }
}

$vals = array_values($ai_bulan_sosial);
$ai_avg_sosial = count($vals) ? array_sum($vals) / count($vals) : 0;

$ai_progress_sosial = 0;
$ai_sisa_sosial = 0;
$ai_prediksi_sosial = null;
$ai_status_sosial = 'belum_ada_target';
$ai_status_text_sosial = 'Buat target Kas Sosial terlebih dahulu.';
$ai_saran_sosial = 'Masukkan target dana sosial agar AI dapat menghitung progres dan perkiraan waktunya.';

if ($ai_target_sosial && (float)$ai_target_sosial['target_nominal'] > 0) {
    $target = (float)$ai_target_sosial['target_nominal'];
    $ai_sisa_sosial = max(0, $target - $ai_saldo_sosial);
    $ai_progress_sosial = min(100, max(0, $ai_saldo_sosial / $target * 100));

    if ($ai_saldo_sosial >= $target) {
        $ai_status_sosial = 'tercapai';
        $ai_status_text_sosial = 'Target Kas Sosial sudah tercapai! 🎉';
        $ai_saran_sosial = 'Dana target sudah terpenuhi. Anda dapat menetapkan target sosial berikutnya.';
        $ai_prediksi_sosial = new DateTime();
    } elseif ($ai_avg_sosial > 0) {
        $bulan = (int)ceil($ai_sisa_sosial / $ai_avg_sosial);
        $ai_prediksi_sosial = new DateTime();
        $ai_prediksi_sosial->modify('+' . $bulan . ' months');

        if (!empty($ai_target_sosial['target_tanggal'])) {
            $deadline = new DateTime($ai_target_sosial['target_tanggal']);
            if ($ai_prediksi_sosial <= $deadline) {
                $ai_status_sosial = 'on_track';
                $ai_status_text_sosial = 'Target berpeluang tercapai tepat waktu.';
                $ai_saran_sosial = 'Pertahankan rata-rata saldo bersih sekitar ' . rupiah($ai_avg_sosial) . ' per bulan.';
            } else {
                $ai_status_sosial = 'berisiko';
                $ai_status_text_sosial = 'Target berisiko terlambat.';
                $hari = max(30, (new DateTime())->diff($deadline)->days);
                $perbulan = $ai_sisa_sosial / max(1, ceil($hari / 30));
                $ai_saran_sosial = 'Usahakan saldo bersih sekitar ' . rupiah($perbulan) . ' per bulan agar lebih dekat dengan deadline.';
            }
        } else {
            $ai_status_sosial = 'berjalan';
            $ai_status_text_sosial = 'Target sedang berjalan.';
            $ai_saran_sosial = 'Berdasarkan rata-rata transaksi saat ini, target diperkirakan tercapai sekitar ' . $ai_prediksi_sosial->format('d M Y') . '.';
        }
    } else {
        $ai_status_sosial = 'perlu_menabung';
        $ai_status_text_sosial = 'Belum cukup data untuk memprediksi target.';
        $ai_saran_sosial = 'Tambahkan pemasukan sosial secara rutin agar AI memiliki data untuk menghitung pola kas.';
    }
}
?>
<?php


$koneksi->query("CREATE TABLE IF NOT EXISTS target_tabungan (
    id_target INT(11) NOT NULL AUTO_INCREMENT,
    nama_target VARCHAR(100) NOT NULL DEFAULT 'Target Tabungan',
    target_nominal BIGINT(20) NOT NULL DEFAULT 0,
    target_tanggal DATE NULL,
    dibuat_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    diperbarui_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_target)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$ai_target = null;
$ai_query = $koneksi->query("SELECT * FROM target_tabungan ORDER BY id_target DESC LIMIT 1");
if ($ai_query) {
    $ai_target = $ai_query->fetch_assoc();
}


if (isset($_POST['simpan_target_tabungan'])) {
    $nama = trim(isset($_POST['nama_target']) ? $_POST['nama_target'] : 'Target Tabungan');
    $nominal = preg_replace('/[^0-9]/', '', isset($_POST['target_nominal']) ? $_POST['target_nominal'] : '');
    $nominal = (int)$nominal;
    $tanggal = !empty($_POST['target_tanggal']) ? $_POST['target_tanggal'] : null;

    if ($nama === '') $nama = 'Target Tabungan';

    if ($nominal > 0) {
        if ($ai_target) {
            $stmt = $koneksi->prepare("UPDATE target_tabungan SET nama_target=?, target_nominal=?, target_tanggal=? WHERE id_target=?");
            $stmt->bind_param("sisi", $nama, $nominal, $tanggal, $ai_target['id_target']);
        } else {
            $stmt = $koneksi->prepare("INSERT INTO target_tabungan (nama_target,target_nominal,target_tanggal) VALUES (?,?,?)");
            $stmt->bind_param("sis", $nama, $nominal, $tanggal);
        }
        $stmt->execute();
        $stmt->close();
        echo "<script>window.location.href='index.php?page=rekap_km&target=tersimpan';</script>";
        exit;
    }
}


$ai_target = null;
$ai_query = $koneksi->query("SELECT * FROM target_tabungan ORDER BY id_target DESC LIMIT 1");
if ($ai_query) $ai_target = $ai_query->fetch_assoc();

/* Saldo Tabungan Anda */
$ai_masuk = 0;
$ai_keluar = 0;
$q = $koneksi->query("SELECT COALESCE(SUM(masuk),0) AS total FROM kas_anda WHERE jenis='Masuk'");
if ($q && ($d = $q->fetch_assoc())) $ai_masuk = (float)$d['total'];

$q = $koneksi->query("SELECT COALESCE(SUM(keluar),0) AS total FROM kas_anda WHERE jenis='Keluar'");
if ($q && ($d = $q->fetch_assoc())) $ai_keluar = (float)$d['total'];

$ai_saldo = $ai_masuk - $ai_keluar;


$ai_bulan = array();
$ai_start = new DateTime('first day of -5 months');
$ai_end = new DateTime('first day of next month');

$q = $koneksi->query("SELECT DATE_FORMAT(tgl_km,'%Y-%m') AS bulan,
    COALESCE(SUM(masuk),0) AS masuk,
    COALESCE(SUM(keluar),0) AS keluar
    FROM kas_anda
    WHERE tgl_km >= '".$ai_start->format('Y-m-d')."'
      AND tgl_km < '".$ai_end->format('Y-m-d')."'
    GROUP BY DATE_FORMAT(tgl_km,'%Y-%m')
    ORDER BY bulan ASC");

if ($q) {
    while ($d = $q->fetch_assoc()) {
        $ai_bulan[$d['bulan']] = ((float)$d['masuk'] - (float)$d['keluar']);
    }
}
$ai_net_values = array_values($ai_bulan);
$ai_avg_bulanan = count($ai_net_values) ? array_sum($ai_net_values) / count($ai_net_values) : 0;


$ai_progress = 0;
$ai_sisa = 0;
$ai_prediksi = null;
$ai_status = 'belum_ada_target';
$ai_status_text = 'Buat target tabungan terlebih dahulu.';
$ai_saran = 'Masukkan target yang ingin dicapai agar AI dapat menghitung progres dan perkiraan waktunya.';

if ($ai_target && (float)$ai_target['target_nominal'] > 0) {
    $ai_target_nominal = (float)$ai_target['target_nominal'];
    $ai_sisa = max(0, $ai_target_nominal - $ai_saldo);
    $ai_progress = min(100, max(0, ($ai_saldo / $ai_target_nominal) * 100));

    if ($ai_saldo >= $ai_target_nominal) {
        $ai_status = 'tercapai';
        $ai_status_text = 'Target sudah tercapai! 🎉';
        $ai_saran = 'Pertahankan kebiasaan menabung. Anda bisa membuat target berikutnya.';
        $ai_prediksi = new DateTime();
    } elseif ($ai_avg_bulanan > 0) {
        $ai_bulan_dibutuhkan = (int)ceil($ai_sisa / $ai_avg_bulanan);
        $ai_prediksi = new DateTime();
        $ai_prediksi->modify('+' . $ai_bulan_dibutuhkan . ' months');

        if (!empty($ai_target['target_tanggal'])) {
            $ai_deadline = new DateTime($ai_target['target_tanggal']);
            if ($ai_prediksi <= $ai_deadline) {
                $ai_status = 'on_track';
                $ai_status_text = 'Target berpeluang tercapai tepat waktu.';
                $ai_saran = 'Pertahankan rata-rata tabungan sekitar ' . rupiah($ai_avg_bulanan) . ' per bulan.';
            } else {
                $ai_status = 'berisiko';
                $ai_status_text = 'Target berisiko terlambat.';
                $ai_saran = 'Coba tambah tabungan sekitar ' . rupiah(max(0, $ai_sisa / max(1, ceil((new DateTime())->diff($ai_deadline)->days / 30)))) . ' per bulan agar lebih dekat dengan deadline.';
            }
        } else {
            $ai_status = 'berjalan';
            $ai_status_text = 'Target sedang berjalan.';
            $ai_saran = 'Dengan rata-rata saat ini, target diperkirakan tercapai sekitar ' . $ai_prediksi->format('d M Y') . '.';
        }
    } else {
        $ai_status = 'perlu_menabung';
        $ai_status_text = 'Belum cukup data untuk memprediksi target.';
        $ai_saran = 'Tambahkan pemasukan tabungan secara rutin agar AI dapat menghitung pola menabung Anda.';
    }
}
?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once dirname(__FILE__) . "/../../../inc/upgrade_kas_sosial.php";
$default_username_ks = isset($_SESSION['ses_username']) ? $_SESSION['ses_username'] : '';
?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><i class="fa fa-edit"></i> Tambah Pengeluaran</h3></div>
  <form action="" method="post">
    <div class="card-body">
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="username_ks" value="<?php echo htmlspecialchars($default_username_ks); ?>" placeholder="Username / nama pengguna" maxlength="50" required>
          <small class="form-text text-muted">Username ini akan tercatat khusus di Kas Sosial.</small>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Uraian</label>
        <div class="col-sm-8"><input type="text" class="form-control" name="uraian_ks" placeholder="Uraian Pengeluaran" maxlength="200" required></div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Pengeluaran (Rp.)</label>
        <div class="col-sm-4"><input type="text" class="form-control" id="keluar" name="keluar" placeholder="Jumlah Pengeluaran" required></div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tanggal</label>
        <div class="col-sm-4"><input type="date" class="form-control" name="tgl_ks" value="<?php echo date('Y-m-d'); ?>" required></div>
      </div>
    </div>
    <div class="card-footer"><input type="submit" name="Simpan" value="Simpan" class="btn btn-info"><a href="?page=o_data_ks" class="btn btn-secondary ml-1">Batal</a></div>
  </form>
</div>
<?php
if (isset($_POST['Simpan'])) {
    $username=trim($_POST['username_ks'] ?? '');
    $uraian=trim($_POST['uraian_ks'] ?? '');
    $nominal=preg_replace('/[^0-9]/','',$_POST['keluar'] ?? '');
    if ($username !== '' && $uraian !== '' && $nominal !== '') {
        $stmt=$koneksi->prepare("INSERT INTO kas_sosial (tgl_ks,uraian_ks,masuk,keluar,jenis,username_ks) VALUES (?, ?, ?, ?, 'Keluar', ?)");
        $masuk = 0;
        $keluar = $nominal;
        $stmt->bind_param("ssiis", $_POST['tgl_ks'], $uraian, $masuk, $keluar, $username);
        $ok=$stmt->execute(); $stmt->close();
        if($ok) echo "<script>Swal.fire({title:'Tambah Data Berhasil',icon:'success',confirmButtonText:'OK'}).then(()=>{window.location='index.php?page=o_data_ks';});</script>";
        else echo "<script>Swal.fire({title:'Tambah Data Gagal',icon:'error'});</script>";
    } else echo "<script>Swal.fire({title:'Data belum lengkap',icon:'warning'});</script>";
}
?>
<script>
(function(){
 var el=document.getElementById('keluar');
 if(!el) return;
 el.addEventListener('keyup',function(){
   var angka=this.value.replace(/[^0-9]/g,'');
   this.value=angka ? 'Rp '+angka.replace(/\B(?=(\d{3})+(?!\d))/g,'.') : '';
 });
})();
</script>

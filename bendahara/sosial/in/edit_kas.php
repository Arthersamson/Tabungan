<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once dirname(__FILE__) . "/../../../inc/upgrade_kas_sosial.php";
$data_cek=array('id_ks'=>0,'username_ks'=>'','uraian_ks'=>'','masuk'=>0,'tgl_ks'=>'');
if(isset($_GET['kode'])) {
 $id=(int)$_GET['kode']; $stmt=$koneksi->prepare("SELECT * FROM kas_sosial WHERE id_ks=?"); $stmt->bind_param("i",$id); $stmt->execute();
 $res=$stmt->get_result(); if($res && $res->num_rows) $data_cek=$res->fetch_assoc(); $stmt->close();
}
?>
<div class="card card-success">
 <div class="card-header"><h3 class="card-title"><i class="fa fa-edit"></i> Ubah Pemasukan</h3></div>
 <form action="" method="post"><div class="card-body">
  <input type="hidden" name="id_ks" value="<?php echo (int)$data_cek['id_ks']; ?>">
  <div class="form-group row"><label class="col-sm-2 col-form-label">Username</label><div class="col-sm-8"><input type="text" class="form-control" name="username_ks" value="<?php echo htmlspecialchars($data_cek['username_ks']); ?>" maxlength="50" required></div></div>
  <div class="form-group row"><label class="col-sm-2 col-form-label">Uraian</label><div class="col-sm-8"><input type="text" class="form-control" name="uraian_ks" value="<?php echo htmlspecialchars($data_cek['uraian_ks']); ?>" maxlength="200" required></div></div>
  <div class="form-group row"><label class="col-sm-2 col-form-label">Pemasukan</label><div class="col-sm-4"><input type="text" class="form-control" id="masuk" name="masuk" value="<?php echo htmlspecialchars($data_cek['masuk']); ?>" required></div></div>
  <div class="form-group row"><label class="col-sm-2 col-form-label">Tanggal</label><div class="col-sm-4"><input type="date" class="form-control" name="tgl_ks" value="<?php echo htmlspecialchars($data_cek['tgl_ks']); ?>" required></div></div>
 </div><div class="card-footer"><input type="submit" name="Ubah" value="Simpan" class="btn btn-success"><a href="?page=i_data_ks" class="btn btn-secondary ml-1">Batal</a></div></form>
</div>
<?php
if(isset($_POST['Ubah'])) {
 $id=(int)$_POST['id_ks']; $username=trim($_POST['username_ks']??''); $uraian=trim($_POST['uraian_ks']??''); $nominal=(int)preg_replace('/[^0-9]/','',$_POST['masuk']??'');
 $stmt=$koneksi->prepare("UPDATE kas_sosial SET username_ks=?,uraian_ks=?,masuk=?,tgl_ks=? WHERE id_ks=?");
 $stmt->bind_param("ssisi",$username,$uraian,$nominal,$_POST['tgl_ks'],$id); $ok=$stmt->execute(); $stmt->close();
 echo $ok ? "<script>Swal.fire({title:'Ubah Data Berhasil',icon:'success'}).then(()=>{window.location='index.php?page=i_data_ks';});</script>" : "<script>Swal.fire({title:'Ubah Data Gagal',icon:'error'});</script>";
}
?>

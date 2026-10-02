<?php
  $data_nama = $_SESSION["ses_nama"];
  $data_level = $_SESSION["ses_level"];
  include "inc/ai_tabungan.php";

  $sql = $koneksi->query("SELECT COUNT(id_pengguna) as pengguna from tb_pengguna");
    while ($data= $sql->fetch_assoc()) {
      $jml=$data['pengguna'];
  }
?>

<?php
  $sql = $koneksi->query("SELECT SUM(masuk) as tot_masuk  from kas_anda where jenis='Masuk'");
  while ($data= $sql->fetch_assoc()) {
    $masuk=$data['tot_masuk'];
  }

  $sql = $koneksi->query("SELECT SUM(keluar) as tot_keluar  from kas_anda where jenis='Keluar'");
  while ($data= $sql->fetch_assoc()) {
    $keluar=$data['tot_keluar'];
  }

  $saldo= $masuk-$keluar;
?>

<?php
  $sql = $koneksi->query("SELECT SUM(masuk) as tot_masuk  from kas_sosial where jenis='Masuk'");
  while ($data= $sql->fetch_assoc()) {
    $smasuk=$data['tot_masuk'];
  }

  $sql = $koneksi->query("SELECT SUM(keluar) as tot_keluar  from kas_sosial where jenis='Keluar'");
  while ($data= $sql->fetch_assoc()) {
    $skeluar=$data['tot_keluar'];
  }

  $ssaldo= $smasuk-$skeluar;
?>


<div class="row">
	<div class="col-lg-4 col-6">
		<!-- small box -->
		<div class="small-box bg-info">
			<div class="inner">
				<h5>
					<?php echo rupiah($saldo); ?>
				</h5>

				<p>Saldo Kas Anda</p>
			</div>
			<div class="icon">
				<i class="ion ion-stats-bars"></i>
			</div>
			<a href="?page=rekap_km" class="small-box-footer">Selengkapnya
				<i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-4 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h5>
					<?php echo rupiah($ssaldo); ?>
				</h5>

				<p>Saldo Kas Sosial</p>
			</div>
			<div class="icon">
				<i class="ion ion-stats-bars"></i>
			</div>
			<a href="?page=rekap_ks" class="small-box-footer">Selengkapnya
				<i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-4 col-6">
		<!-- small box -->
		<div class="small-box bg-warning">
			<div class="inner">
				<h5>
					<?php echo $jml; ?>
				</h5>

				<p>Pengguna Sistem</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="#" class="small-box-footer">Selengkapnya
				<i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
<?php if (isset($ai_target)) { ?>
<div class="card card-primary mt-3">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-robot"></i> AI Target Tabungan</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <h5 class="mb-1"><?php echo htmlspecialchars($ai_target['nama_target']); ?></h5>
        <p class="text-muted mb-2">Target: <strong><?php echo rupiah($ai_target['target_nominal']); ?></strong>
        <?php if (!empty($ai_target['target_tanggal'])) { ?> · Deadline: <strong><?php echo date("d/m/Y", strtotime($ai_target['target_tanggal'])); ?></strong><?php } ?></p>
        <div class="progress mb-2" style="height:22px">
          <div class="progress-bar" role="progressbar" style="width: <?php echo round($ai_progress,1); ?>%">
            <?php echo round($ai_progress,1); ?>%
          </div>
        </div>
        <small>Saldo saat ini: <?php echo rupiah($ai_saldo); ?> · Sisa: <?php echo rupiah($ai_sisa); ?></small>
      </div>
      <div class="col-md-4 mt-3 mt-md-0">
        <div class="alert <?php echo $ai_status==='tercapai' ? 'alert-success' : ($ai_status==='berisiko' ? 'alert-warning' : 'alert-info'); ?> mb-0">
          <strong><?php echo $ai_status_text; ?></strong>
          <p class="mb-0 mt-2"><?php echo $ai_saran; ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <a href="?page=rekap_km" class="btn btn-primary btn-sm"><i class="fas fa-bullseye"></i> Kelola Target</a>
  </div>
</div>
<?php } ?>

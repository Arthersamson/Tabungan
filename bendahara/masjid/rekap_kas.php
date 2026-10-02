<?php include "inc/ai_tabungan.php";?>
<?php
  $sql = $koneksi->query("SELECT SUM(masuk) as tot_masuk  from kas_anda where jenis='Masuk'");
  while ($data= $sql->fetch_assoc()) {
    $masuk=$data['tot_masuk'];
  }
?>

<?php
  $sql = $koneksi->query("SELECT SUM(keluar) as tot_keluar  from kas_anda where jenis='Keluar'");
  while ($data= $sql->fetch_assoc()) {
    $keluar=$data['tot_keluar'];
  }
?>


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-bullseye"></i> Target Tabungan + AI</h3>
  </div>
  <form method="post">
    <div class="card-body">
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Nama Target</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" name="nama_target" value="<?php echo $ai_target ? htmlspecialchars($ai_target['nama_target']) : 'Target Tabungan'; ?>" placeholder="Contoh: Beli Laptop" required>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Nominal Target</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" id="target_nominal" name="target_nominal" value="<?php echo $ai_target ? rupiah($ai_target['target_nominal']) : ''; ?>" placeholder="Contoh: Rp 5.000.000" required>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Deadline (opsional)</label>
        <div class="col-sm-5">
          <input type="date" class="form-control" name="target_tanggal" value="<?php echo ($ai_target && !empty($ai_target['target_tanggal'])) ? $ai_target['target_tanggal'] : ''; ?>">
        </div>
      </div>

      <?php if ($ai_target) { ?>
      <hr>
      <div class="row">
        <div class="col-md-3">
          <div class="small-box bg-info mb-2">
            <div class="inner"><h4><?php echo round($ai_progress,1); ?>%</h4><p>Progress</p></div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="small-box bg-warning mb-2">
            <div class="inner"><h4><?php echo rupiah($ai_sisa); ?></h4><p>Sisa Target</p></div>
            <div class="icon"><i class="fas fa-coins"></i></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="small-box bg-success mb-2">
            <div class="inner"><h4><?php echo rupiah($ai_avg_bulanan); ?></h4><p>Rata-rata / Bulan</p></div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="small-box bg-primary mb-2">
            <div class="inner">
              <h4><?php echo $ai_prediksi ? $ai_prediksi->format('d/m/Y') : '-'; ?></h4>
              <p>Perkiraan Tercapai</p>
            </div>
            <div class="icon"><i class="fas fa-flag-checkered"></i></div>
          </div>
        </div>
      </div>

      <div class="alert <?php echo $ai_status==='tercapai' ? 'alert-success' : ($ai_status==='berisiko' ? 'alert-warning' : 'alert-info'); ?>">
        <h5><i class="fas fa-robot"></i> Analisis AI</h5>
        <strong><?php echo $ai_status_text; ?></strong>
        <div class="mt-1"><?php echo $ai_saran; ?></div>
        <?php if (!empty($ai_target['target_tanggal']) && $ai_status !== 'tercapai') { ?>
          <small class="d-block mt-2">AI menggunakan riwayat transaksi untuk memperkirakan kecepatan menabung. Hasil adalah estimasi, bukan jaminan.</small>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
    <div class="card-footer">
      <button type="submit" name="simpan_target_tabungan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Target</button>
    </div>
  </form>
</div>

<script>
(function(){
  var el=document.getElementById('target_nominal');
  if(!el) return;
  el.addEventListener('keyup',function(){
    var angka=this.value.replace(/[^0-9]/g,'');
    if(angka) this.value='Rp '+angka.replace(/\B(?=(\d{3})+(?!\d))/g,'.');
  });
})();
</script>

<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h5>
		<i class="icon fas fa-info"></i> Saldo Tabungan Anda</h5>
	<h5>Pemasukan :
		<?php
  echo rupiah($masuk);
  ?>
	</h5>

	<h5>Pengeluaran :
		<?php
    echo rupiah($keluar);
    ?>
	</h5>
	<hr>

	<h3>Saldo Akhir :
		<?php
    $saldo= $masuk-$keluar;
    echo rupiah($saldo);
    ?>
	</h3>
</div>

<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-table"></i> Rekap Tabungan Anda</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<div class="table-responsive">
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Uraian</th>
						<th>Pemasukan</th>
						<th>Pengeluaran</th>
					</tr>
				</thead>
				<tbody>

					<?php
              $no = 1;
              $sql = $koneksi->query("select * from kas_anda order by tgl_km asc");
              while ($data= $sql->fetch_assoc()) {
            ?>

					<tr>
						<td>
							<?php echo $no++; ?>
						</td>
						<td>
							<?php  $tgl = $data['tgl_km']; echo date("d/M/Y", strtotime($tgl))?>
						</td>
						<td>
							<?php echo $data['uraian_km']; ?>
						</td>
						<td align="right">
							<?php echo rupiah($data['masuk']); ?>
						</td>
						<td align="right">
							<?php echo rupiah($data['keluar']); ?>
						</td>
					</tr>

					<?php
              }
            ?>
				</tbody>
				</tfoot>
			</table>
		</div>
	</div>
	<!-- /.card-body -->
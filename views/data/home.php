<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Beranda </h1>
        <a href="<?=$base_url;?>?#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-sync-alt fa-sm text-white-50"></i> Refresh</a>
    </div>

    <?php if(isset($_SESSION['msg'])):?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Informasi</strong> <?= $_SESSION['msg']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; unset($_SESSION['msg']);?>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Pencarian Data Pelanggan</div>
                <div class="card-body">
                    <form action="<?=$base_url;?>?" method="get">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Masukkan nomor meter"
                                        name="keyword" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari
                                    Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php 
        if(isset($_GET['keyword'])):
            $key = $_GET['keyword'];
            $query = mysqli_query($con,"SELECT pelanggan.*,tagihan.jml_bayar,tagihan.tgl_bayar as tgl_sudah_bayar, MONTH(pelanggan.tgl_bayar) as bln, MONTH(tagihan.tgl_bayar) as bln_bayar FROM pelanggan JOIN tagihan ON pelanggan.id_pelanggan=tagihan.id_pelanggan WHERE no_meter LIKE '%$key%' ORDER BY tagihan.tgl_bayar DESC") or die(mysqli_error($con));
            $row = mysqli_fetch_array($query);
        ?>
        <div class="col-md-12">
            <?php if(isset($_GET['cetak'])): 
                    // $key = $_GET['keyword'];
                    // $query2 = mysqli_query($con,"SELECT pelanggan.*,tagihan.tgl_bayar as tgl_sudah_bayar, MONTH(tagihan.tgl_bayar) as bln_bayar FROM pelanggan JOIN tagihan ON pelanggan.id_pelanggan=tagihan.id_pelanggan WHERE no_meter LIKE '%$key%' ORDER BY tagihan.tgl_bayar DESC") or die(mysqli_error($con));
                    // $row2 = mysqli_fetch_array($query2);?>
            <div class="card border-left-primary shadow mb-4">
                <div class="card-body">
                    <h4>Berhasil</h4>
                    <h5>Pembayaran untuk <b><?= bulan($row['bln_bayar']); ?></b> telah berhasil dilakukan. Silah
                        klik tombol <b>Cetak Bukti</b> untuk mencetak bukti pembayaran.
                    </h5>
                    <br>
                    <a href="<?=$base_url;?>process/cetak.php?no_meter=<?=$_GET['keyword'];?>" target="_blank"
                        class="btn btn-primary"><i class="fas fa-print"></i> Cetak Bukti</a>
                </div>
            </div>
            <?php else: ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Nomor Meter <b><?=$_GET['keyword'];?></b></h6>
                </div>
                <div class="card-body">
                    <div class="card border-left-info shadow mb-4" style="color:red;">
                        <div class="card-body">
                            <h4>Informasi</h4>
                            <h5>Anda belum melakukan pembayaran untuk bulan : <b><?= bulan($row['bln']); ?></b></h5>
                        </div>
                    </div>
                    <form action="<?=$base_url;?>process/tagihan.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pelanggan</label>
                                    <input type="hidden" name="id" value="<?= $row['id_pelanggan']; ?>">
                                    <input type="text" class="form-control" value="<?= $row['nama']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nomor HP</label>
                                    <input type="text" class="form-control" value="<?= $row['no_hp']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="<?= $row['alamat']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Meter</label>
                                    <input type="text" class="form-control" name="no_meter"
                                        value="<?= $row['no_meter']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Daya</label>
                                    <input type="text" class="form-control" value="<?= $row['daya']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Harus Bayar</label>
                                    <input type="text" class="form-control" name="tgl_bayar"
                                        value="<?= $row['tgl_bayar']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Bayar</label>
                                    <input type="text" class="form-control uang" name="jml_bayar" required>
                                </div>
                                <br>
                                <button class="btn btn-success float-right" type="submit" name="bayar"><i
                                        class="fas fa-money-bill"></i> Bayar
                                    Sekarang</button>
                                <!-- <button class="btn btn-success float-left">Print</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

</div>
<!-- /.container-fluid -->
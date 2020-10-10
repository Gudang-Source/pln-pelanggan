<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <?php if(isset($_GET['tagihan'])): ?>
        <h1 class="h3 mb-0 text-gray-800">Tagihan</h1>
        <?php else: ?>
        <h1 class="h3 mb-0 text-gray-800">Detail Tagihan</h1>
        <?php endif; ?>
    </div>
    <!-- DataTales Example -->
    <?php if(isset($_GET['tagihan'])): ?>
    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
        </div> -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>NAMA LENGKAP</th>
                            <th>NO METER</th>
                            <th>TOTAL BAYAR</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT tagihan.*,pelanggan.nama,pelanggan.no_meter,sum(tagihan.jml_bayar) as total_bayar FROM tagihan JOIN pelanggan ON tagihan.id_pelanggan=pelanggan.id_pelanggan GROUP BY tagihan.id_pelanggan")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['no_meter']; ?></td>
                            <td><?= 'Rp. '.number_format($row['total_bayar'],0,"","."); ?></td>
                            <td>
                                <a href="<?=$base_url;?>?detail_tagihan&id=<?=encrypt($row['id_pelanggan']);?>&tahun=<?=date('Y');?>"
                                    class="btn btn-sm btn-circle btn-primary"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if(isset($_GET['detail_tagihan'])): ?>
    <div class="card shadow mb-4">
        <div class="py-3" style="padding:15px;">
            <form action="<?=$base_url;?>process/tagihan.php?act=<?=encrypt('tahun');?>" method="post">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?=decrypt($_GET['id']);?>">
                            <select name="tahun" class="form-control form-control-sm">
                                <?php foreach(tahun() as $thn): ?>
                                <option value="<?= $thn; ?>" <?=$_GET['tahun']==$thn?'selected':''; ?>><?= $thn; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary" name="tampilkan"><i class="fas fa-eye"></i>
                            Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>NAMA LENGKAP</th>
                            <th>NO METER</th>
                            <th>JUMLAH BAYAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $id = decrypt($_GET['id']);
                        $tahun = $_GET['tahun'];
                        $query = mysqli_query($con,"SELECT tagihan.*,pelanggan.nama,pelanggan.no_meter FROM tagihan JOIN pelanggan ON tagihan.id_pelanggan=pelanggan.id_pelanggan WHERE tagihan.id_pelanggan='$id' AND tagihan.tgl_bayar LIKE '%$tahun%'")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['no_meter']; ?></td>
                            <td><?= 'Rp. '.number_format($row['jml_bayar'],0,"","."); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
<!-- /.container-fluid -->
<?php hakAkses(['admin']) ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('[name="no_meter"]').val("");
        $('[name="nama"]').val("");
        $('[name="no_hp"]').val("");
        $('[name="daya"]').val("");
        $('[name="alamat"]').val("");
        $('#penggunaModal .modal-title').html('Tambah Pelanggan');
        $('[name="no_meter"]').prop('readonly', false);
        $('[name="password"]').prop('required', true);
        $('#passwordHelp').hide();
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#penggunaModal .modal-title').html('Edit Pelenggan');
        $('[name="no_meter"]').prop('readonly', true);
        $('[name="tgl_bayar"]').prop('readonly', true);
        $('[name="password"]').prop('required', false);
        $('#passwordHelp').show();
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=$base_url;?>process/view_pelanggan.php',
            dataType: 'json',
            success: function(data) {
                $('[name="id"]').val(data.id_pelanggan);
                $('[name="no_meter"]').val(data.no_meter);
                $('[name="nama"]').val(data.nama);
                $('[name="no_hp"]').val(data.no_hp);
                $('[name="daya"]').val(data.daya);
                $('[name="tgl_bayar"]').val(data.tgl_bayar);
                $('[name="alamat"]').val(data.alamat);
            }
        });
    }
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pelanggan</h1>
    </div>
    <?php if(isset($_SESSION['msg'])):?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Informasi</strong> <?= $_SESSION['msg']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; unset($_SESSION['msg']);?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#penggunaModal"
                onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>NAMA LENGKAP</th>
                            <th>TELP</th>
                            <th>NO METER</th>
                            <th>DAYA</th>
                            <th>TGL BAYAR</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM pelanggan ORDER BY id_pelanggan DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['no_hp']; ?></td>
                            <td><?= $row['no_meter']; ?></td>
                            <td><?= $row['daya']; ?></td>
                            <td><?= $row['tgl_bayar']; ?></td>
                            <td>
                                <a href="#penggunaModal" data-toggle="modal"
                                    onclick="submit(<?=$row['id_pelanggan'];?>)"
                                    class="btn btn-sm btn-circle btn-info"><i class="fas fa-edit"></i></a>
                                <a href="<?=$base_url;?>/process/pelanggan.php?act=<?=encrypt('delete');?>&id=<?=encrypt($row['id_pelanggan']);?>"
                                    class="btn btn-sm btn-circle btn-danger"
                                    onclick="return confirm('Anda yakin ingin menghapus data ini ?')"><i
                                        class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="penggunaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?=$base_url;?>process/pelanggan.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="hidden" name="id" class="form-control">
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="text" class="form-control" name="no_hp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Meter</label>
                                <input type="text" class="form-control" name="no_meter" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Daya</label>
                                <input type="text" class="form-control uang" name="daya" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Bayar</label>
                                <input type="date" class="form-control" name="tgl_bayar" date-format="yyyy-mm-dd"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat" cols="30" rows="3" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                    <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                        Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
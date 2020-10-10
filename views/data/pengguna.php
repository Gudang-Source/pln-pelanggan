<?php hakAkses(['admin']) ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('[name="username"]').val("");
        $('[name="nama"]').val("");
        $('[name="no_hp"]').val("");
        $('[name="level"]').val("");
        $('#penggunaModal .modal-title').html('Tambah Pengguna');
        $('[name="username"]').prop('readonly', false);
        $('[name="password"]').prop('required', true);
        $('#passwordHelp').hide();
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#penggunaModal .modal-title').html('Edit Pengguna');
        $('[name="username"]').prop('readonly', true);
        $('[name="password"]').prop('required', false);
        $('#passwordHelp').show();
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=$base_url;?>process/view_user.php',
            dataType: 'json',
            success: function(data) {
                $('[name="id"]').val(data.id_users);
                $('[name="username"]').val(data.username);
                $('[name="nama"]').val(data.nama);
                $('[name="no_hp"]').val(data.no_hp);
                $('[name="level"]').val(data.level);
            }
        });
    }
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
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
                            <th>USERNAME</th>
                            <th>LEVEL</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM users ORDER BY id_users DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['no_hp']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['level']; ?></td>
                            <td>
                                <a href="#penggunaModal" data-toggle="modal" onclick="submit(<?=$row['id_users'];?>)"
                                    class="btn btn-sm btn-circle btn-info"><i class="fas fa-edit"></i></a>
                                <a href="<?=$base_url;?>/process/users.php?act=<?=encrypt('delete');?>&id=<?=encrypt($row['id_users']);?>"
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
            <form action="<?=$base_url;?>process/users.php" method="post">
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
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password"
                                    aria-describedby="passwordHelp">
                                <small id="passwordHelp" class="form-text" style="color:red;">Biarkan kosong
                                    jika tidak ingin
                                    merubah password</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Level Akses</label>
                                <select name="level" class="form-control" required>
                                    <option value="user">Staff Pegawai</option>
                                    <option value="admin">Administrator</option>
                                </select>
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
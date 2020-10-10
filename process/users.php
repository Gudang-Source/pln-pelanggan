<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $level = $_POST['level'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $cek = mysqli_query($con,"SELECT * FROM users WHERE username='$username'") or die(mysqli_error($con));
    if(mysqli_num_rows($cek)==0){
        $insert = mysqli_query($con,"INSERT INTO users (id_users, nama, no_hp, username, password, level) VALUES ('','$nama','$no_hp','$username','$password','$level')") or die (mysqli_error($con));
        if($insert){
            $msg = 'Berhasil menambahkan data users';
        }else{
            $msg = 'Gagal menambahkan data users';
        }
    }else{
        $msg = 'Username telah terdaftar !';
    }
    $_SESSION['msg'] = $msg;
    header('Location:../?pengguna');
}
if(isset($_POST['ubah'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    if($password!=""){
        $update = mysqli_query($con,"UPDATE users SET nama='$nama', no_hp='$no_hp', password='".password_hash($password,PASSWORD_DEFAULT)."', level='$level' WHERE id_users='$id'") or die (mysqli_error($con));
    }else{
        $update = mysqli_query($con,"UPDATE users SET nama='$nama', no_hp='$no_hp', level='$level' WHERE id_users='$id'") or die (mysqli_error($con));
    }
    if($update){
        $msg = 'Berhasil mengubah data users';
    }else{
        $msg = 'Gagal mengubah data users';
    }
    $_SESSION['msg'] = $msg;
    header('Location:../?pengguna');
}

if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM users WHERE id_users='$id'")or die(mysqli_error($con));
    if ($query) {
        $msg = "Data users berhasil dihapus";
    }else{
        $msg = "Data users gagal dihapus";
    }
    $_SESSION['msg'] = $msg;
    header('Location:../?pengguna');
}

if(decrypt($_GET['act'])=='ganti_pass' && isset($_POST['ubah_pass'])){
    $id = $_POST['id'];
    $password =password_hash($_POST['password'],PASSWORD_DEFAULT);

    $update = mysqli_query($con,"UPDATE users SET password='$password' WHERE id_users='$id'") or die (mysqli_error($con));
    echo '<script>window.history.back();</script>';
}

?>
<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $no_meter = $_POST['no_meter'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $daya = $_POST['daya'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $alamat = $_POST['alamat'];

    $cek = mysqli_query($con,"SELECT * FROM pelanggan WHERE no_meter='$no_meter'") or die(mysqli_error($con));
    if(mysqli_num_rows($cek)==0){
        $insert = mysqli_query($con,"INSERT INTO pelanggan (id_pelanggan, nama, no_hp, alamat, no_meter, daya, tgl_bayar) VALUES ('','$nama','$no_hp','$alamat','$no_meter','$daya','$tgl_bayar')") or die (mysqli_error($con));
        if($insert){
            $msg = 'Berhasil menambahkan data pelanggan';
        }else{
            $msg = 'Gagal menambahkan data pelanggan';
        }
    }else{
        $msg = 'Nomor meter telah terdaftar !';
    }
    $_SESSION['msg'] = $msg;
    header('Location:../?pelanggan');
}

if(isset($_POST['ubah'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $daya = $_POST['daya'];

    $update = mysqli_query($con,"UPDATE pelanggan SET nama='$nama', no_hp='$no_hp', alamat='$alamat', daya='$daya' WHERE id_pelanggan='$id'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $msg = 'Berhasil mengubah data pelanggan';
    }else{
        $msg = 'Gagal mengubah data pelanggan';
    }
    $_SESSION['msg'] = $msg;
    header('Location:../?pelanggan');
}

if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    // echo $_GET['act'];die;
    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM pelanggan WHERE id_pelanggan='$id'")or die(mysqli_error($con));
    if ($query) {
        $msg = "Data pelanggan berhasil dihapus";
    }else{
        $msg = "Data pelanggan gagal dihapus";
    }
    $_SESSION['msg'] = $msg;
    header('Location:../?pelanggan');
}
?>
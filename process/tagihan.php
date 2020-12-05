<?php 
session_start();
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['bayar'])){
    $id = $_POST['id'];
    $no_meter = $_POST['no_meter'];
    $jml_bayar = delMask($_POST['jml_bayar']);
    // $tgl_bayar = date('Y-m-d');
    $tgl_bayar = $_POST['tgl_bayar'];
    // $tgl_bayar_berikut = date('Y-m-d',time()+60*60*24*30);
    $tgl_bayar_berikut = date('Y-m-d',strtotime($tgl_bayar)+60*60*24*30);
    
    $insert = mysqli_query($con,"INSERT INTO tagihan (id_pelanggan, jml_bayar, tgl_bayar) VALUES ('$id','$jml_bayar','$tgl_bayar')") or die (mysqli_error($con));
    if($insert){
        $update = mysqli_query($con,"UPDATE pelanggan SET tgl_bayar='$tgl_bayar_berikut' WHERE id_pelanggan='$id'") or die (mysqli_error($con));
    }
    $_SESSION['msg'] = $msg;
    header('Location:../?keyword='.$no_meter.'&cetak');
}

if(decrypt($_GET['act'])=='tahun' && isset($_POST['tampilkan'])){
    header('Location:../?detail_tagihan&id='.encrypt($_POST['id']).'&tahun='.$_POST['tahun'].'');
}
?>
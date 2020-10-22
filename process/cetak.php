<?php
// session_start();
include ('../config/conn.php');
include ('../config/function.php');
?>
<html>

<head>
    <style type="tetx/css">
        h2{ 
            padding:0px;
            margin:0px;
        }
        text{
            padding:0px;
        }
        table{
            font-size:12pt;
        }
    </style>
    <title>Cetak Bukti Pembayaran</title>
</head>

<body>
    <?php
    $no_meter = $_GET['no_meter'];
    $query = mysqli_query($con,"SELECT pelanggan.*,tagihan.jml_bayar,tagihan.tgl_bayar as tgl_sudah_bayar,MONTH(pelanggan.tgl_bayar) as bulan FROM pelanggan JOIN tagihan ON pelanggan.id_pelanggan=tagihan.id_pelanggan WHERE MONTH(tagihan.tgl_bayar)=MONTH(pelanggan.tgl_bayar)-1 AND pelanggan.no_meter='$no_meter'")or die(mysqli_error($con));
    $row = mysqli_fetch_array($query)
    ?>
    <div style="page-break-after:always;">
        <hr>
        <h2>BUKTI PEMBAYARAN</h2>
        <p style="text-align:right;width:95%;margin-top:-35px">Tanggal : <?= date('d/m/Y');?></p>
        <hr style="border-color:black;">
        <table>
            <tr>
                <td>Bulan</td>
                <td>:</td>
                <td><b><?= strtoupper(bulan($row['bulan'])); ?></b></td>
            </tr>
            <tr>
                <td>Nama Pelanggan</td>
                <td>:</td>
                <td width="200"><?= $row['nama']; ?></td>
                <td>Nomor Meter</td>
                <td>:</td>
                <td><?= $row['no_meter']; ?></td>
            </tr>
            <tr>
                <td>Nomor HP</td>
                <td>:</td>
                <td><?= $row['no_hp']; ?></td>
                <td>Daya</td>
                <td>:</td>
                <td><?= $row['daya'].' VA'; ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $row['alamat']; ?></td>
                <td>Jumlah Bayar</td>
                <td>:</td>
                <td><b><?= 'Rp. '.number_format($row['jml_bayar'],0,"","."); ?></b></td>
            </tr>
            <tr>
                <td>Tanggal Bayar</td>
                <td>:</td>
                <td><?= $row['tgl_sudah_bayar']; ?></td>
            </tr>
            <tr>
                <td>Tanggal Bayar Berikutnya</td>
                <td>:</td>
                <td><?= $row['tgl_bayar']; ?></td>
                <td style="font-size:16pt;"><b>L U N A S</b></td>
            </tr>
        </table>
        <hr style="border-color:gray;">
    </div>
</body>

</html>

<script>
window.print();
</script>
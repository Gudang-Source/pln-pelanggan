<?php
    if(isset($_GET['backup_app'])){
        include ('proses/backup_app.php');
    }
    else if(isset($_GET['backup_db'])){
        include ('proses/backup_db.php');
    }
    else if(isset($_GET['pelanggan'])){
        $pelanggan = true;
        $views = 'views/data/pelanggan.php';
    }
    else if(isset($_GET['tagihan'])){
        $tagihan = true;
        $views = 'views/data/tagihan.php';
    }
    else if(isset($_GET['pengguna'])){
        $pengguna = true;
        $views = 'views/data/pengguna.php';
    }
    else if(isset($_GET['detail_tagihan'])){
        $tagihan = true;
        $views = 'views/data/tagihan.php';
    }
    else{
        $home = true;
        $views = 'views/data/home.php';
    }
?>
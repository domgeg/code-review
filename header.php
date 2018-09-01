<?php
    include("baza.php");
    if(session_id()=="")session_start();

    $trenutna=basename($_SERVER["PHP_SELF"]);
    $aktivni_korisnik=0;
    $aktivni_korisnik_tip=-1;
    $vel_str=5;
    $vel_str_video=20;

    if(isset($_SESSION['aktivni_korisnik'])){
        $aktivni_korisnik=$_SESSION['aktivni_korisnik'];
        $aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
        $aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
        $aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>IWA Projekt</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/iwa.css">
        <script type="text/javascript" src="js/validacija_forme.js"></script>
    </head>
    <body>
        <nav id="navigacija" class="menu">
            <ul>
                <li><a href='index.php' class="<?php if($trenutna=="index.php")echo 'aktivna'; ?>">Početna</a></li>
                <li><a href='o_autoru.html' class="<?php if($trenutna=="o_autoru.html")echo 'aktivna'; ?>">O autoru</a></li>
                <li><a href='zavodi.php' class="<?php if($trenutna=="zavodi.php")echo 'aktivna'; ?>">Zavodi</a></li>
                <?php if ($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0): ?>
                    <li><a href='statistika.php' class="<?php if($trenutna=="statistika.php")echo 'aktivna'; ?>">Statistika zaposlenosti</a></li>
                <?php endif ?>
                <?php if ($aktivni_korisnik_tip==0): ?>
                    <li><a href='korisnici.php' class="<?php if($trenutna=="korisnici.php")echo 'aktivna'; ?>">Korisnici</a></li>
                    <li><a href='natjecaji.php' class="<?php if($trenutna=="natjecaji.php")echo 'aktivna'; ?>">Natječaji</a></li>
                <?php endif ?>
                <?php if ($aktivni_korisnik===0): ?>
                    <li><a href='login.php' class="<?php if($trenutna=="login.php")echo 'aktivna'; ?>">Prijava</a></li>
                <?php else: ?>
                    <li><a href='login.php?logout=true'>Odjavi se kao <?php echo $aktivni_korisnik; ?> </a></li>
                <?php endif ?>
            </ul>
        </nav>

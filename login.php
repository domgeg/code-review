<?php
    ob_start();
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if(isset($_GET['logout'])){
        unset($_SESSION["aktivni_korisnik"]);
        unset($_SESSION['aktivni_korisnik_ime']);
        unset($_SESSION["aktivni_korisnik_tip"]);
        unset($_SESSION["aktivni_korisnik_id"]);
        session_destroy();
        header("Location: index.php");
        exit();
    }
    $greska= "";
    if(isset($_POST['submit'])){
        $kor_ime=mysqli_real_escape_string($bp,$_POST['korisnicko_ime']);
        $lozinka=mysqli_real_escape_string($bp,$_POST['lozinka']);

        if(!empty($kor_ime)&&!empty($lozinka)){
            $sql="SELECT korisnik_id,tip_id,ime,prezime FROM korisnik WHERE korisnicko_ime='$kor_ime' AND lozinka='$lozinka'";
            $rs=izvrsiUpit($bp,$sql);
            if(mysqli_num_rows($rs)==0){
                $greska="Ne postoji korisnik s navedenim korisničkim imenom i lozinkom";
            }else{
                list($id,$tip,$ime,$prezime)=mysqli_fetch_array($rs);
                $_SESSION['aktivni_korisnik']=$kor_ime;
                $_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
                $_SESSION["aktivni_korisnik_id"]=$id;
                $_SESSION['aktivni_korisnik_tip']=$tip;
                header("Location:index.php");
            }
        }
        else $greska = "Molim unesite korisničko ime i lozinku";
    }
?>
<form id="prijava" name="prijava" method="POST" action="login.php"">
    <table>
        <caption>Prijava u sustav</caption>
        <tbody>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <label class="greska"><?php if($greska!="")echo $greska; ?></label>
                </td>
            </tr>
            <tr>
                <td class="lijevi">
                    <label for="korisnicko_ime"><strong>Korisničko ime:</strong></label>
                </td>
                <td>
                    <input name="korisnicko_ime" id="korisnicko_ime" type="text" size="120"/>
                </td>
            </tr>
            <tr>
                <td class="lijevi">
                    <label for="lozinka"><strong>Lozinka:</strong></label>
                </td>
                <td>
                    <input name="lozinka"   id="lozinka" type="password" size="120"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <input name="submit" type="submit" value="Prijavi se"/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>

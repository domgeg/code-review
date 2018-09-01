<?php
    ob_start();
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if ($aktivni_korisnik_tip!=0){
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id=$_GET['korisnik'];
        $tip=$_POST['tip'];
        $kime=$_POST['korisnicko_ime'];
        $lozinka=$_POST['lozinka'];
        $ime=$_POST['ime'];
        $prezime=$_POST['prezime'];
        $email=$_POST['email'];
        $slika=$_POST['slika'];

        $sql="INSERT INTO korisnik (tip_id,korisnicko_ime,lozinka,ime,prezime,email,slika) VALUES 
            ($tip, '$kime', '$lozinka', '$ime', '$prezime', '$email', '$slika');";
        izvrsiUpit($bp,$sql);

        header("Location: korisnici.php");
        exit();
    }else{
        $sql="SELECT * FROM tip_korisnika;";
        $rstip=izvrsiUpit($bp,$sql);
    }
?>
<form method="POST" action="kreiraj-korisnika.php" id="azuriraj_korisnika" name="azuriraj_korisnika" onsubmit="return validacija();">
    <table>
        <caption>Kreiraj korisnika</caption>
        <tbody>
            <tr>
                <td><div class='error'></div></td>
            </tr>
            <tr>
                <td>
                    <label for='tip'><strong>Tip:</strong></label>
                </td>
                <td>
                    <select name="tip" id="tip">
                        <?php while (list($id,$naziv)=mysqli_fetch_array($rstip)): ?>
                            <option value="<?php echo $id; ?>">
                                <?php echo $naziv; ?>
                            </option>
                        <?php endwhile ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='korisnicko_ime'><strong>Korisnicko ime:</strong></label>
                </td>
                <td>
                    <input type='text' name='korisnicko_ime' id='korisnicko_ime' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='lozinka'><strong>Lozinka:</strong></label>
                </td>
                <td>
                    <input type='password' name='lozinka' id='lozinka' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='ime'><strong>Ime:</strong></label>
                </td>
                <td>
                    <input type='text' name='ime' id='ime' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='prezime'><strong>Prezime:</strong></label>
                </td>
                <td>
                    <input type='text' name='prezime' id='prezime' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='email'><strong>Email:</strong></label>
                </td>
                <td>
                    <input type='text' name='email' id='email' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='slika'><strong>Slika:</strong></label>
                </td>
                <td>
                    <input type='text' name='slika' id='slika' />
                </td>
            </tr>
            <tr>
                <td colspan='2' style='text-align:center;'>
                    <input name='submit' type='submit' value='Posalji'/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>
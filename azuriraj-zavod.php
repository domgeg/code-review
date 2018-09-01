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
        $id=$_GET['zavod'];
        $moderator=$_POST['moderator'];
        $naziv=$_POST['naziv'];
        $opis=$_POST['opis'];

        $sql="UPDATE zavod SET
            moderator_id=$moderator,naziv='$naziv',opis='$opis'
            WHERE zavod_id = $id;";

        izvrsiUpit($bp,$sql);

        header("Location: zavodi.php");
        exit();
    }else{
        $zid=$_GET['zavod'];
        $sql="SELECT * FROM zavod WHERE zavod_id=$zid;";
        $rszavod=izvrsiUpit($bp,$sql);
        list($id,$mid,$naziv,$opis)=mysqli_fetch_array($rszavod);

        $sql="SELECT korisnik_id, korisnicko_ime FROM korisnik WHERE tip_id=1;";
        $rskorisnici=izvrsiUpit($bp,$sql);
    }
?>
<form method="POST" action="azuriraj-zavod.php?zavod=<?php echo $id; ?>" id="azuriraj_zavod" name="azuriraj_zavod" onsubmit="return validacija();">
    <table>
        <caption>Azuriraj zavod</caption>
        <tbody>
            <tr>
                <td><div class='error'></div></td>
            </tr>
            <tr>
                <td>
                    <label for='moderator'><strong>Moderator:</strong></label>
                </td>
                <td>
                    <select name="moderator" id="moderator">
                        <?php while (list($id,$ime)=mysqli_fetch_array($rskorisnici)): ?>
                            <option value="<?php echo $id; ?>" <?php if ($id==$mid): ?>selected<?php endif ?>>
                                <?php echo $ime; ?>
                            </option>
                        <?php endwhile ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='naziv'><strong>Naziv:</strong></label>
                </td>
                <td>
                    <input type='text' name='naziv' id='naziv' value='<?php echo $naziv; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='opis'><strong>Opis:</strong></label>
                </td>
                <td>
                    <textarea name="opis" placeholder="Unesite opis..."><?php echo $opis; ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan='2' style='text-align:center;'>
                    <input name='submit' type='submit' value='Azuriraj'/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>
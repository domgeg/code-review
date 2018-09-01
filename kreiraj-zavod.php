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
        $moderator=$_POST['moderator'];
        $naziv=$_POST['naziv'];
        $opis=$_POST['opis'];

        $sql="INSERT INTO zavod (moderator_id,naziv,opis) VALUES
            ($moderator, '$naziv', '$opis');";
        izvrsiUpit($bp,$sql);

        header("Location: zavodi.php");
        exit();
    }else{
        $sql="SELECT korisnik_id, korisnicko_ime FROM korisnik WHERE tip_id=1;";
        $rskorisnici=izvrsiUpit($bp,$sql);
    }
?>
<form method="POST" action="kreiraj-zavod.php" id="kreiraj_zavod" name="kreiraj_zavod" onsubmit="return validacija();">
    <table>
        <caption>Kreiraj zavod</caption>
        <tbody>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <label class="error"></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='moderator'><strong>Moderator:</strong></label>
                </td>
                <td>
                    <select name="moderator" id="moderator">
                        <?php while (list($id,$ime)=mysqli_fetch_array($rskorisnici)): ?>
                            <option value="<?php echo $id; ?>">
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
                    <input type='text' name='naziv' id='naziv' />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='opis'><strong>Opis:</strong></label>
                </td>
                <td>
                    <textarea name="opis" id="opis" placeholder="Unesite opis..."></textarea>
                </td>
            </tr>
            <tr>
                <td colspan='2' style='text-align:center;'>
                    <input name='submit' type='submit' value='Kreiraj'/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>
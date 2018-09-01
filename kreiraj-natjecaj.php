<?php
    ob_start();
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if ($aktivni_korisnik_tip==2){
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $zid=intval($_POST['zavodi']);
        $naziv=$_POST['naziv'];
        $brm=$_POST['brm'];
        $dk=$_POST['datumkreiranja'];
        $dk=date('Y-m-d',strtotime($dk));
        $vk=$_POST['vrijemekreiranja'];
        $kz=$_POST['kratica'];
        $opis=$_POST['opis'];
        $di=date('Y-m-d',strtotime($dk.'+30days'));

        $sql="INSERT INTO natjecaj
            (zavod_id,naziv,datum_kreiranja,vrijeme_kreiranja,datum_isteka,vrijeme_isteka,broj_radnih_mjesta,kratica_zupanije,opis) VALUES
            ($zid,'$naziv','$dk','$vk','$di','$vk',$brm,'$kz','$opis');
        ";

        izvrsiUpit($bp,$sql);
        header("Location: zavodi.php");
        exit();
    }else{
        $sql="SELECT * FROM zavod WHERE moderator_id=$aktivni_korisnik_id";
        $rs=izvrsiUpit($bp,$sql);
    }
?>
<form method='POST' action='kreiraj-natjecaj.php' id='kreiraj_natjecaj' name='kreiraj_natjecaj' onsubmit='return validacija();'>
    <table>
        <caption>Dodaj natjecaj</caption>
        <tbody>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <label class="error"></label>
                </td>
            </tr>
            <tr>
                <td class='lijevi'>
                    <label for='naziv'><strong>Zavod:*</strong></label>
                </td>
                <td>
                    <select name="zavodi">
                        <?php while (list($id,$moderator,$naziv,$opis)=mysqli_fetch_array($rs)): ?>
                            <option value="<?php echo $id; ?>"><?php echo $naziv; ?></option>
                        <?php endwhile ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class='lijevi'>
                    <label for='naziv'><strong>Naziv:*</strong></label>
                </td>
                <td>
                    <input type='text' name='naziv' id='naziv'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='brm'><strong>Broj radnih mjesta:*</strong></label>
                </td>
                <td>
                    <input type='number' name='brm' id='brm'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='datumkreiranja'><strong>Datum kreiranja:*</strong></label>
                </td>
                <td>
                    <input type='text' name='datumkreiranja' id='datumkreiranja'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='vrijemekreiranja'><strong>Vrijeme kreiranja:*</strong></label>
                </td>
                <td>
                    <input type='text' name='vrijemekreiranja' id='vrijemekreiranja'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='kratica'><strong>Kratica zupanije:*</strong></label>
                </td>
                <td>
                    <input type='text' name='kratica' id='kratica'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='opis'><strong>Opis:</strong></label>
                </td>
                <td>
                    <input type='text' name='opis' id='opis'/>
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
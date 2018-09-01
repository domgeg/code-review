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
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $nid=$_GET['natjecaj'];

        $sql="SELECT * FROM natjecaj WHERE natjecaj_id='$nid'";
        $rs=izvrsiUpit($bp,$sql);
        list($id,$zid,$naziv,$dk,$vk,$di,$vi,$brm,$kz,$opis)=mysqli_fetch_array($rs);

    }else{
        $nid=$_GET['natjecaj'];
        $naziv=$_POST['naziv'];
        $brm=$_POST['brm'];
        $dk=$_POST['datumkreiranja'];
        $dk=date('Y-m-d',strtotime($dk));
        $vk=$_POST['vrijemekreiranja'];
        $di=$_POST['datumisteka'];
        $di=date('Y-m-d',strtotime($di));
        $vi=$_POST['vrijemeisteka'];
        $kz=$_POST['kratica'];
        $opis=$_POST['opis'];

        $sql="UPDATE natjecaj SET
            naziv='$naziv',datum_kreiranja='$dk',vrijeme_kreiranja='$vk',datum_isteka='$di',vrijeme_isteka='$vi',broj_radnih_mjesta=$brm,kratica_zupanije='$kz',opis='$opis'
            WHERE natjecaj_id = $nid;";

        izvrsiUpit($bp,$sql);
        header("Location: natjecaj.php?natjecaj=$nid");
        exit();
    }
?>
<form method="POST" action="azuriraj-natjecaj.php?natjecaj=<?php echo $nid; ?>" id="azuriraj_natjecaj" name="azuriraj_natjecaj" onsubmit="return validacija();">
    <table>
        <caption>Azuruiraj natjecaj</caption>
        <tbody>
            <tr>
                <td><div class='error'></div></td>
            </tr>
            <tr>
                <td class='lijevi'>
                    <label for='naziv'><strong>Naziv:*</strong></label>
                </td>
                <td>
                    <input type='text' name='naziv' id='naziv' value='<?php echo $naziv ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='brm'><strong>Broj radnih mjesta:*</strong></label>
                </td>
                <td>
                    <input type='number' name='brm' id='brm' value='<?php echo $brm; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='datumkreiranja'><strong>Datum kreiranja:*</strong></label>
                </td>
                <td>
                    <input type='text' name='datumkreiranja' id='datumkreiranja' placeholder='dd.mm.yyyy' value='<?php echo date("d.m.Y", strtotime($dk)); ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='vrijemekreiranja'><strong>Vrijeme kreiranja:*</strong></label>
                </td>
                <td>
                    <input type='text' name='vrijemekreiranja' id='vrijemekreiranja' placeholder='hh:mm:ss' value='<?php echo $vk; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='datumisteka'><strong>Datum isteka:*</strong></label>
                </td>
                <td>
                    <input type='text' name='datumisteka' id='datumisteka' placeholder='dd.mm.yyyy' value='<?php echo date("d.m.Y", strtotime($di)); ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='vrijemeisteka'><strong>Vrijeme isteka:*</strong></label>
                </td>
                <td>
                    <input type='text' name='vrijemeisteka' id='vrijemeisteka' placeholder='hh:mm:ss' value='<?php echo $vi; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='kratica'><strong>Kratica zupanije:*</strong></label>
                </td>
                <td>
                    <input type='text' name='kratica' id='kratica' value='<?php echo $kz; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='opis'><strong>Opis:</strong></label>
                </td>
                <td>
                    <input type='text' name='opis' id='opis' value='<?php echo $opis; ?>'/>
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
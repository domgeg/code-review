<?php
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if(isset($_GET['zavod'])){
        $id=$_GET['zavod'];

        $date=date('Y-m-d');
        $time=date('H:i:s');

        if($aktivni_korisnik===0){
            $sql="SELECT * FROM natjecaj WHERE zavod_id='$id' AND datum_isteka < CURDATE() OR (datum_isteka = CURDATE() AND vrijeme_isteka > CURTIME())";
        }
        else{
            $sql="SELECT * FROM natjecaj WHERE zavod_id='$id' ORDER BY datum_isteka DESC";
        }

        $rsnatjecaji=izvrsiUpit($bp,$sql);

        $nesta="SELECT * FROM zavod WHERE zavod_id='$id'";
        $rszavod=izvrsiUpit($bp,$nesta);
        $zavod=mysqli_fetch_object($rszavod);
    }
?>

 <table>
    <caption>Detalj zavoda</caption>
    <thead>
        <tr>
            <th>Naziv</th>
            <th>Opis</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $zavod->naziv; ?></td>
            <td><?php echo $zavod->opis; ?></td>
        </tr>
    </tbody>
</table>
<hr />
<?php if ($rsnatjecaji->num_rows): ?>
    <table>
        <caption>Popis natječaja odabranog zavoda</caption>
        <thead>
            <tr>
                <th>Naziv</th>
                <th>Opis</th>
                <?php if ($aktivni_korisnik !== 0): ?>
                    <th>Status</th>
                <?php endif ?>
                <th>Vise</th>
            </tr>
        </thead>
        <tbody>
            <?php while (list($id,$zid,$naziv,$dk,$vk,$di,$vi,$brm,$kz,$opis)=mysqli_fetch_array($rsnatjecaji)): ?>
                <tr>
                    <td><?php echo $naziv; ?></td>
                    <td><?php echo $opis ?></td>
                        <?php if ($aktivni_korisnik !== 0): ?>
                            <td>
                                <?php if ($di<$date || $di==$date && $vi > $time): ?>
                                    Zatvoren
                                <?php else: ?>
                                    Otvoren
                                <?php endif ?>
                            </td>
                        <?php endif ?>
                    <td><a href="natjecaj.php?natjecaj=<?php echo $id ?>">vise</a></td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>

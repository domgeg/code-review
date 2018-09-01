<?php
    ob_start();
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $slika=$_POST['slika'];
        $video='';
        if(isset($_POST['video']))
            $video=$_POST['video'];

        $id = $_GET['natjecaj'];
        $sql="INSERT INTO pristupnik
            (korisnik_id,natjecaj_id,status,slika,video) VALUES
            ($aktivni_korisnik_id,$id,'Z','$slika','$video');";

        izvrsiUpit($bp,$sql);
        header("Location: zavodi.php");
        exit();
    }else{
        $nid=$_GET['natjecaj'];
        if($aktivni_korisnik===0)
            $sql="SELECT * FROM pristupnik WHERE natjecaj_id=$nid AND status='P'";
        else
            $sql="SELECT * FROM pristupnik WHERE natjecaj_id=$nid AND status='Z'";
        $rspristupnik=izvrsiUpit($bp,$sql);

        if ($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0){
            $sql="SELECT * FROM natjecaj AS n, zavod AS z WHERE z.zavod_id = n.zavod_id AND z.moderator_id = $aktivni_korisnik_id";
            $rsnatjecaj=izvrsiUpit($bp,$sql);
        }
    }
?>
<?php if ($rspristupnik->num_rows): ?>
    <table>
        <caption>Pristupnici</caption>
        <thead>
            <tr>
                <th>Slika</th>
                <th>Video</th>
            </tr>
        </thead>
        <tbody>
            <?php while (list($id,$natjecajid,$status,$slika,$video)=mysqli_fetch_array($rspristupnik)): ?>
                <tr>
                    <td><img src="<?php echo $slika ?>"></td>
                    <?php if ($video): ?>
                        <td>
                            <video width="320" height="240" controls>
                                <source src="<?php echo $video ?>" type="video/mp4">
                            </video>
                        </td>
                    <?php endif ?>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
<?php endif ?>

<?php if ($aktivni_korisnik): ?>
    <form method="POST" action="natjecaj.php?natjecaj=<?php echo $nid; ?>" id="natjecaj" name="natjecaj" onsubmit="return validacija();">
        <table>
            <caption>Prijava na natjecaj</caption>
            <tbody>
                <tr>
                    <td><div class='error'></div></td>
                </tr>
                <tr>
                    <td class='lijevi'>
                        <label for='slika'><strong>Slika:*</strong></label>
                    </td>
                    <td>
                        <input type='text' name='slika' id='slika'/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='video'><strong>Video:</strong></label>
                    </td>
                    <td>
                        <input type='text' name='video' id='video'>
                    </td>
                </tr>
                <tr>
                    <td colspan='2' style='text-align:center;'>
                        <input name='submit' type='submit' value='Pošalji'/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
<?php endif ?>
<?php if ($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0 && $rsnatjecaj->num_rows): ?>
    <table>
        <caption>Popis vasih natjecaja</caption>
        <thead>
            <tr>
                <th>Id</th>
                <th>Zavod id</th>
                <th>Naziv</th>
                <th>Datum kreiranja</th>
                <th>Vrijeme kreiranja</th>
                <th>Datum isteka</th>
                <th>Vrijeme isteka</th>
                <th>Broj radnih mjesta</th>
                <th>Kratica zupanije</th>
                <th>Opis</th>
                <th>Azuriraj</th>
            </tr>
        </thead>
        <tbody>
            <?php while (list($id,$zid,$naziv,$dk,$vk,$di,$vi,$brm,$kz,$opis)=mysqli_fetch_array($rsnatjecaj)): ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $zid; ?></td>
                    <td><?php echo $naziv; ?></td>
                    <td><?php echo date("d.m.Y", strtotime($dk)); ?></td>
                    <td><?php echo $vk; ?></td>
                    <td><?php echo date("d.m.Y", strtotime($di)); ?></td>
                    <td><?php echo $vi; ?></td>
                    <td><?php echo $brm; ?></td>
                    <td><?php echo $kz; ?></td>
                    <td><?php echo $opis; ?></td>
                    <td><a href="azuriraj-natjecaj.php?natjecaj=<?php echo $id; ?>">Azuriraj</a></td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>

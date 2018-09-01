<?php
    ob_start();
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if ($aktivni_korisnik_tip==2) {
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $nid=$_GET['natjecaj'];
        $action = "natjecaj.php?natjecaj=$nid";

        $sql="SELECT * FROM pristupnik WHERE natjecaj_id='$nid'";
        $rs=izvrsiUpit($bp,$sql);
    }else{
        $ids=$_POST['id'];
        foreach( $ids as $id ){
            $sql="UPDATE pristupnik SET status='P' WHERE korisnik_id=$id;";
            izvrsiUpit($bp,$sql);
        }
        header("Location: index.php");
        exit();
    }
?>
<?php if ($rs->num_rows): ?>
    <form action='zavrseni-natjecaj.php' method='POST' id='zaposleni_pristupnik' name='zaposleni_pristupnik'>
        <table>
            <caption>Popis kreiranih natjecaja</caption>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Natjecaj id</th>
                    <th>Status</th>
                    <th>Slika</th>
                    <th>Video</th>
                    <th>Zaposlen</th>
                </tr>
            </thead>
            <tbody>
                <?php while (list($id,$nid,$status,$slika,$video)=mysqli_fetch_array($rs)): ?>
                    <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $nid; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><img src=<?php echo $slika; ?> /></td>
                        <td><?php echo $video; ?></td>
                        <td><input type="checkbox" name="id[]" value="<?php echo $id; ?>"/></td>
                    </tr>
                <?php endwhile ?>
                <tr>
                    <td>
                        <input name="submit" type="submit" value="Spremi"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>

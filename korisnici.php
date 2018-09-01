<?php
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET' && $aktivni_korisnik_tip==0){
        $sql = "SELECT * FROM korisnik";
        $rskorisnici=izvrsiUpit($bp,$sql);
    }
?>
<?php if ($aktivni_korisnik_tip==0): ?>
    <table>
        <caption>Popis korisnika</caption>
        <thead>
            <tr>
                <th>Id</th>
                <th>Tip id</th>
                <th>Korisnicko ime</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Email</th>
                <th>Slika</th>
                <th>Azuriraj</th>
            </tr>
        </thead>
        <tbody>
            <?php while (list($id,$tid,$kime,$l,$ime,$prezime,$email,$slika)=mysqli_fetch_array($rskorisnici)): ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $tid; ?></td>
                    <td><?php echo $kime; ?></td>
                    <td><?php echo $ime; ?></td>
                    <td><?php echo $prezime; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><img src="<?php echo $slika; ?>" alt="Slika korisnika <?php echo $kime ?>"></td>
                    <td><a href="azuriraj-korisnika.php?korisnik=<?php echo $id; ?>">Azuriraj</a></td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
    <div class="tab">
        <a href="kreiraj-korisnika.php">Kreiraj novog korisnika</a>
    </div>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>
<?php
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0){
        $sql="SELECT * FROM natjecaj n, zavod z
            WHERE z.zavod_id = n.zavod_id AND z.moderator_id = $aktivni_korisnik_id ORDER BY n.datum_isteka DESC;";
        $rsnatjecaj=izvrsiUpit($bp,$sql);
    }
?>
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
                <?php if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1): ?>
                    <th>Azuriraj</th>
                <?php endif ?>
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
                    <?php if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1): ?>
                        <td><a href="azuriraj-natjecaj.php?natjecaj=<?php echo $id; ?>">Azuriraj</a></td>
                    <?php endif ?>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
<?php endif ?>
<?php if ($aktivni_korisnik_tip == 0): ?>
    <div class="tab">
        <a href='kreiraj-zavod.php'>Kreiraj novi zavod</a>
    </div>
<?php endif ?>
<?php if ($aktivni_korisnik_tip == 1 || $aktivni_korisnik_tip == 0): ?>
    <div class="tab">
        <a href='kreiraj-natjecaj.php'>Kreiraj novi natjecaj</a>
    </div>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>
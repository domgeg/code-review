<?php
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    $sql="SELECT * FROM zavod";
    $rs=izvrsiUpit($bp,$sql);
?>
<?php if ($rs->num_rows): ?>
    <table>
        <caption>Popis zavoda</caption>
        <thead>
            <tr>
                <?php if ($aktivni_korisnik_tip == 0): ?>
                    <th>Id</th>
                    <th>Moderator id</th>
                <?php endif ?>
                <th>Naziv</th>
                <?php if ($aktivni_korisnik !== 0): ?>
                    <th>Opis</th>
                <?php endif ?>
                <?php if ($aktivni_korisnik_tip == 0): ?>
                    <th>Azuriraj</th>
                <?php endif ?>
            </tr>
        </thead>
        <tbody>
            <?php while(list($id,$moderator,$naziv,$opis)=mysqli_fetch_array($rs)): ?>
                <tr>
                    <?php if ($aktivni_korisnik_tip == 0): ?>
                        <td>
                            <?php echo $id; ?>
                        </td>
                        <td>
                            <?php echo $moderator; ?>
                        </td>
                    <?php endif ?>
                    <td>
                        <a href='zavod.php?zavod=<?php echo $id; ?>'><?php echo $naziv; ?></a>
                    </td>
                    <?php if ($aktivni_korisnik !== 0): ?>
                        <td>
                            <?php echo $opis; ?>
                        </td>
                    <?php endif ?>
                    <?php if ($aktivni_korisnik_tip == 0): ?>
                        <td>
                            <a href='azuriraj-zavod.php?zavod=<?php echo $id; ?>'>Azuriraj</a>
                        </td>
                    <?php endif ?>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>

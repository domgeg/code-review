<?php
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if ($aktivni_korisnik_tip==2) {
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if ($_POST['datum_od']) {
            $datumod=date('Y-m-d',strtotime($_POST['datum_od']));
        }
        if ($_POST['datum_do']) {
            $datumdo=date('Y-m-d',strtotime($_POST['datum_do']));
        }

        $datesql='';
        if ($datumod && $datumdo) {
            $datesql="AND n.datum_isteka BETWEEN '$datumod' AND '$datumdo'";
        }else{
            if ($datumod) {
                $datesql="AND n.datum_isteka >= '$datumod'";
            }elseif ($datumdo) {
                $datesql="AND n.datum_isteka <= '$datumdo'";
            }
        }

        $sql = "SELECT COUNT(*) AS rang_lista_prijava, k.ime, k.prezime FROM korisnik k, pristupnik p, natjecaj n, zavod z
            WHERE k.korisnik_id = p.korisnik_id AND p.natjecaj_id=n.natjecaj_id AND p.status<>'' AND n.zavod_id = z.zavod_id AND z.moderator_id = $aktivni_korisnik_id
            $datesql
            GROUP BY p.korisnik_id ORDER BY rang_lista_prijava DESC, k.ime;";
        $rsbrojprijava=izvrsiUpit($bp,$sql);

        $sql = "SELECT COUNT(DISTINCT p.korisnik_id) AS broj_zaposlenih_u_razdoblju FROM pristupnik p, natjecaj n, zavod z
            WHERE p.natjecaj_id=n.natjecaj_id AND p.status='P' AND n.zavod_id = z.zavod_id AND z.moderator_id = $aktivni_korisnik_id
            $datesql;";
        $rstotal=izvrsiUpit($bp,$sql);
        $total = mysqli_fetch_array($rstotal)[0];
    }
?>
<form method="POST" action="statistika.php" id="statistika" name="statistika" onsubmit="return validacija();">
    <table>
        <caption>Unos razdoblja</caption>
        <tbody>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <label class="error"></label>
                </td>
            </tr>
            <tr>
                <td class='lijevi'>
                    <label for='datum_od'><strong>Datum od:</strong></label>
                </td>
                <td>
                    <input type='text' name='datum_od' id='datum_od' placeholder="dd.mm.gggg" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for='datum_do'><strong>Datum do:</strong></label>
                </td>
                <td>
                    <input type='text' name='datum_do' id='datum_do' placeholder="dd.mm.gggg">
                </td>
            </tr>
            <tr>
                <td colspan='2' style='text-align:center;'>
                    <input type='submit' value='Pošalji'/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <table>
        <caption>Rang lista</caption>
        <thead>
            <tr>
                <th>Broj prijava</th>
                <th>Ime</th>
                <th>Prezime</th>
            </tr>
        </thead>
        <tbody>
            <?php while (list($count,$ime,$prezime,$status)=mysqli_fetch_array($rsbrojprijava)): ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $ime; ?></td>
                    <td><?php echo $prezime; ?></td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
    Broj zaposlenih osoba u razdoblju: <?php echo $total; ?>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>
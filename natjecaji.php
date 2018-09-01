<?php
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if ($aktivni_korisnik_tip!=0) {
        exit();
    }
    $filter="";
    if (!isset($_GET['reset'])) {
        if (isset($_GET['naziv'])) {
            $filter="WHERE naziv like '%" . $_GET['naziv'] . "%'";
        }
        if (isset($_GET['kratica'])) {
            if ($_GET['kratica']!="") {
                if ($filter) {
                    $filter.=" AND kratica_zupanije like '%". $_GET['kratica'] . "%'";
                }else{
                    $filter="WHERE kratica_zupanije like '%". $_GET['kratica'] . "%'";
                }
            }
        }
    }

    $sqlorder="";
    $ordernaziv="naziv";
    $orderkratica="kratica";
    if (isset($_GET['sort'])){
        $value = array_pop($_GET);
        $sqlorder="ORDER BY ";
        switch ($value) {
            case 'naziv':
                $ordernaziv='-naziv';
                $sqlorder.='naziv ASC';
                break;
            case '-naziv':
                $ordernaziv='naziv';
                $sqlorder.='naziv DESC';
                break;
            case 'kratica':
                $orderkratica='-kratica';
                $sqlorder.='kratica_zupanije ASC';
                break;
            case '-kratica':
                $orderkratica='kratica';
                $sqlorder.='kratica_zupanije DESC';
                break;
            default:
                $sqlorder.='naziv';
                break;
        }
    }

    $count = count($_GET);
    $v=($count>0)?"&":"";
    $naziv_url=$trenutna.'?'.http_build_query($_GET).$v."sort=$ordernaziv";
    $kratica_url=$trenutna.'?'.http_build_query($_GET).$v."sort=$orderkratica";

    $sql="SELECT * FROM natjecaj $filter $sqlorder;";
    $rsnatjecaji=izvrsiUpit($bp,$sql);
?>
<?php if ($rsnatjecaji->num_rows): ?>
    <form method="GET" action="natjecaji.php" name="natjecaji" id="natjecaji">
        <table>
            <caption>POPIS NATJECAJA</caption>
            <thead>
                <tr>
                    <th>
                        <label for="naziv">Naziv:</label>
                        <input type="text" name="naziv" value="<?php if(isset($_GET['naziv'])&&!isset($_GET['reset']))echo $_GET['naziv']; ?>">
                    </th>
                    <th>
                        <label for="kratica">Kratica zupanije:</label>
                        <input type="text" name="kratica" value="<?php if(isset($_GET['kratica'])&&!isset($_GET['reset']))echo $_GET['kratica']; ?>">
                    </th>
                    <th><input type="submit" name="reset" value="Izbriši"/></th>
                    <th><input type="submit" value="Filter"/></th>
                </tr>
            </thead>
        </table>
    </form>
    <table>
        <thead>
            <tr>
                <th>
                    <a class='order' href="<?php echo $naziv_url; ?>">Naziv <img src="images/strelica.png" alt="strelica" style="border:0;" title="Sortiraj prema nazivu natječaja"></a>
                </th>
                <th>
                    <a class='order' href="<?php echo $kratica_url; ?>">Kratica <img src="images/strelica.png" alt="strelica" style="border:0;" title="Sortiraj prema kratici županije"></a>
                </th>
            </tr>
        </thead>
    </table>
    <table>
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
                <?php if ($aktivni_korisnik_tip == 0): ?>
                    <th>Azuriraj</th>
                <?php endif ?>
        </thead>
        <tbody>
            <?php while (list($id,$zid,$naziv,$dk,$vk,$di,$vi,$brm,$kz,$opis)=mysqli_fetch_array($rsnatjecaji)): ?>
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
                    <?php if ($aktivni_korisnik_tip == 0): ?>
                        <td>
                            <a href='azuriraj-natjecaj.php?natjecaj=<?php echo $id; ?>'>Azuriraj</a>
                        </td>
                    <?php endif ?>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
<?php else: ?>
    <strong>Nismo pronašli podatke za upit.</strong>
<?php endif ?>
<?php
    zatvoriVezuNaBazu($bp);
    include("footer.php");
?>
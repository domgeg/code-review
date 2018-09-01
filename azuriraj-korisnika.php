<?php
    ob_start();
    include("header.php");
    $bp=spojiSeNaBazu();
?>
<?php echo "<body style='background-color:#D2D2D2'>";  ?>
<?php
    if ($aktivni_korisnik_tip!=0){
        exit();
    }
    $kid=$_GET['korisnik'];

    $sql="SELECT * FROM korisnik WHERE korisnik_id='$kid'";
    $rskoprisnik=izvrsiUpit($bp,$sql);
    list($id,$tid,$kime,$l,$ime,$prezime,$email,$slika)=mysqli_fetch_array($rskoprisnik);

    $sql="SELECT * FROM tip_korisnika;";
    $rstip=izvrsiUpit($bp,$sql);

    $error = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_FILES["fileToUpload"]["size"] > 0) {
            $target_dir = "korisnici/";
            $rand = substr(md5(microtime()),rand(0,26),5);
            $target_file = $target_dir . $rand . '.' . basename($_FILES["fileToUpload"]["name"]);

            $uploadOk = 0;
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $error .= "File is not an image. ";
                $uploadOk = 0;
            }
            if (file_exists($target_file)) {
                $error .= "Sorry, file already exists. ";
                $uploadOk = 0;
            }
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                $error .= "Sorry, your file is too large. ";
                $uploadOk = 0;
            }
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
                $uploadOk = 0;
            }
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $id=$_GET['korisnik'];
                    $tip=$_POST['tip'];
                    $kime=$_POST['korisnicko_ime'];
                    $ime=$_POST['ime'];
                    $prezime=$_POST['prezime'];
                    $email=$_POST['email'];

                    $sql="UPDATE korisnik SET
                        tip_id=$tip,korisnicko_ime='$kime',ime='$ime',prezime='$prezime',email='$email',slika='$target_file'
                        WHERE korisnik_id = $id;";

                    izvrsiUpit($bp,$sql);


                    header("Location: korisnici.php");
                    exit();
                }
            }
        } else {
            $tip=$_POST['tip'];
            $kime=$_POST['korisnicko_ime'];
            $ime=$_POST['ime'];
            $prezime=$_POST['prezime'];
            $email=$_POST['email'];

            $sql="UPDATE korisnik SET
                tip_id=$tip,korisnicko_ime='$kime',ime='$ime',prezime='$prezime',email='$email'
                WHERE korisnik_id = $kid;";

            izvrsiUpit($bp,$sql);

            header("Location: korisnici.php");
            exit();
        }
    }
?>
<form method="POST" action="azuriraj-korisnika.php?korisnik=<?php echo $id; ?>" id="azuriraj_korisnika" name="azuriraj_korisnika" onsubmit="return validacija();" enctype="multipart/form-data">
    <div class="error"><?php echo $error; ?></div>
    <table>
        <caption>Azuruiraj korisnika</caption>
        <tbody>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <label class="error error-form"></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='tip'><strong>Tip:</strong></label>
                </td>
                <td>
                    <select name="tip" id="tip">
                        <?php while (list($id,$naziv)=mysqli_fetch_array($rstip)): ?>
                            <option value="<?php echo $id; ?>" <?php if ($id==$tid): ?>selected<?php endif ?> >
                                <?php echo $naziv; ?>
                            </option>
                        <?php endwhile ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='korisnicko_ime'><strong>Korisnicko ime:</strong></label>
                </td>
                <td>
                    <input type='text' name='korisnicko_ime' id='korisnicko_ime' value='<?php echo $kime ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='ime'><strong>Ime:</strong></label>
                </td>
                <td>
                    <input type='text' name='ime' id='ime' value='<?php echo $ime; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='prezime'><strong>Prezime:</strong></label>
                </td>
                <td>
                    <input type='text' name='prezime' id='prezime' value='<?php echo $prezime; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='email'><strong>Email:</strong></label>
                </td>
                <td>
                    <input type='text' name='email' id='email' value='<?php echo $email; ?>'/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for='slika'><strong>Slika:</strong></label>
                </td>
                <td>
                    <input type="file" name="fileToUpload" id="fileToUpload">
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
<?php
    include 'conn.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST['model'];
    $idTip = $_POST['tip'];
    $idProizvodjac = $_POST['proizvodjac'];
    $cena = $_POST['cena'];
    $kolicina = $_POST['kolicina'];

    if(isset($_FILES["image"])) {
        $targetFile = basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['image']['tmp_name']);

        if($check !== false) {
            if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                echo "Nepodrzan format. Mozete koristiti samo JPG, JPEG i PNG format";
            } else {
                $uploadsDirectory = './uploads/';
                $targetFilePath = $uploadsDirectory . $targetFile;

                if(move_uploaded_file($_FILES["image"]['tmp_name'], $targetFilePath)) {
                    $sql = "INSERT INTO gadget(idTip, idProizvodjac, model, cena, kolicina, image)
                    VALUES (:idTip, :idProizvodjac, :model, :cena, :kolicina, :image)";
                    
                    $stmt = $pdo->prepare($sql);
                    
                    $stmt->bindParam(':idTip', $idTip);
                    $stmt->bindParam(':idProizvodjac', $idProizvodjac);
                    $stmt->bindParam(':model', $model);
                    $stmt->bindParam(':cena', $cena);
                    $stmt->bindParam(':kolicina', $kolicina);
                    $stmt->bindParam(':image', $targetFile);
                    
                    $stmt->execute();
                    
                    header("Location: admin.php");
                    exit();
                } else {
                    echo "Greska prilikom uploadovanja slike";
                }
            }
        } else {
            echo "Uneti fajl nije slika";
        }
    }
}

?>
<?php
    include 'conn.php';

    $idGadget = $_POST['idGadget'];
    $model = $_POST['model'];
    $idTip = $_POST['tip'];
    $idProizvodjac = $_POST['proizvodjac'];
    $cena = $_POST['cena'];
    $kolicina = $_POST['kolicina'];
    $image = $_POST['image'];

    $sql = "UPDATE `gadget` SET `idTip` = :idTip, `idProizvodjac` = :idProizvodjac,
    `model` = :model, `cena` = :cena, `kolicina` = :kolicina, `image` = :image,
    last_updated = NOW() WHERE `idGadget` = :idGadget";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':idTip', $idTip);
    $stmt->bindParam(':idProizvodjac', $idProizvodjac);
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':cena', $cena);
    $stmt->bindParam(':idGadget', $idGadget);
    $stmt->bindParam(':kolicina', $kolicina);
    $stmt->bindParam(':image', $image);

    $stmt->execute();

    header("Location: admin.php");
?>
<?php
    include 'conn.php';

    $idGadget = $_GET['idGadget'];

    $sql = "DELETE FROM `gadget` WHERE `idGadget` = :idGadget";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':idGadget', $idGadget);

    $stmt->execute();

    header("Location: admin.php");
?>
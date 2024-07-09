<?php
    include 'conn.php';
    $id = $_POST['id'];
    $kolicina = $_POST['kolicina'];

    if($kolicina == 0) {
        $sql = "DELETE FROM cart WHERE id = :id";
    } else {
        $sql = "UPDATE cart SET kolicina = :kolicina WHERE id = :id";
    }


    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id);
    if($kolicina != 0) {
        $stmt->bindParam(':kolicina', $kolicina);
    }

    $stmt->execute();

    header("Location: cart.php");
?>
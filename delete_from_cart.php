<?php
    include 'conn.php';

    $id = $_GET['id'];

    $sql = "DELETE FROM cart WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id);

    $stmt->execute();

    header("Location: cart.php");
?>
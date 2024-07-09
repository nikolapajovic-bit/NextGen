<?php
    include 'conn.php';

    $imePrezime = $_POST['imePrezime'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $idUloge = 2;
    $aktivan = 0;

    $sql = "INSERT INTO korisnik (imePrezime, idUloge, username, password, aktivan)
    VALUES (:imePrezime, :idUloge, :username, :password, :aktivan)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':imePrezime', $imePrezime);
    $stmt->bindParam(':idUloge', $idUloge);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':aktivan', $aktivan);

    $stmt->execute();

    header("Location: index.php?registracija=1");
?>
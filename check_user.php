<?php
    if(isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        include 'conn.php';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $aktivan = 1;

        $upit = $pdo->prepare("SELECT * FROM korisnik WHERE username = :username AND password = :password AND aktivan = :aktivan");
        $upit->bindParam(':username', $username);
        $upit->bindParam(':password', $password);
        $upit->bindParam(':aktivan', $aktivan);

        $upit->execute();

        $rezultat = $upit->fetch(PDO::FETCH_ASSOC);

        if(!$rezultat) {
            header("Location: index.php?error=2");
            exit();
        } else {
            session_start();
            $_SESSION['idKorisnik'] = $rezultat['idKorisnik'];
            $_SESSION['imePrezime'] = $rezultat['imePrezime'];
            $_SESSION['idUloge'] = $rezultat['idUloge'];

            if($_SESSION['idUloge'] == 1) {
                header("Location: admin.php");
                exit();
            }
            if($_SESSION['idUloge'] == 2) {
                header("Location: korisnik.php");
                exit();
            }
        }
    } else {
        header("Location: index.php?error=1");
        exit();
    }
?>
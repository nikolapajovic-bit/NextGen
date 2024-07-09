<?php
    include 'conn.php';

    $idKorisnik = $_POST['idKorisnik'];
    $idGadget = $_POST['idGadget'];
    $kolicina = $_POST['kolicina'];

    $sqlKolicina = "SELECT kolicina FROM gadget WHERE idGadget = :idGadget";
    $stmtKolicina = $pdo->prepare($sqlKolicina);
    $stmtKolicina->bindParam(':idGadget', $idGadget);
    $stmtKolicina->execute();
    $kolicinaInfo = $stmtKolicina->fetch(PDO::FETCH_ASSOC);

    if($kolicinaInfo) {
        $dostupnaKolicina = $kolicinaInfo['kolicina'];

        $sqlCart = "SELECT kolicina FROM cart WHERE idGadget = :idGadget AND idKorisnik = :idKorisnik";
        $stmtCart = $pdo->prepare($sqlCart);
        $stmtCart->bindParam(':idGadget', $idGadget);
        $stmtCart->bindParam(':idKorisnik', $idKorisnik);
        $stmtCart->execute();
        $cartInfo = $stmtCart->fetch(PDO::FETCH_ASSOC);

        $trenutnoUKorpi = $cartInfo ? $cartInfo['kolicina'] : 0;
        $total = $trenutnoUKorpi + $kolicina;

        if($total <= $dostupnaKolicina) {
            if($cartInfo) {
                $sqlUpdateCart = "UPDATE cart SET kolicina = kolicina + :kolicina WHERE idGadget = :idGadget AND idKorisnik = :idKorisnik";
                $stmtUpdateCart = $pdo->prepare($sqlUpdateCart);
                $stmtUpdateCart->bindParam(':kolicina', $kolicina);
                $stmtUpdateCart->bindParam(':idGadget', $idGadget);
                $stmtUpdateCart->bindParam(':idKorisnik', $idKorisnik);
                $stmtUpdateCart->execute();
            } else {
                $sqlUnesi = "INSERT INTO cart(idGadget, idKorisnik, kolicina) VALUES (:idGadget, :idKorisnik, :kolicina)";
                $stmtUnesi = $pdo->prepare($sqlUnesi);
                $stmtUnesi->bindParam(':idGadget', $idGadget);
                $stmtUnesi->bindParam(':idKorisnik', $idKorisnik);
                $stmtUnesi->bindParam(':kolicina', $kolicina);
                $stmtUnesi->execute();
            }
            header("Location: korisnik.php?msg=uspesno");
            exit();
        } else {
            header("Location: korisnik.php?msg=nedovoljna_kolicina");
            exit();
        }
    } else {
        header("Location: korisnik.php?msg=proizvod_nedostupan");
        exit();
    }
?>
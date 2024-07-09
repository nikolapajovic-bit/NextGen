<?php include 'session_checker.php' ?>
<?php include 'conn.php' ?>

<?php
    $idKorisnik = $_SESSION['idKorisnik'];
    $sql = "SELECT cart.id, cart.kolicina, gadget.model, gadget.cena, gadget.image, s_tip.tip, s_proizvodjac.proizvodjac
    FROM cart
    LEFT JOIN gadget on cart.idGadget = gadget.idGadget
    LEFT JOIN s_tip on gadget.idTip = s_tip.tip
    LEFT JOIN s_proizvodjac on gadget.idProizvodjac = s_proizvodjac.id
    WHERE idKorisnik = :idKorisnik";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idKorisnik', $idKorisnik);
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>
        <link rel="stylesheet" href="cartStyle.css">
    </head>
    <body>
        <div class="container">
            <h1>Vasa Korpa</h1>
            <button onclick="window.location.href='korisnik.php'">
                Nastavite kupovinu
            </button>
            <table>
                <thead>
                    <tr>
                        <th>Slika</th>
                        <th>Model</th>
                        <th>Tip</th>
                        <th>Proizvodjac</th>
                        <th>Kolicina</th>
                        <th>Cena</th>
                        <th>Racun</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $suma = 0;
                        foreach($cartItems as $item) { ?>
                            <?php $racun = $item['kolicina'] * $item['cena'] ?>
                            <?php $suma += $racun ?>

                            <tr>
                                <form action="upd_cart.php" method="POST">
                                    <input type="text" hidden name="id" value="<?php echo $item['id'] ?>">
                                    <td><img src="<?php echo $item['image']?>" alt="<?php echo $gadget['model'] ?>" width="100"></td>
                                    <td><?php echo $item['model'] ?></td>
                                    <td><?php echo $item['tip'] ?></td>
                                    <td><?php echo $item['proizvodjac'] ?></td>
                                    <td><input type="number" name="kolicina" value="<?php echo $item['kolicina'] ?>"></td>
                                    <td><?php echo $item['cena'] ?> RSD</td>
                                    <td><?php echo $racun ?> RSD</td>
                                    <td>
                                        <button type="submit">
                                            Update
                                        </button>
                                    </td>
                                </form>
                                <td>
                                    <form action="delete_from_cart.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                        <button type="submit">
                                            Obrisi
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    <?php } ?>
                        <tr class="total-row">
                            <td colspan="6" rowspan="1"></td>
                            <td>Ukupno:</td>
                            <td><?php echo $suma ?> RSD</td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
<?php include 'session_checker.php' ?>
<?php include 'conn.php' ?>

<?php
    $idKorisnik = $_SESSION['idKorisnik'];

    $user = $_SESSION['imePrezime'];

    $sql = "SELECT gadget.model, gadget.cena, gadget.idGadget, gadget.kolicina, gadget.image, s_tip.tip, s_proizvodjac.proizvodjac
    FROM gadget
    LEFT JOIN s_tip on gadget.idTip = s_tip.id
    LEFT JOIN s_proizvodjac on gadget.idProizvodjac = s_proizvodjac.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $gadgets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT idGadget, kolicina FROM cart WHERE idKorisnik = :idKorisnik";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idKorisnik', $idKorisnik);
    $stmt->execute();
    $myCart = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $numberOfThingsInCart = count($myCart);

    $poruka = "";
    if(isset($_GET['msg'])) {
        if($_GET['msg'] == "uspesno") {
            $poruka = "Artikal dodat u korpu";
        } elseif ($_GET['msg'] == "nedovoljna_kolicina") {
            $poruka = "Nedovoljna kolicina";
        } elseif ($_GET['msg'] == "proizvod_nedostupan") {
            $poruka = "Proizvod nije dostupan";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dobrodosli</title>
        <link rel="stylesheet" href="korisnikStyle.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            h2 {
                text-align:center;
            }
        </style>
    </head>
    <body>
        <header class="header">
            <div class="msg">Dobrodosli, <?php echo $user ?></div>
            <div class="logout">
                <form action="logOut.php" method="POST">
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Log out
                    </button>
                </form>
                <form action="cart.php" method="GET">
                    <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i>
                        <span><?php echo $numberOfThingsInCart; ?></span>
                    </button>
                </form>
            </div>
        </header>
        <div>
            <h2>Gadgets</h2>
            <h3><?php echo $poruka; ?></h3>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Model</th>
                        <th>Tip</th>
                        <th>Proizvodjac</th>
                        <th>Cena</th>
                        <th>Kolicina</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($gadgets as $gadget) {
                        $inCart = 0;
                        foreach($myCart as $item) {
                            if($gadget['idGadget'] == $item['idGadget'] && isset($item['kolicina'])) {
                                $inCart += $item['kolicina'];
                            }
                        }
                        $ostalaKolicina = $gadget['kolicina'] - $inCart;

                        // echo "Gadget ID: {$gadget['idGadget']}, In Cart: $inCart, Remaining: $ostalaKolicina";

                        if($ostalaKolicina > 0) { ?>
                            <tr>
                                <td><img src="<?php echo $gadget['image']?>" alt="<?php echo $gadget['model'] ?>" width="100"></td>
                                <td><?php echo $gadget['model'] ?></td>
                                <td><?php echo $gadget['tip'] ?></td>
                                <td><?php echo $gadget['proizvodjac'] ?></td>
                                <td style="font-weight: bold;"><?php echo $gadget['cena'] ?> RSD</td>
                                <td>
                                    <form action="ins_cart.php" method="post">
                                        <input type="text" hidden name="idKorisnik" value="<?php echo $idKorisnik ?>">
                                        <input type="text" hidden name="idGadget" value="<?php echo $gadget['idGadget'] ?>">
                                        <input type="number" min="1" max="<?php echo $ostalaKolicina ?>" name="kolicina" value="1">
                                        <button type="submit">
                                            Add to cart
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="gadget_detail.php" method="GET">
                                        <input type="text" hidden name="idGadget" value="<?php echo $gadget['idGadget'] ?>">
                                        <button type="submit">
                                            Detalji
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
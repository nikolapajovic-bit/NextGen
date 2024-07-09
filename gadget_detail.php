<?php
    include 'conn.php';

    if(isset($_GET['idGadget']) && !empty($_GET['idGadget'])) {
        $idGadget = $_GET['idGadget'];

        $sql = "SELECT gadget.model, gadget.cena, gadget.kolicina, gadget.image, s_tip.tip, s_proizvodjac.proizvodjac
        FROM GADGET
        LEFT JOIN s_tip on gadget.idTip = s_tip.id
        LEFT JOIN s_proizvodjac on gadget.idProizvodjac = s_proizvodjac.id
        WHERE gadget.idGadget = :idGadget";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idGadget', $idGadget);
        $stmt->execute();
        $gadget = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$gadget) {
            echo "Proizvod nije pronadjen";
            exit();
        }
    } else {
        echo "Nema ID-a za ovaj proizvod";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $gadget['model'] ?></title>
        <link rel="stylesheet" href="detalji.css">
    </head>
    <body>
        <div class="container">
            <div class="image-container">
                <img src="./<?php echo $gadget['image'] ?>" alt="<?php echo $gadget['model']?>" style="max-width: 200px">
            </div>
            <div class="details-container">
                <div class="heading">
                    <h1><?php echo $gadget['proizvodjac'] ?></h1>
                    </h2><?php echo $gadget['model']?></h2>
                </div>
                <div>
                    <p><strong>Tip:</strong> <?php echo $gadget['tip'] ?></p>
                </div>
                <div>
                    <p><strong>Preostala kolicina:</strong> <?php echo $gadget['kolicina'] ?></p>
                </div>
                <div>
                    <p><strong>Cena:</strong> <?php echo $gadget['cena'] ?> RSD</p>
                </div>
                <div>
                    <form action="korisnik.php" method="GET">
                        <button type="submit">
                            Nazad
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<?php include 'session_checker.php'; ?>
<?php include 'conn.php'; ?>

<?php
    $idGadget = $_GET['idGadget'];
    
    $sql = "SELECT *, DATE_FORMAT(last_updated, '%d-%m-%Y %H:%i:%s') as formatted_last_updated FROM gadget WHERE idGadget = :idGadget";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idGadget', $idGadget);
    $stmt->execute();

    $gadgetForUpdate = $stmt->fetch(PDO::FETCH_ASSOC);

    $upit = $pdo->prepare("SELECT * FROM s_tip");

    $upit->execute();
    $tipovi = $upit->fetchAll(PDO::FETCH_ASSOC);

    $upit = $pdo->prepare("SELECT * FROM s_proizvodjac");

    $upit->execute();
    $proizvodjaci = $upit->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <h1>Update gadget</h1>
        <form action="updt_gadget.php" method="post">
            <div>
                <label for="image">Slika</label>
                <input id="image" type="file" name="image">
            <div>
            <div>
                <label for="model">Model</label>
                <input type="text" name="idGadget" hidden value="<?php echo $idGadget ?>">
                <input id="model" type="text" name="model" value="<?php echo $gadgetForUpdate['model'] ?>">
            </div>
            <div>
                <label for="tip">Tip</label>
                <select name="tip" id="tip">
                    <?php foreach($tipovi as $row) { ?>
                        <option <?php echo ($row['id'] == $gadgetForUpdate['idTip']) ? 'selected' : ''; ?> value="<?php echo $row['id'] ?>">
                            <?php echo $row['tip'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="proizvodjac">Proizvodjac</label>
                <select name="proizvodjac" id="proizvodjac">
                    <?php foreach($proizvodjaci as $row) { ?>
                        <option <?php echo ($row['id'] == $gadgetForUpdate['idProizvodjac']) ? 'selected' : ''; ?> value="<?php echo $row['id'] ?>">
                            <?php echo $row['proizvodjac'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="kolicina">Kolicina</label>
                <input id="kolicina" type="number" name="kolicina" value="<?php echo $gadgetForUpdate['kolicina'] ?>">
            </div>
            <div>
                <label for="cena">Cena</label>
                <input id="cena" type="text" name="cena" value="<?php echo $gadgetForUpdate['cena'] ?>">
            </div>
            <div>
                <label for="last_updated">Last Updated</label>
                <input id="last_updated" type="text" name="last_updated" value="<?php echo $gadgetForUpdate['last_updated'] ?>" readonly>
            </div>
            <div>
                <button type="submit">
                    Update
                </button>
            </div>
        </form>
    </body>
</html>
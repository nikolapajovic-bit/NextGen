<?php include 'session_checker.php'; ?>
<?php include 'conn.php'; ?>

<?php
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
        <title>Add gadget</title>
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <div class="container">
        <h1>Add gadget</h1>
        <form action="ins_gadget.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="image">Slika</label>
                <input id="image" type="file" name="image">
            <div>
                <label for="model">Model</label>
                <input id="model" type="text" name="model">
            </div>
            <div>
                <label for="tip">Tip</label>
                <select name="tip" id="tip">
                    <?php foreach($tipovi as $row) { ?>
                        <option value="<?php echo $row['id'] ?>">
                            <?php echo $row['tip'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="proizvodjac">Proizvodjac</label>
                <select name="proizvodjac" id="proizvodjac">
                    <?php foreach($proizvodjaci as $row) { ?>
                        <option value="<?php echo $row['id'] ?>">
                            <?php echo $row['proizvodjac'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="kolicina">Kolicina</label>
                <input id="kolicina" type="number" name="kolicina">
            </div>
            <div>
                <label for="cena">Cena</label>
                <input id="cena" type="text" name="cena">
            </div>
            <div>
                <button type="submit">
                    Add
                </button>
            </div>
        </form>
        </div>
    </body>
</html>
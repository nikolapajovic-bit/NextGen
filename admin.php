<?php include 'session_checker.php'; ?>
<?php include 'conn.php'; ?>

<?php
    $user = $_SESSION['imePrezime'];
    $idKorisnik = $_SESSION['idKorisnik'];

    $sql = "SELECT * FROM korisnik WHERE idKorisnik != :idKorisnik";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idKorisnik', $idKorisnik);
    $stmt->execute();
    $korisnici = $stmt->fetchAll();

    $sql = "SELECT gadget.model, gadget.cena, gadget.idGadget, gadget.image, s_tip.tip, s_proizvodjac.proizvodjac, gadget.kolicina,
    DATE_FORMAT(gadget.last_updated, '%d-%m-%Y %H:%i:%s') as formatted_last_updated
    FROM gadget
    LEFT JOIN s_tip on gadget.idTip = s_tip.id
    LEFT JOIN s_proizvodjac on gadget.idProizvodjac = s_proizvodjac.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $gadgets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" href="adminStyle.css">
        <style>
            .gadget {
                display: flex;
                margin-top: 20px;
                justify-content: flex-end;
                margin-right: 50px;
            }
        </style>
    </head>
    <body>
        <header class="header">
            <div class="msg">Ulogovali ste se kao admin.</div>
            <div class="user-info">
                <span><?php echo $user ?></span>
                <form action="logOut.php" method="POST">
                    <button type="submit" class="logout-btn">Log out</button>
                </form>
            </div>
        </header>

        <h1>Users</h1>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ime i Prezime</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($korisnici as $key=>$korisnik) {
                        $key++;
                    ?>
                    <tr>
                        <td><?php echo $key ?></td>
                        <td><?php echo $korisnik['imePrezime'] ?></td>
                        <td><?php echo $korisnik['username'] ?></td>
                        <td><?php echo $korisnik['aktivan'] == 1 ? 'Active' : 'Inactive' ?></td>
                        <td>
                            <?php if($korisnik['aktivan'] == 1) { ?>
                                <form action="aktivacija.php" method="GET" style="display: inline;">
                                    <input type="hidden" name="status" value="0">
                                    <input type="hidden" name="idKorisnik" value="<?php echo $korisnik['idKorisnik'] ?>">
                                    <button type="submit" class="deactivate-btn">Deactivate</button>
                                </form>
                            <?php } else { ?>
                                <form action="aktivacija.php" method="GET" style="display: inline;">
                                    <input type="hidden" name="status" value="1">
                                    <input type="hidden" name="idKorisnik" value="<?php echo $korisnik['idKorisnik'] ?>">
                                    <button type="submit" class="activate-btn">Activate</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h1>Gadgets</h1>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Slika</th>
                        <th>Model</th>
                        <th>Tip</th>
                        <th>Proizvodjac</th>
                        <th>Kolicina</th>
                        <th>Cena</th>
                        <th>Azurirano</th>
                        <th>Opcije</th>
                    <tr>
                </thead>
                <tbody>
                    <?php foreach ($gadgets as $gadget) { ?>
                        <tr>
                            <td><img src="<?php echo $gadget['image']?>" alt="<?php echo $gadget['model'] ?>" width="100"></td>
                            <td><?php echo $gadget['model'] ?></td>
                            <td><?php echo $gadget['tip'] ?></td>
                            <td><?php echo $gadget['proizvodjac'] ?></td>
                            <td><?php echo $gadget['kolicina'] ?></td>
                            <td><?php echo $gadget['cena'] ?> RSD</td>
                            <td><?php echo $gadget['formatted_last_updated'] ?></td>
                            <td>
                                <div>
                                    <form action="azuriraj.php" method="GET">
                                        <input type="hidden" name="idGadget" value="<?php echo $gadget['idGadget'] ?>">
                                        <button type="submit" class="update-btn">Update</button>
                                    </form>
                                </div>
                                <div>
                                    <form action="obrisi.php" method="GET">
                                        <input type="hidden" name="idGadget" value="<?php echo $gadget['idGadget'] ?>">
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="gadget">
            <form action="add_gadget.php" method="GET">
                <button type="submit" class="update-btn">
                    Add Gadget
                </button>
            </form>
        </div>
    </body>
</html>
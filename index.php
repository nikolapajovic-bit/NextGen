<!DOCTYPE html>
<html>
    <head>
        <title>Prijava</title>
        <link rel="stylesheet" href="style.css">
        <style>
            input[type="password"] {
                width: 100%;
                padding: 8px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            .register {
                display: flex;
                align-items: center;
            }
            h3 {
                text-align: center;
            }
            .registracija {
                display: flex;
                flex-direction: column;
                margin-top: 7px;
                align-items: center;
            }
        </style>
    </head>

    <body>
        <?php
            $poruka = "";
            if(isset($_GET['registracija'])) {
                if($_GET['registracija'] == 1) {
                    $poruka = "Vec imate nalog";
                }
            }
            $greska = "";
            if(isset($_GET['error'])) {
                if($_GET['error'] == 1) {
                    $greska = "Molimo unesite podatke";
                }
                if($_GET['error'] == 2) {
                    $greska = "Pogresna sifra ili nepostojeci korisnik";
                }
            }
        ?>

        <h1><?php echo $greska ?></h1>
        <h1><?php echo $poruka ?></h1>
        <header>
            <h1>NextGen Gadgets</h1>
        </header>
        <h3>Prijava</h3>

        <form action="check_user.php" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="register">
                <button type="submit">Login</button>
            </div>
        </form>

        <div class="registracija">
            <p>Nemate nalog? Registrujte se.</p>
            <form action="registracija.php" method="GET">
                <button type="submit">Register</button>
            </form>
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registracija</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Registruj se</h1>
        <div>
            <form action="ins_registracija.php" method="POST">
                <div>
                    <label for="imePrezime">Ime i Prezime:</label>
                    <input type="text" name="imePrezime" id="imePrezime">
                </div>
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="text" name="password" id="password">
                </div>
                <div>
                    <button type="submit">
                        Registruj se
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>
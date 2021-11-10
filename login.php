<?php

declare(strict_types=1);

session_start();

// es bona idea no treballar en literal
const COOKIE_USERNAME = "last_used_name";

$username = "";
$error = "";
// we get the current cookie value
$usernameAux = filter_input(INPUT_COOKIE, COOKIE_USERNAME, FILTER_SANITIZE_SPECIAL_CHARS);

// if null we show a welcome message
if (!empty($usernameAux))
    $username = $usernameAux;

require 'helpers.php';

// en esta funció simule el login
function login($username, $password): bool
{
    return (random_int(0, 1) === 1);
}

if (isPost()) {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    // com que el password pot ser qualsevol caracter no aplique el filtre de sanejament de caràcters especials.
    $password = filter_input(INPUT_POST, "password");

    // no faig cap if perquè de fallar em llançarà una excepció, la capture i au
    try {
        validate_string($username, 1, 30);
        validate_string($password, 1, 255);

        if (login($username, $password)) {
            //cree la cookie
            setcookie(COOKIE_USERNAME, $username, time() + 30 * 24 * 60 * 60);

            $_SESSION["user"] = $username;

        } else {
            //l'elimine;
            setcookie(COOKIE_USERNAME, "", 0);
            // buide username
            $username = "";
            $error = "No s'ha pogut iniciar sessió";
        }
    } catch (ValidationException $e) {
        $error = $e->getMessage();
    }
}

?>

<h2>Login</h2>

<?php if (!empty($error)) : ?>
    <p><?= $error ?></p>
<?php else : ?>
    <p>Has iniciat sessió</p>
<?php endif; ?>
<form action="login.php" method="post" novalidate>
    <div>
        <label for="username">Username</label>
        <input type="text"
               name="username" id="username"
               value="<?= $username ?>"
               placeholder="Username:" required>
    </div>
    <div>
        <label for="password">Contrasenya</label>
        <input type="password"
               name="password" id="password"
               value="<?= null ?? "" ?>"
               placeholder="Password:" required>
    </div>
    <input type="submit" value="Login">
</form>

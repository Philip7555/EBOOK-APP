<?php
session_start();
$config = require __DIR__ . '/../src/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['password'] === $config['admin_password']) {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Nesprávné heslo.';
    }
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div>

    <div>
        <h1>Přihlášení</h1>
    </div>

    <div>

        <?php if ($error): ?>
            <div>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label>Heslo</label>
            <input type="password" name="password" required>

            <div>
                <button type="submit">Přihlásit</button>
            </div>
        </form>

    </div>

</div>

</body>
</html>

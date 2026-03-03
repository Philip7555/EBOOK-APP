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
    <script src="js/darkmode.js" defer></script>
</head>

<body class="admin-layout">

    <div class="container">

        <div class="page-header">
            <h1>Přihlášení</h1>

            <button id="darkmode-toggle" class="darkmode-btn">
                <img src="images/LDM.svg" alt="Dark mode">
            </button>
        </div>

        <div class="admin-card login-box">

            <?php if ($error): ?>
                <div class="admin-card error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <label>Heslo</label>
                <input type="password" name="password" required>

                <div class="admin-actions">
                    <button type="submit" class="btn">Přihlásit</button>
                </div>
            </form>

        </div>

    </div>

</body>

</html>
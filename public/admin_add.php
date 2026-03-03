<?php
require_once __DIR__ . '/../src/Controller/AdminController.php';
require_once __DIR__ . '/../src/Model/Book.php';

AdminController::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Book::create($_POST);
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat knihu</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/darkmode.js" defer></script>
</head>

<body class="admin-layout">

    <div class="container">

        <div class="admin-card">

            <div class="page-header">
                <h1 class="admin-title">Přidat novou knihu</h1>

                <button id="darkmode-toggle" class="darkmode-btn">
                    <img src="images/LDM.svg" alt="Dark mode">
                </button>
            </div>

            <form method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-6">
                        <label>Název</label>
                        <input type="text" name="title" required>
                    </div>

                    <div class="col-6">
                        <label>Autor</label>
                        <input type="text" name="author" required>
                    </div>

                    <div class="col-6">
                        <label>Žánr</label>
                        <input type="text" name="genre">
                    </div>

                    <div class="col-6">
                        <label>Rok vydání</label>
                        <input type="number" name="year" min="0" max="3000">
                    </div>

                    <div class="col-6">
                        <label>Cena (Kč)</label>
                        <input type="number" name="price" min="0" step="0.01">
                    </div>

                    <div class="col-6">
                        <label>Hodnocení</label>
                        <input type="number" name="rating" min="0" max="5" step="0.1">
                    </div>

                    <div class="col-12">
                        <label>Popis</label>
                        <textarea name="description" rows="5"></textarea>
                    </div>

                    <div class="col-12">
                        <label>Obálka</label>
                        <input type="file" name="cover_file">
                    </div>
                </div>

                <div class="admin-actions">
                    <button type="submit" class="btn">Uložit</button>
                    <a href="admin.php" class="btn btn-danger">Zpět</a>
                </div>

            </form>
        </div>

    </div>

</body>

</html>
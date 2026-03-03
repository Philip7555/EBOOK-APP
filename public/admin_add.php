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
</head>

<body>

    <div>

        <div>

            <div>
                <h1>Přidat novou knihu</h1>
            </div>

            <form method="post" enctype="multipart/form-data">

                <div>
                    <div>
                        <label>Název</label>
                        <input type="text" name="title" required>
                    </div>

                    <div>
                        <label>Autor</label>
                        <input type="text" name="author" required>
                    </div>

                    <div>
                        <label>Žánr</label>
                        <input type="text" name="genre">
                    </div>

                    <div>
                        <label>Rok vydání</label>
                        <input type="number" name="year" min="0" max="3000">
                    </div>

                    <div>
                        <label>Cena (Kč)</label>
                        <input type="number" name="price" min="0" step="0.01">
                    </div>

                    <div>
                        <label>Hodnocení</label>
                        <input type="number" name="rating" min="0" max="5" step="0.1">
                    </div>

                    <div>
                        <label>Popis</label>
                        <textarea name="description" rows="5"></textarea>
                    </div>

                    <div>
                        <label>Obálka</label>
                        <input type="file" name="cover_file">
                    </div>
                </div>

                <div>
                    <button type="submit">Uložit</button>
                    <a href="admin.php">Zpět</a>
                </div>

            </form>
        </div>

    </div>

</body>

</html>
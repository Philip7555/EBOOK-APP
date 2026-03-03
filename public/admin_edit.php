<?php
require_once __DIR__ . '/../src/Controller/AdminController.php';
require_once __DIR__ . '/../src/Model/Book.php';

AdminController::requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$book = Book::getById($id);

if (!$book) {
    echo "Kniha nenalezena.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Book::update($id, $_POST);
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit knihu</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/darkmode.js" defer></script>
</head>

<body class="admin-layout">

    <div class="container">

        <div class="admin-card">

            <div class="page-header">
                <h1 class="admin-title">Upravit knihu</h1>

                <button id="darkmode-toggle" class="darkmode-btn">
                    <img src="images/LDM.svg" alt="Dark mode">
                </button>
            </div>

            <form method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-6">
                        <label>Název</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                    </div>

                    <div class="col-6">
                        <label>Autor</label>
                        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                    </div>

                    <div class="col-6">
                        <label>Žánr</label>
                        <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>">
                    </div>

                    <div class="col-6">
                        <label>Rok vydání</label>
                        <input type="number" name="year" min="0" max="3000" value="<?= htmlspecialchars($book['year']) ?>">
                    </div>

                    <div class="col-6">
                        <label>Cena (Kč)</label>
                        <input type="number" name="price" min="0" step="0.01" value="<?= htmlspecialchars($book['price']) ?>">
                    </div>

                    <div class="col-6">
                        <label>Hodnocení</label>
                        <input type="number" name="rating" min="0" max="5" step="0.1" value="<?= htmlspecialchars($book['rating']) ?>">
                    </div>

                    <div class="col-12">
                        <label>Popis</label>
                        <textarea name="description" rows="5"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>

                    <div class="col-12">
                        <label>Nová obálka</label>
                        <input type="file" name="cover_file">
                    </div>

                    <?php if ($book['cover']): ?>
                        <div class="col-12">
                            <p>Aktuální obálka:</p>
                            <img src="<?= Book::getCoverOrDefault($book['cover']) ?>"
                                alt="Aktuální obálka"
                                loading="lazy"
                                class="current-cover">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="admin-actions">
                    <button type="submit" class="btn">Uložit změny</button>
                    <a href="admin.php" class="btn btn-danger">Zpět</a>
                </div>

            </form>
        </div>

    </div>

</body>

</html>
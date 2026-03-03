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
</head>

<body >

<div>

    <div >

        <div >
            <h1 >Upravit knihu</h1>

        
        </div>

        <form method="post" enctype="multipart/form-data">

            <div >
                <div >
                    <label>Název</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                </div>

                <div >
                    <label>Autor</label>
                    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                </div>

                <div >
                    <label>Žánr</label>
                    <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>">
                </div>

                <div >
                    <label>Rok vydání</label>
                    <input type="number" name="year" min="0" max="3000" value="<?= htmlspecialchars($book['year']) ?>">
                </div>

                <div>
                    <label>Cena (Kč)</label>
                    <input type="number" name="price" min="0" step="0.01" value="<?= htmlspecialchars($book['price']) ?>">
                </div>

                <div >
                    <label>Hodnocení</label>
                    <input type="number" name="rating" min="0" max="5" step="0.1" value="<?= htmlspecialchars($book['rating']) ?>">
                </div>

                <div>
                    <label>Popis</label>
                    <textarea name="description" rows="5"><?= htmlspecialchars($book['description']) ?></textarea>
                </div>

                <div>
                    <label>Nová obálka</label>
                    <input type="file" name="cover_file">
                </div>

                <?php if ($book['cover']): ?>
                    <div>
                        <p>Aktuální obálka:</p>
                        <img src="<?= Book::getCoverOrDefault($book['cover']) ?>"
                             alt="Aktuální obálka"
                             loading="lazy"
                             >
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <button type="submit" >Uložit změny</button>
                <a href="admin.php" >Zpět</a>
            </div>

        </form>
    </div>

</div>

</body>
</html>

<?php
require_once __DIR__ . '/../src/Model/Book.php';

$id = (int)($_GET['id'] ?? 0);
$book = Book::getById($id);

if (!$book) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book ? htmlspecialchars($book['title']) : 'Kniha nenalezena' ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/darkmode.js" defer></script>
</head>

<body>

    <div class="page-header">
        <h1>Detail knihy</h1>

        <button id="darkmode-toggle" class="darkmode-btn">
            <img src="images/LDM.svg" alt="Dark mode">
        </button>
    </div>

    <div class="book-detail">

        <?php if (!$book): ?>

            <p>Kniha nenalezena nebo byla odstraněna.</p>
            <p><a href="index.php">← Zpět na katalog</a></p>

        <?php else: ?>

            <button onclick="window.print()" class="print-button">Tisknout</button>

            <div class="book-layout">

                <div class="book-cover">
                    <img src="<?= Book::getCoverOrDefault($book['cover']) ?>"
                        alt="Obálka knihy"
                        loading="lazy">
                </div>

                <div class="book-info">
                    <h2><?= htmlspecialchars($book['title']) ?></h2>

                    <p><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                    <p><strong>Žánr:</strong> <?= htmlspecialchars($book['genre']) ?></p>
                    <p><strong>Rok vydání:</strong> <?= $book['year'] ?></p>
                    <p><strong>Cena:</strong> <?= $book['price'] ?> Kč</p>
                    <p><strong>Hodnocení:</strong> <?= $book['rating'] ?>/10</p>
                    <p><strong>Popis:</strong><br><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                </div>

            </div>

            <p><a href="index.php" class="back-link">← Zpět na katalog</a></p>

        <?php endif; ?>

    </div>

</body>

</html>
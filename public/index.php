<?php
require_once __DIR__ . '/../src/Model/Book.php';
$books = Book::getAll();
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog e‑knih</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/darkmode.js" defer></script>
</head>

<body>

    <div class="page-header">
        <h1>Katalog e‑knih</h1>

        <button id="darkmode-toggle" class="darkmode-btn">
            <img src="images/LDM.svg" alt="Dark mode">
        </button>
    </div>

    <?php if (empty($books)): ?>
        <p>Zatím nejsou žádné knihy v databázi.</p>
    <?php else: ?>

        <ul class="book-list">
            <?php foreach ($books as $book): ?>
                <li class="book-item">
                    <a href="book.php?id=<?= $book['id'] ?>">

                        <img src="<?= Book::getCoverOrDefault($book['cover']) ?>"
                            alt="Obálka knihy"
                            loading="lazy">

                        <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                        <div class="book-author"><?= htmlspecialchars($book['author']) ?></div>
                        <span class="book-year"><?= htmlspecialchars($book['year']) ?></span>

                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

</body>

</html>
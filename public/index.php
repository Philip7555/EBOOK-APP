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
</head>

<body>

    <div>
        <h1>Katalog e‑knih</h1>
    </div>

    <?php if (empty($books)): ?>
        <p>Zatím nejsou žádné knihy v databázi.</p>
    <?php else: ?>

        <ul>
            <?php foreach ($books as $book): ?>
                <li>
                    <a href="book.php?id=<?= $book['id'] ?>">

                        <img src="<?= Book::getCoverOrDefault($book['cover']) ?>"
                             alt="Obálka knihy"
                             loading="lazy">

                        <div><?= htmlspecialchars($book['title']) ?></div>
                        <div><?= htmlspecialchars($book['author']) ?></div>
                        <div><?= htmlspecialchars($book['year']) ?></div>

                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

</body>
</html>

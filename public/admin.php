<?php
require_once __DIR__ . '/../src/Controller/AdminController.php';
require_once __DIR__ . '/../src/Model/Book.php';

AdminController::requireAdmin();
$books = Book::getAll();
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrace – Knihy</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div>

    <div>

        <div>
            <h1>Administrace knih</h1>
        </div>

        <div>
            <a href="admin_add.php">Přidat knihu</a>
            <a href="logout.php">Odhlásit se</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Název</th>
                    <th>Autor</th>
                    <th>Rok</th>
                    <th>Cena</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['year']) ?></td>
                        <td><?= htmlspecialchars($book['price']) ?> Kč</td>
                        <td>
                            <a href="admin_edit.php?id=<?= $book['id'] ?>">Upravit</a>
                            <button >Smazat</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

</body>
</html>
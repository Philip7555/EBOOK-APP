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
    <script src="js/darkmode.js" defer></script>
    <script src="js/admin.js" defer></script>
</head>

<body class="admin-layout">

    <div class="container">

        <div class="admin-card">

            <div class="page-header">
                <h1 class="admin-title">Administrace knih</h1>

                <button id="darkmode-toggle" class="darkmode-btn">
                    <img src="images/LDM.svg" alt="Dark mode">
                </button>
            </div>

            <div class="admin-actions">
                <a href="admin_add.php" class="btn">Přidat knihu</a>
                <a href="admin_import.php" class="btn">Import z JSON</a>
                <a href="logout.php" class="btn btn-danger">Odhlásit se</a>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Obálka</th>
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
                            <td>
                                <img src="<?= Book::getCoverOrDefault($book['cover']) ?>"
                                    alt="cover"
                                    loading="lazy">
                            </td>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['year']) ?></td>
                            <td><?= htmlspecialchars($book['price']) ?> Kč</td>
                            <td>
                                <a href="admin_edit.php?id=<?= $book['id'] ?>" class="btn">Upravit</a>
                                <button class="btn btn-danger" onclick="confirmDelete(<?= $book['id'] ?>)">Smazat</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form id="deleteForm" method="post" action="admin_delete.php" style="display:none;">
                <input type="hidden" name="id" id="deleteId">
            </form>

        </div>

    </div>

</body>

</html>
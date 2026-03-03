<?php
require_once __DIR__ . '/../src/Controller/AdminController.php';
require_once __DIR__ . '/../src/Model/Book.php';

AdminController::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0 && Book::getById($id)) {
        Book::delete($id);
    }

    header('Location: admin.php');
    exit;
}

header('Location: admin.php');
exit;

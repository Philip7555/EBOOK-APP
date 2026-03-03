<?php
require_once __DIR__ . '/../src/Controller/AdminController.php';
require_once __DIR__ . '/../src/Service/ImportService.php';

AdminController::requireAdmin();

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['import_static'])) {
        $jsonPath = __DIR__ . '/../data/books.json';
        $result = ImportService::importFromJson($jsonPath);
    }

    if (isset($_POST['import_upload']) && isset($_FILES['json_file'])) {
        $tmp = $_FILES['json_file']['tmp_name'];

        if (is_uploaded_file($tmp)) {
            $target = __DIR__ . '/../data/tmp_uploaded.json';
            copy($tmp, $target);

            $result = ImportService::importFromUploadedJson($target);

            @unlink($target);
        } else {
            $result = ['success' => false, 'message' => 'Soubor se nepodařilo nahrát.'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import knih</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/darkmode.js" defer></script>
</head>

<body>

<div>

    <div>

        <div>
            <h1>Import knih</h1>
        </div>

        <?php if ($result): ?>
            <div <?= $result['success'] ? 'success' : 'error' ?>">
                <?= htmlspecialchars($result['message']) ?>
            </div>
        <?php endif; ?>

        <h3>Import ze statického souboru</h3>
        <form method="post">
            <button type="submit" name="import_static">Spustit import</button>
        </form>

        <hr>

        <h3>Import z vlastního JSON</h3>
        <form method="post" enctype="multipart/form-data">
            <label>Nahrát JSON soubor:</label>
            <input type="file" name="json_file" accept=".json" required>

            <div>
                <button type="submit" name="import_upload">Importovat</button>
                <a href="admin.php">Zpět</a>
            </div>
        </form>

    </div>

</div>

</body>
</html>

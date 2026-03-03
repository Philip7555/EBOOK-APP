<?php

require_once __DIR__ . '/../Model/Book.php';

class ImportService
{
    public static function importFromJson(string $path): array
    {
        if (!file_exists($path)) {
            return ['success' => false, 'message' => 'Soubor books.json nebyl nalezen.'];
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!is_array($data)) {
            return ['success' => false, 'message' => 'Soubor JSON má neplatný formát.'];
        }

        return self::processItems($data);
    }

    public static function importFromUploadedJson(string $path): array
    {
        if (!file_exists($path)) {
            return ['success' => false, 'message' => 'Soubor neexistuje.'];
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!isset($data['books']) || !is_array($data['books'])) {
            return ['success' => false, 'message' => 'JSON musí obsahovat pole "books".'];
        }

        return self::processItems($data['books']);
    }

    private static function processItems(array $items): array
    {
        $imported = 0;

        foreach ($items as $item) {

            if (empty($item['title']) || empty($item['author'])) {
                continue;
            }

            if (self::exists($item['title'], $item['author'])) {
                continue;
            }

            $coverPath = null;
            if (!empty($item['cover_url'])) {
                $coverPath = self::downloadCover($item['cover_url']);
            }

            Book::create([
                'title' => $item['title'],
                'author' => $item['author'],
                'genre' => $item['genre'] ?? '',
                'year' => $item['year'] ?? null,
                'price' => $item['price'] ?? null,
                'rating' => $item['rating'] ?? null,
                'description' => $item['description'] ?? '',
                'cover' => $coverPath
            ]);

            $imported++;
        }

        return [
            'success' => true,
            'message' => "Import dokončen. Načteno knih: $imported"
        ];
    }

    private static function exists(string $title, string $author): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM books WHERE title = ? AND author = ?");
        $stmt->execute([$title, $author]);
        return $stmt->fetchColumn() > 0;
    }

    private static function downloadCover(string $url): ?string
    {
        $imageData = @file_get_contents($url);
        if (!$imageData) {
            return null;
        }

        $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $ext = 'jpg';
        }

        $uploadDir = __DIR__ . '/../../html/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $path = $uploadDir . $fileName;

        file_put_contents($path, $imageData);

        return '/uploads/' . $fileName;
    }
}

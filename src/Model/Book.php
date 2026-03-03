<?php

require_once __DIR__ . '/Database.php';

class Book
{
    private static function uploadCover(): ?string
    {
        if (empty($_FILES['cover_file']['name'])) {
            return null;
        }

        if ($_FILES['cover_file']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // MIME detekce přes finfo (bezpečnější než mime_content_type)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $_FILES['cover_file']['tmp_name']);
        finfo_close($finfo);

        $allowedTypes = [
            'image/jpeg' => '.jpg',
            'image/png'  => '.png',
            'image/webp' => '.webp'
        ];

        if (!isset($allowedTypes[$fileType])) {
            return null;
        }

        if ($_FILES['cover_file']['size'] > 5 * 1024 * 1024) {
            return null;
        }

        $ext = $allowedTypes[$fileType];
        $fileName = time() . '_' . bin2hex(random_bytes(8)) . $ext;

        // Dynamická cesta
        $uploadDir = __DIR__ . '/../../html/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['cover_file']['tmp_name'], $targetPath)) {
            return null;
        }

        return '/uploads/' . $fileName;
    }

    public static function getCoverOrDefault(?string $cover): string
    {
        if (!empty($cover)) {
            $path = __DIR__ . '/../../html' . $cover;
            if (is_file($path)) {
                return $cover;
            }
        }

        return '/images/default_cover.jpg';
    }

    public static function getAll(): array
    {
        $db = Database::getConnection();
        return $db->query("SELECT * FROM books ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        return $book ?: null;
    }

    public static function create(array $data): void
    {
        $db = Database::getConnection();

        if (empty($data['title']) || empty($data['author'])) {
            throw new Exception("Název a autor jsou povinné.");
        }

        $coverPath = self::uploadCover();

        if ($coverPath === null && !empty($data['cover'])) {
            $coverPath = $data['cover'];
        }

        $stmt = $db->prepare("
            INSERT INTO books (title, author, genre, year, price, rating, description, cover)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['title'],
            $data['author'],
            $data['genre'] ?? '',
            $data['year'] ?? null,
            $data['price'] ?? null,
            $data['rating'] ?? null,
            $data['description'] ?? '',
            $coverPath
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $db = Database::getConnection();

        if (empty($data['title']) || empty($data['author'])) {
            throw new Exception("Název a autor jsou povinné.");
        }

        $old = self::getById($id);
        if (!$old) {
            throw new Exception("Kniha neexistuje.");
        }

        $newCover = self::uploadCover();

        if ($newCover !== null && !empty($old['cover'])) {
            $oldPath = __DIR__ . '/../../html' . $old['cover'];
            if (is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        if ($newCover === null) {
            $newCover = $data['cover'] ?? $old['cover'];
        }

        $stmt = $db->prepare("
            UPDATE books SET title=?, author=?, genre=?, year=?, price=?, rating=?, description=?, cover=?
            WHERE id=?
        ");

        $stmt->execute([
            $data['title'],
            $data['author'],
            $data['genre'] ?? '',
            $data['year'] ?? null,
            $data['price'] ?? null,
            $data['rating'] ?? null,
            $data['description'] ?? '',
            $newCover,
            $id
        ]);
    }

    public static function delete(int $id): void
    {
        $db = Database::getConnection();

        $book = self::getById($id);

        if ($book && !empty($book['cover'])) {
            $path = __DIR__ . '/../../html' . $book['cover'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $stmt = $db->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$id]);
    }
}
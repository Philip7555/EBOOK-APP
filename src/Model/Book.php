<?php

require_once __DIR__ . '/Database.php';

class Book
{
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

        $stmt = $db->prepare("
            INSERT INTO books (title, author, genre, year, price, rating, description, cover)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['title'] ?? '',
            $data['author'] ?? '',
            $data['genre'] ?? '',
            $data['year'] ?? null,
            $data['price'] ?? null,
            $data['rating'] ?? null,
            $data['description'] ?? '',
            $data['cover'] ?? null
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            UPDATE books SET title=?, author=?, genre=?, year=?, price=?, rating=?, description=?, cover=?
            WHERE id=?
        ");

        $stmt->execute([
            $data['title'] ?? '',
            $data['author'] ?? '',
            $data['genre'] ?? '',
            $data['year'] ?? null,
            $data['price'] ?? null,
            $data['rating'] ?? null,
            $data['description'] ?? '',
            $data['cover'] ?? null,
            $id
        ]);
    }

    public static function delete(int $id): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$id]);
    }
}
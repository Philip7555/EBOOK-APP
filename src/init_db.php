<?php

$db = new PDO('sqlite:/var/www/data/database.sqlite');

$db->exec("
CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    author TEXT NOT NULL,
    genre TEXT,
    year INTEGER,
    price REAL,
    rating REAL,
    description TEXT,
    cover TEXT
);
");

echo 'Databáze byla vytvořena.';

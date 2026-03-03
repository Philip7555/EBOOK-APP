# Katalog e‑knih

Jednoduchá webová aplikace pro správu a zobrazení e‑knih. Obsahuje veřejnou část (výpis, detail, tisk) a administrační část (přihlášení, CRUD, import JSON). Postaveno na PHP 8, SQLite a Dockeru. Styly jsou psané v SASS.

---

## Funkce

### Veřejná část

- Výpis knih (název, autor, rok)
- Detail knihy (anotace, hodnocení, obálka)
- Tisková verze stránky
- Defaultní obálka, pokud chybí

### Admin část

- Přihlášení (heslo v `config.php`)
- Přehled knih
- Přidání, úprava, mazání knih
- Import knih:
  - ze statického `books.json`
  - z vlastního nahraného JSON souboru
- Stažení obálek z URL během importu

---

## Instalace

### 1) Klonování

```bash
git clone https://github.com/Philip7555/EBOOK-APP.git
cd ebook-app
```

### 2) Spuštění Dockeru

```bash
docker compose up -d
```

Aplikace poběží na: http://localhost:8080

### 3) Kompilace SASS

```bash
sass src-scss/style.scss public/css/style.css --watch
```

## Přihlášení pro admin

link na admin page: http://localhost:8000/admin.php

Heslo je v souboru:

- src/config.php

Příklad:

```php
return [
    'admin_password' => 'tajneheslo'
];
```

## Import knih

### Statický import

Soubor:
-data/books.json
formátu:
```json
[
  {
    "title": "Název",
    "author": "Autor",
    "genre": "Žánr",
    "year": 2023,
    "price": 199,
    "rating": 4.5,
    "description": "Popis",
    "cover_url": "https://example.com/cover.jpg"
  }
]
```

V administraci klikni na Spustit import.

### Import vlastního JSON

V administraci nahraj JSON soubor ve formátu:
```json
{
  "books": [
    {
      "title": "Název",
      "author": "Autor",
      "genre": "Žánr",
      "year": 2023,
      "price": 199,
      "rating": 4.5,
      "description": "Popis",
      "cover_url": "https://example.com/cover.jpg"
    }
  ]
}
```

## Struktura projektu

```code
public/             veřejná a admin část
public/uploads/     obálky knih
src/                modely, kontrolery, služby
src-scss/           SASS styly
data/               JSON soubory
docker-compose.yml
Dockerfile
```

## Technologie

- PHP 8 + Apache 2.4 (Docker)
- SQLite
- SASS (SCSS)
- Čistý JavaScript (ES6+)
- OOP struktura (Model / Controller / Service)

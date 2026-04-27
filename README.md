# timcode.ru

Личный сайт. Лендинг с портфолио, кейсами и контактами.

**Стек:** Laravel 13 · PHP 8.3 · SQLite · Vite · league/commonmark

## Запуск

```bash
composer setup
composer dev
```

Откройте `http://localhost:8000`.

## Добавить кейс

Создайте файл `resources/content/cases/<slug>.md`:

```markdown
---
title: Название кейса
summary: Одно предложение — показывается на главной.
stack: [Laravel, PostgreSQL, Vue]
year: 2024
---

Содержимое кейса в Markdown.
```

Кейс автоматически появится на главной и будет доступен по адресу `/cases/<slug>`.

## Деплой

VPS + Nginx + PHP-FPM. Инструкция будет добавлена по готовности.

## Лицензия

MIT

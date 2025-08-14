# RU
# OneCT
OneCT — это будущая свободная CMS под лицензией **BSD 3-Clause**, которая стремится быть простой, но гибкой в управлении.

## Установка OneCT
**Требуемое ПО**:
- Веб-сервер **Apache**
- **PHP** версии **7.2** или выше
- База данных **MySQL** версии **8** или выше

### Основные шаги установки:
1. Импортируйте дамп базы данных из файла `onect.sql`.
2. Настройте подключение к базе данных в файле `include/db.php` и при необходимости измените параметры в `include/config.php`.
3. Войдите в аккаунт **admin@admin.org** и смените пароль (по умолчанию: `admin`).

### Обновление
При обновлении OneCT можно импортировать дамп `new_onect.sql`, содержащий только изменения структуры базы данных со старой версии на новую.

# EN
# OneCT
OneCT is a future free CMS licensed under **BSD 3-Clause**, designed to be simple yet flexible to manage.

## Installing OneCT
**Requirements**:
- **Apache** web server
- **PHP** version **7.2** or higher
- **MySQL** database version **8** or higher

### Installation steps:
1. Import the database dump from the `onect.sql` file.
2. Configure the database connection in `include/db.php` and optionally adjust the settings in `include/config.php`.
3. Log in to the **admin@admin.org** account and change the password (default: `admin`).

### Updating
When updating OneCT, you can import the `new_onect.sql` dump, which contains only the database structure changes from the old version to the new one.

Среда https://github.com/nanoninja/docker-nginx-php-mysql.git
Настройки БД - Db.php
Установка БД - installDB.php
    //GET localhost:8000/tasks/ - Все задачи
    //GET localhost:8000/tasks/{id} - Конкретная задача
Использование через консоль:
PUT/POST/DELETE
    //Добавление
    //bash: curl -X POST -d '{"title":"Название задачи","description":"описание задачи"}' -H "Content-Type: application/json" localhost:8000/tasks/
    //Изменение
    //bash: curl -X PUT -d '{"title":"Новое название задачи","description":"Новое опичание задачи"}' -H "Content-Type: application/json" localhost:8000/tasks/3
    //Удаление
    //bash: curl -X DELETE -d '' -H "Content-Type: application/json" localhost:8000/tasks/3

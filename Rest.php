<?php

require_once 'Api.php';
require_once 'Db.php';

class Rest extends Api
{

    public function allTasks()
    {

        $conn = Database::getConnection();
        $tmp = $conn->prepare("SELECT tasks.*, status.name AS status FROM tasks 
                                        INNER JOIN status
                                               ON tasks.id_status = status.id
                                        WHERE deleted = FALSE");
        $tmp->execute();
        $result = $tmp->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            $json_output = '{"error":"записей нет"}';
        } else {
            $json_output = json_encode($result);
        }
        echo $json_output;
    }

    public function viewTask()
    {
        $id_task = $this->requestUri[0] ?? null;

        if ($id_task) {

            $conn = Database::getConnection();
            $tmp = $conn->prepare("SELECT tasks.*, status.name AS status FROM tasks 
                                            INNER JOIN status
                                                   ON tasks.id_status = status.id
                                            WHERE tasks.id = " . $id_task . " AND deleted = FALSE");
            $tmp->execute();
            $result = $tmp->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                $json_output = '[{"error":"записи нет"}]';
            } else {
                $json_output = json_encode($result);
            }

            echo $json_output;

        }
        else {
            echo 'Не правельный адрес задачи.';
        }
    }

    public function createTask()
    {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);
        /*
         * не требуется такой подход
        $columns = implode(', ', array_keys($data));
        $values =  implode(', ', $data);

        $sql = sprintf(
            'INSERT INTO tasks (%s) VALUES (%s)',
            $columns,
            $values
        );
        print_r($sql);
        */

        $keys = implode('', array_keys($data));

        if ($keys === 'titledescription' || $keys === 'descriptiontitle') {
            $title = $data['title'] ?? null;
            $description = $data['description'] ?? null;
            if ($title && $description) {
                //Статус задачи ставиться автоматически в БД как новый
                Database::getConnection()->query('INSERT INTO tasks (title, description)
                                                                VALUES ("' .$title. '", "' .$description. '");');
                echo ('Запись добавлена');
            } else {
                echo ('Ошибка добавления: Поле title или description не указаны');
            }
        }
        else {
            echo 'Проверьте название полей';
        }


    }

    public function updateTask()
    {
        $id_task = $this->requestUri[0] ?? null;

        if ($id_task) {
            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);

            $keys = implode('', array_keys($data));

            if ($keys === 'titledescription' || $keys === 'descriptiontitle') {

                $title = $data['title'] ?? null;
                $description = $data['description'] ?? null;

                if ($title && $description) {
                    //id status = 2 - Статус "изменен"
                    $sql = 'UPDATE tasks
                        SET title = "' . $title . '", description = "' . $description . '", id_status = 2
                        WHERE id = ' . $id_task . ';';
                    //print_r($sql);
                    Database::getConnection()->query($sql);
                    echo 'Запись обновленна';
                }
                else {
                    echo 'Ошибка обновления: Поле title или description не указаны';
                }

            }
            else {
                echo 'Проверьте название полей';
            }

        } else {
            echo 'Не правельный адрес задачи.';
        }
    }

    public function deleteTask()
    {
        $id_task = $this->requestUri[0] ?? null;

        if ($id_task) {

//            Database::getConnection()->query('DELETE FROM tasks
//                                                       WHERE id = '.$id_task);
//            echo 'Задача удалена';

            Database::getConnection()->query('UPDATE tasks
                        SET id_status = 3, deleted = TRUE
                        WHERE id = ' . $id_task . ';');
            echo 'Задача (скрыта) удалена';
        }
        else {
            echo 'Не правельный адрес задачи.';
        }

    }

}
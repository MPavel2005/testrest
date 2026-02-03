<?php

require_once 'Db.php';

    $sql = "CREATE DATABASE IF NOT EXISTS " . Database::$dbname . ";
            
            USE " . Database::$dbname . "; 
                    
            CREATE TABLE IF NOT EXISTS tasks ( id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            title VARCHAR(100) NOT NULL, 
            description TEXT(500) NOT NULL, 
            id_status  TINYINT(1) DEFAULT '1',
            deleted  BOOLEAN DEFAULT FALSE);
                    
            CREATE TABLE IF NOT EXISTS status ( id TINYINT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(8) UNIQUE);     
               
            INSERT INTO status (name)
            VALUES
                ('Новый'),
                ('Изменен'),
                ('Удален');
            
            INSERT INTO tasks (title, description)
            VALUES
                ('Задача 1','test rest'),
                ('Record title 2', 'fish fish fish fish fish fish fish fish fish fish fish fish fish fish fish fish fish fish fish');                  
             ";


    //print_r($sql);

    try {
        Database::getConnection()->query($sql);
        Database::disconnect();
        echo 'Все хорошо!';
    } catch (Exception $e) {
        echo json_encode(Array('error' => $e->getMessage()));
    }



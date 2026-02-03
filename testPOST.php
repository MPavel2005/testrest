<?php
    //В докере не смог пробится по 8000 порту, локально не стал ставить PHP
    //Проверку осуществляю через консоль
    //Добавление
    //bash: curl -X POST -d '{"title":"NEW Title POST","description":"new text post"}' -H "Content-Type: application/json" localhost:8000/tasks/
    //Изменение
    //bash: curl -X PUT -d '{"title":"NEW Title PUT","description":"new text put"}' -H "Content-Type: application/json" localhost:8000/tasks/3
    //Удаление
    //bash: curl -X DELETE -d '' -H "Content-Type: application/json" localhost:8000/tasks/3

    $url = 'http://localhost:8000/tasks';

    $data = array(
        'title' => 'New tasks',
        'description' => 'POST POST POST POST POST POST POST POST POST POST '
    );

    $json_data = json_encode($data);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-HTTP-Method-Override: POST',
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
    ));

    $response = curl_exec($ch);

    if ($response === false) {
        die('Ошибка: ' . curl_error($ch));
    }

    curl_close($ch);

    $response_data = json_decode($response, true);

    echo "Ответ: ";
    print_r($response_data);
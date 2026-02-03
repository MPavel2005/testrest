<?php

require_once 'Rest.php';

try {
    $api = new Rest();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

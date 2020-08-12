<?php
    header('Content-Type: application/json');
    include $_SERVER['DOCUMENT_ROOT']."/test-code/config.php";

    echo json_encode($test_class->selectAccountNames($_POST));
?>
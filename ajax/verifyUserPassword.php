<?php
    header('Content-Type: application/json');
    include $_SERVER['DOCUMENT_ROOT']."/test-code/config.php";

    $encryptedPassword = $test_class->selectUserPassword($_POST)['password'];
    echo json_encode(array("success"=>true, "verification"=>password_verify($_POST['password'], $encryptedPassword)));
?>
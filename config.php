<?php
	//phpinfo();
	
	//Class files
	include $_SERVER['DOCUMENT_ROOT']."/test-code/class/test-class.php";
	$test_class = new test_class;

	//Variables
	$test_class -> conn = sqlsrv_connect("ADZS_ONLINE-PC1", array("Database"=>"testDatabase"));
?>
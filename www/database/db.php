<?php

	#  https://www.w3schools.com/php/php_mysql_select.asp

	// phần này của docker
    $host = 'mysql-server'; // tên mysql server
    $user = 'root';
    $pass = 'root';
    $db = 'cuoiky'; // tên databse

    define('HOST','mysql-server');
    define('USER','root');
    define('PASSWORD','root');
    define('DB','cuoiky');
	
	// phần này của host chạy trên xampp
	/* $host = '127.0.0.1'; // tên mysql server
    $user = 'root';
    $pass = ''; // mật khẩu
    $db = 'cuoiky'; // tên databse*/

    /* $conn = new mysqli($host, $user, $pass, $db); 

    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die('Không thể kết nối database: ' . $conn->connect_error);
    } */

    function open_database(){
        $conn = new mysqli(HOST,USER,PASSWORD,DB);
        mysqli_set_charset($conn, 'UTF8');
        if ($conn -> connect_error){
            die('Connect error:' .$conn->connect_error);
        }
        return $conn;
    }

?>

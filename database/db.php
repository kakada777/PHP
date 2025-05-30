<?php
    $servername = "localhost";
    $username = "your_user";
    $password = "your_password";
    $dbname = "your_db_name";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->query("SET @num := 0;");
    $conn->query("UPDATE products SET id = @num := (@num + 1);");
    $conn->query("ALTER TABLE products AUTO_INCREMENT = 1;");

?>

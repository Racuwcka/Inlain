<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Database</title>
</head>
<body>

<?php
    $servername = 'localhost';
    $username = 'root';
    $charset = 'utf8';
    $password = '';
    $dbname = 'myDB6';

    // Create connection
    $link = new mysqli($servername, $username, $password);
    // Check connection
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }
    // sql to create table
    $sql = "CREATE DATABASE " . $dbname;

    if ($link->query($sql) === TRUE) {
        echo "Database " . $dbname . " created successfully" . "<br>";
    } else {
        echo "Error creating database: " . $link->error;
    }
    $link->close();

    $link = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }
    if (!$link->set_charset($charset)) {
        printf("Ошибка при загрузке набора символов utf8: %s\n", $link->error);
    } else {
        printf("Текущий набор символов: %s\n", $link->character_set_name()) . "<br>";
    }

    $sql_posts = "CREATE TABLE IF NOT EXISTS Posts (
        userId INT NOT NULL,
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        body TEXT NOT NULL
        )";
    $sql_comments = "CREATE TABLE IF NOT EXISTS Comments (
        postId INT NOT NULL,
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(50) NOT NULL,
        body TEXT NOT NULL
        )";

    $tables = [$sql_posts, $sql_comments];
    $errors = [];

    foreach($tables as $k => $sql){
        $query = @$link->query($sql);
        if(!$query)
            $errors[] = "Table $k : Creation failed ($link->error)";
        else
            $errors[] = "Table $k : Creation done";
    }

    foreach($errors as $msg) {
        echo "$msg <br>";
    }
    $link->close();
?>
</body>
</html>

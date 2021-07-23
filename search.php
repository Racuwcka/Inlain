<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
</head>
<body>
<?php
    $servername = 'localhost';
    $username = 'root';
    $charset = 'utf8';
    $password = '';
    $dbname = 'mydb6';
    $search = trim($_POST['name']);

    $link = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    $sql = "SELECT * FROM comments WHERE body LIKE '%$search%' ";
    $row = [];
    if ($result = $link->query($sql)) {

        while ($row[] = $result->fetch_assoc()) {

        }
        $result->free();
    }
    print('<pre>');
    print(json_encode($row, JSON_PRETTY_PRINT));
    print('</pre>');
    $link->close();
?>
</body>
</html>

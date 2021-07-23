<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert in Database</title>
</head>
<body>

<?php
    $urlPosts = 'https://jsonplaceholder.typicode.com/posts';
    $urlComments = 'https://jsonplaceholder.typicode.com/comments';

    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL,$urlPosts);
    curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    $result1 = curl_exec($ch1);
    curl_close ($ch1);
    $infoPosts = json_decode($result1, true);

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL,$urlComments);
    curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    $result2 = curl_exec($ch2);
    curl_close ($ch2);
    $infoComments = json_decode($result2, true);

//    print('<pre>');
//    print_r($infoComments);
//    print('</pre>');

    $servername = 'localhost';
    $username = 'root';
    $charset = 'utf8';
    $password = '';
    $dbname = 'mydb6';

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

    $sqlPosts = [];
    $sqlComments = [];
    foreach ($infoPosts as $item => $value) {
        $sqlPosts[] = "INSERT INTO Posts (userId, id, title, body)
                VALUES ('". $value['userId']."','". $value['id']."','". $value['title']."','". $value['body']."')";
    }
    $stringPosts = $value['id'];
    unset($item);
    foreach ($infoComments as $item => $value) {
        $sqlComments[] = "INSERT INTO Comments (postId, id, name, email, body)
                    VALUES ('". $value['postId']."','". $value['id']."','". $value['name']."','". $value['email']."','". $value['body']."')";
    }
    $stringComments = $value['id'];
    unset($item);

    foreach($sqlPosts as $item => $value){
        $queryPosts = @$link->query($value);
        if(!$queryPosts)
            $errors[] = "Table $item : Creation failed ($link->error)";
        else
            $errors[] = "Table $item : Creation done";
    }
    unset($item);
    foreach($errors as $msg) {
        echo "$msg <br>";
    }
    unset($msg);

    foreach($sqlComments as $item => $value){
        $queryComments = @$link->query($value);
        if(!$queryComments)
            $errors[] = "Table $item : Creation failed ($link->error)";
        else
            $errors[] = "Table $item : Creation done";
    }
    unset($item);
    foreach($errors as $msg) {
        echo "$msg <br>";
    }
    unset($msg);
    $link->close();

    echo ("<script>console.log('Загружено строк постов: ".$stringPosts."')</script>");
    echo ("<script>console.log('Загружено строк комментариев: ".$stringComments."')</script>");
?>

</body>
</html>

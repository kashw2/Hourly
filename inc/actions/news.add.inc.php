<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
    !empty($_POST['author'])
&&  !empty($_POST['title'])
&&  !empty($_POST['content'])
    ) {

    $Statement = mysqli_prepare($conn, '
    INSERT INTO
    hourly.news (
    hourly.news.id,
    hourly.news.author,
    hourly.news.date,
    hourly.news.title,
    hourly.news.content
    ) VALUES (
    DEFAULT,
    ?,
    ?,
    ?,
    ?
    );
    ');

    mysqli_stmt_bind_param($Statement,
    'ssss',
    $_POST['author'],
    date('y/m/d'),
    $_POST['title'],
    $_POST['content']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
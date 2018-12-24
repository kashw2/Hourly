<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(!empty($_POST['newsid'])) {

    $Statement = mysqli_prepare($conn, '
    DELETE FROM hourly.news
    WHERE hourly.news.id = ?;
    ');

    mysqli_stmt_bind_param($Statement, 
    'i',
    $_POST['newsid']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
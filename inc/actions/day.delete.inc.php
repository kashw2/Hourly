<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(!empty($_POST['day'])) {

    $Statement = mysqli_prepare($conn, '
    DELETE FROM hourly.days
    WHERE hourly.days.dayname = ?;
    ');

    mysqli_stmt_bind_param($Statement, 
    's',
    $_POST['day']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
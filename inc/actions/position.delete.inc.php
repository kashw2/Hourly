<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(!empty($_POST['position'])) {

    $Statement = mysqli_prepare($conn, '
    DELETE FROM hourly.positions
    WHERE hourly.positions.position = ?;
    ');

    mysqli_stmt_bind_param($Statement, 
    's',
    $_POST['position']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
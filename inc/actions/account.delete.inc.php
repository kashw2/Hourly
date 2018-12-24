<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(!empty($_POST['account'])) {

    $Statement = mysqli_prepare($conn, '
    DELETE FROM hourly.accounts
    WHERE hourly.accounts.username = ?;
    ');

    mysqli_stmt_bind_param($Statement, 
    's',
    $_POST['account']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
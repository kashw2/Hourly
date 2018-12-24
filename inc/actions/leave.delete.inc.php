<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
    !empty($_POST['start'])
&& !empty($_POST['end'])
) {

    $Statement = mysqli_prepare($conn, '
    DELETE FROM hourly.leave
    WHERE hourly.leave.start = ? AND hourly.leave.end = ?;
    ');

    mysqli_stmt_bind_param($Statement, 
    'ss',
    $_POST['start'],
    $_POST['end']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
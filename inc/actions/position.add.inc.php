<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
    !empty($_POST['position'])
&&  !empty($_POST['admin'])
    ) {

    switch($_POST['admin']) {
        case 'on':
            $_POST['admin'] = 1;
        break;
        case 'off':
            $_POST['admin'] = 0;
        break;
        default:
            $_POST['admin'] = 0;
    }

    $Statement = mysqli_prepare($conn, '
    INSERT INTO
    hourly.positions (
    hourly.positions.id,
    hourly.positions.position,
    hourly.positions.admin
    ) VALUES (
    DEFAULT,
    ?,
    ?
    );
    ');

    mysqli_stmt_bind_param($Statement,
    'ss',
    $_POST['position'],
    $_POST['admin']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
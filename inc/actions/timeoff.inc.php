<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
!empty($_POST['start'])
&&  !empty($_POST['end'])
&&  !empty($_POST['reason'])
&&  !empty($_POST['details'])
) {

    $Statement = mysqli_prepare($conn, '
    INSERT INTO hourly.leave (
    hourly.leave.id,
    hourly.leave.employeeid,
    hourly.leave.start,
    hourly.leave.end,
    hourly.leave.reason,
    hourly.leave.details
    ) VALUES (
    DEFAULT,
    (
        SELECT
        hourly.accounts.id
        FROM hourly.accounts
        WHERE hourly.accounts.username = ?
    ),
    ?,
    ?,
    ?,
    ?
    );
    ');

    mysqli_stmt_bind_param($Statement,
    'sssss',
    $_SESSION['User']['Username'],
    $_POST['start'],
    $_POST['end'],
    $_POST['reason'],
    $_POST['details']
    );

    mysqli_stmt_execute($Statement);

    if(mysqli_error($conn)) {

        $_SESSION['Error'] = "Error";

        header('Location: ../../timeoff.php');

    } else {

        header('Location: ../../home.php');

    }

} else {

    $_SESSION['Error'] = "Error: Input fields empty";

    header('Location: ../../timeoff.php');

}

?>
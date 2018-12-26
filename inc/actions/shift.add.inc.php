<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
    !empty($_POST['employee'])
&&  !empty($_POST['day'])
&&  !empty($_POST['location'])
&&  !empty($_POST['start'])
&&  !empty($_POST['finish'])
) {

    // First we create the shift
    $Statement = mysqli_prepare($conn, '
    INSERT INTO
    hourly.shifts (
    hourly.shifts.id,
    hourly.shifts.dayid,
    hourly.shifts.start,
    hourly.shifts.end,
    hourly.shifts.location
    ) VALUES (
    DEFAULT,
    (
        SELECT
        hourly.days.id
        FROM hourly.days
        WHERE hourly.days.dayname = ?
    ),
    ?,
    ?,
    ?
    );
    ');

    mysqli_stmt_bind_param($Statement,
    'ssss',
    $_POST['day'],
    $_POST['start'],
    $_POST['finish'],
    $_POST['location']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

    // Now we can roster the employee

    $Statement = mysqli_prepare($conn, '
    INSERT INTO
    hourly.roster (
    hourly.roster.id,
    hourly.roster.employeeid,
    hourly.roster.shiftid
    ) VALUES (
    DEFAULT,
    (
        SELECT
        hourly.accounts.id
        FROM hourly.accounts
        WHERE hourly.accounts.username = ?
    ),
    (
        SELECT
        hourly.shifts.id
        FROM hourly.shifts
        WHERE hourly.shifts.dayid = (
            SELECT
            hourly.days.id
            FROM hourly.days
            WHERE hourly.days.dayname = ?
        ) 
        AND hourly.shifts.start = ?
        AND hourly.shifts.end = ?
        AND hourly.shifts.location = ?
    )
    );
    ');

    mysqli_stmt_bind_param($Statement,
    'sssss',
    $_POST['employee'],
    $_POST['day'],
    $_POST['start'],
    $_POST['finish'],
    $_POST['location']
    );

    mysqli_stmt_execute($Statement);

    if(mysqli_error($conn)) {

        $_SESSION['Error'] = 'Error';

        header('Location: ../../timetable.php');

    } else {

        header('Location: ../../roster.php');

    }

} else {

    $_SESSION['Error'] = "Error: Input field empty.";

    header('Location: ../../timetable.php');

}

?>
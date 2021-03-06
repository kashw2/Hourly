<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(!empty($_POST['username'] && !empty($_POST['password']))) {

    $Statement = mysqli_prepare($conn, '
    SELECT
    hourly.accounts.username
    FROM hourly.accounts
    WHERE hourly.accounts.username = ? OR hourly.accounts.email = ?
    AND hourly.accounts.password LIKE(?);
    ');

    mysqli_stmt_bind_param($Statement, 
    'sss',
    $_POST['username'],
    $_POST['username'],
    md5($_POST['password'])
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_bind_result($Statement, $Result['username']);

    mysqli_stmt_fetch($Statement);

    mysqli_stmt_close($Statement);

    if(!empty($Result['username'])) {

        // The user has entered the correct information however we now need to update their unique token

        // First we must check that they have a token
        
        $Statement = mysqli_prepare($conn, '
        SELECT
        COUNT(hourly.sessions.token),
        hourly.sessions.token
        FROM hourly.sessions
        WHERE hourly.sessions.userid = (
            SELECT
            hourly.accounts.id
            FROM hourly.accounts
            WHERE hourly.accounts.username = ? OR hourly.accounts.email = ?
        );
        ');

        mysqli_stmt_bind_param($Statement,
        'ss',
        $_POST['username'],
        $_POST['username']
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, 
        $Result['count'], 
        $Result['token']
        );

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        if($Result['count'] < 1) {

            $Statement = mysqli_prepare($conn, '
            INSERT INTO hourly.sessions (
            hourly.sessions.id,
            hourly.sessions.userid,
            hourly.sessions.token
            ) VALUES (
            DEFAULT,
            (
                SELECT
                hourly.accounts.id
                FROM hourly.accounts
                WHERE hourly.accounts.username = ? OR hourly.accounts.email = ?
            ),
            ?
            );
            ');

            mysqli_stmt_bind_param($Statement,
            'sss',
            $_POST['username'],
            $_POST['username'],
            session_id()
            );

            mysqli_stmt_execute($Statement);

            mysqli_stmt_close($Statement);

        }

        if($Result['token'] != session_id()) {

            $Statement = mysqli_prepare($conn, '
            UPDATE hourly.sessions
            SET hourly.sessions.token = ?
            WHERE hourly.sessions.userid = (
                SELECT 
                hourly.accounts.id
                FROM hourly.accounts
                WHERE hourly.accounts.username = ? OR hourly.accounts.email = ?
            );
            ');

            mysqli_stmt_bind_param($Statement,
            'sss',
            session_id(),
            $_POST['username'],
            $_POST['username']
            );

            mysqli_stmt_execute($Statement);

            mysqli_stmt_close($Statement);

        }

        header('Location: ../../home.php');

    } else {

        $_SESSION['Error'] = "Error: Username or Password incorrect.";

        header('Location: ../../login.php');

    }

} else {

    $_SESSION['Error'] = "Error: Input field empty.";

    header('Location: ../../login.php');

}

?>
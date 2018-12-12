<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
    !empty($_POST['username'])
&&  !empty($_POST['password'])
) {

    $Statement = mysqli_prepare($conn, '
    SELECT
    COUNT(hourly.accounts.username)
    FROM hourly.accounts
    WHERE hourly.accounts.username = ?;
    ');

    mysqli_stmt_bind_param($Statement,
    's',
    $_POST['username']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_bind_result($Statement, $Result['count']);

    mysqli_stmt_fetch($Statement);

    mysqli_stmt_close($Statement);

    if($Result['count'] > 0) {

        $_SESSION['Error'] = "Error: Account already exists.";

        header('Location: ../../setup.php?token=' . session_id());

    } else {

        $Statement = mysqli_prepare($conn, '
        SELECT
        COUNT(hourly.accounts.email)
        FROM hourly.accounts
        WHERE hourly.accounts.email = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $_SESSION['User']['Email']
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result['count']);

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        if($Result['count'] > 0) {

            $_SESSION['Error'] = "Error: Account already exists.";

            header('Location: ../../setup.php?token=' . session_id());

        } else {

            $Statement = mysqli_prepare($conn, '
            SELECT
            COUNT(hourly.accounts.company)
            FROM hourly.accounts
            WHERE hourly.accounts.company = ?;
            ');

            mysqli_stmt_bind_param($Statement,
            's',
            $_SESSION['User']['Company']
            );

            mysqli_stmt_execute($Statement);

            mysqli_stmt_bind_result($Statement, $Result['count']);

            mysqli_stmt_fetch($Statement);

            mysqli_stmt_close($Statement);

            if($Result['count'] > 0) {

                $_SESSION['Error'] = "Error: This company already has a registrant.";

                header('Location: ../../setup.php?token=' . session_id());

            } else {

                $Statement = mysqli_prepare($conn, '
                INSERT INTO
                hourly.accounts (
                hourly.accounts.id,
                hourly.accounts.username,
                hourly.accounts.password,
                hourly.accounts.email,
                hourly.accounts.company,
                hourly.accounts.positionid
                ) VALUES (
                DEFAULT,
                ?,
                ?,
                ?,
                ?,
                ?
                )
                ');

                mysqli_stmt_bind_param($Statement,
                'sssss',
                $_POST['username'],
                md5($_POST['password']),
                $_SESSION['User']['Email'],
                $_SESSION['User']['Company'],
                $_SESSION['User']['Position']
                );

                mysqli_stmt_execute($Statement);

                if(mysqli_error($conn)) {

                    $_SESSION['Error'] = 'Error';

                    header('Location: ../../setup.php?token=' . session_id());

                } else {

                    unset($_SESSION['User']);

                    header('Location: ../../home.php');

                }

            }

        }

    }

} else {

    $Statement = mysqli_prepare($conn, '
    SELECT
    COUNT(hourly.accounts.username)
    FROM hourly.accounts
    WHERE hourly.accounts.username = ?;
    ');

    mysqli_stmt_bind_param($Statement,
    's',
    $_POST['username']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_bind_result($Statement, $Result['count']);

    mysqli_stmt_fetch($Statement);

    mysqli_stmt_close($Statement);

    if($Result['count'] > 0) {

        $_SESSION['Error'] = "Error: Account already exists.";

        header('Location: ../../setup.php?token=' . session_id());

    } else {

        $Statement = mysqli_prepare($conn, '
        SELECT
        COUNT(hourly.accounts.email)
        FROM hourly.accounts
        WHERE hourly.accounts.email = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $_SESSION['User']['Email']
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result['count']);

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        if($Result['count'] > 0) {

            $_SESSION['Error'] = "Error: Account already exists.";

            header('Location: ../../setup.php?token=' . session_id());

        } else {

            if(
                isset($_POST['username'])
            &&  !empty($_POST['username'])
            ) {

                if(
                    isset($_POST['autogen'])
                &&  !empty($_POST['autogen'])
                &&  $_POST['autogen'] == "on"
                ) {

                    $Statement = mysqli_prepare($conn, '
                    SELECT
                    COUNT(hourly.accounts.company)
                    FROM hourly.accounts
                    WHERE hourly.accounts.company = ?;
                    ');

                    mysqli_stmt_bind_param($Statement,
                    's',
                    $_SESSION['User']['Company']
                    );

                    mysqli_stmt_execute($Statement);

                    mysqli_stmt_bind_result($Statement, $Result['count']);

                    mysqli_stmt_fetch($Statement);

                    mysqli_stmt_close($Statement);

                    if($Result['count'] > 0) {

                        $_SESSION['Error'] = "Error: This company already has a registrant.";

                        header('Location: ../../setup.php?token=' . session_id());

                    } else {

                        /*
                        To avoid a new time() being generated on a different second
                        and to avoid sync issues within the modal, view and controller
                        we will store the time statically in a variable.
                        */
                        $Time = time();

                        $Password = substr(hash("md5", $Time), 0, 8);

                        $Statement = mysqli_prepare($conn, '
                        INSERT INTO
                        hourly.accounts (
                        hourly.accounts.id,
                        hourly.accounts.username,
                        hourly.accounts.password,
                        hourly.accounts.email,
                        hourly.accounts.company,
                        hourly.accounts.positionid
                        ) VALUES (
                        DEFAULT,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?
                        )
                        ');

                        mysqli_stmt_bind_param($Statement,
                        'sssss',
                        $_POST['username'],
                        $Password,
                        $_SESSION['User']['Email'],
                        $_SESSION['User']['Company'],
                        $_SESSION['User']['Position']
                        );

                        mysqli_stmt_execute($Statement);

                        if(mysqli_error($conn)) {

                            $_SESSION['Error'] = 'Error';

                            header('Location: ../../setup.php?token=' . session_id());

                        } else {

                            unset($_SESSION['User']);

                            header('Location: ../../home.php');

                        }

                    }

                }

            } else {

                $_SESSION['Error'] = "Error: Input fields empty";

                header('Location: ../../setup.php?token=' . session_id());

            }

        }

    }

}

?>
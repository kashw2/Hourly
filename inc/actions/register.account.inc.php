<?php

ob_start();

chdir('../../');

require_once('mysql.php');
require_once('inc/classes/errors.class.inc.php');

session_start();

$RegError = new RegistrationError;

if(
    isset($_POST['username'])
&&  !empty($_POST['username'])
&&  isset($_POST['password'])
&&  !empty($_POST['password'])
) {

    if($RegError->checkAccount($conn, $_POST['username']) > 0) {

        $_SESSION['Error'] = "Error: Account already exists.";

        header('Location: ../../setup.php?token=' . session_id());

        die();

    } else {

        if($RegError->checkEmail($conn, $_SESSION['Email']) > 0) {

            $_SESSION['Error'] = "Error: Account already exists.";

            header('Location: ../../setup.php?token=' . session_id());

            die();

        } else {

            if($RegError->checkRegistrantCompany($conn, $_SESSION['User']['Company']) > 0) {

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
                    hourly.accounts.position
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

                    die();

                } else {

                    header('Location: ../../home.php');

                    unset($_SESSION['Email']);

                }

                die();

            }

        }

    }

} else {

    if($RegError->checkAccount($conn, $_POST['username']) > 0) {

        $_SESSION['Error'] = "Error: Account already exists.";

        header('Location: ../../setup.php?token=' . session_id());

        die();

    } else {

        if($RegError->checkEmail($conn, $_SESSION['Email']) > 0) {

            $_SESSION['Error'] = "Error: Account already exists.";

            header('Location: ../../setup.php?token=' . session_id());

            die();

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

                    if($RegError->checkRegistrantCompany($conn, $_SESSION['User']['Company']) > 0) {

                        $_SESSION['Error'] = "Error: This company already has a registrant.";

                        header('Location: ../../setup.php?token=' . session_id());

                    } else {

                        $Password = substr(hash("md5", time()), 0, 8);

                        $Statement = mysqli_prepare($conn, '
                        INSERT INTO
                        hourly.accounts (
                            hourly.accounts.id,
                            hourly.accounts.username,
                            hourly.accounts.password,
                            hourly.accounts.email,
                            hourly.accounts.company,
                            hourly.accounts.position
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

                            die();

                        } else {

                            header('Location: ../../home.php');

                            unset($_SESSION['Email']);

                        }

                        die();

                    }

                }

            } else {

                $_SESSION['Error'] = "Error: Input fields empty";

                header('Location: ../../setup.php?token=' . session_id());

                die();

            }

        }

    }

}

?>
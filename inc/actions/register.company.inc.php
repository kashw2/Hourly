<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
!empty($_POST['companyname'])
&&  !empty($_POST['ceo'])
&&  !empty($_POST['liability'])
&&  !empty($_POST['state'])
&&  !empty($_POST['businessaddress'])
&&  !empty($_POST['firstname'])
&&  !empty($_POST['lastname'])
&&  !empty($_POST['companyposition'])
&&  !empty($_POST['email'])
) {

    $Statement = mysqli_prepare($conn, '
    SELECT
    COUNT(hourly.companies.name)
    FROM hourly.companies
    WHERE hourly.companies.name = ?;
    ');

    mysqli_stmt_bind_param($Statement,
    's',
    $_POST['companyname']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_bind_result($Statement, 
    $Result['count']
    );

    mysqli_stmt_fetch($Statement);

    mysqli_stmt_close($Statement);

    if($Result['count'] < 1) {

        if(!empty($_POST['parentcompany'])) {

            $Statement = mysqli_prepare($conn, '
            INSERT INTO 
            hourly.companies (
            hourly.companies.id,
            hourly.companies.name,
            hourly.companies.ceo,
            hourly.companies.liability,
            hourly.companies.state,
            hourly.companies.businessaddress,
            hourly.companies.parentcompany,
            hourly.companies.registrarfirstname,
            hourly.companies.registrarlastname,
            hourly.companies.registrarcompanyposition,
            hourly.companies.registraremail,
            hourly.companies.creationdate
            ) VALUES (
            DEFAULT,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            DEFAULT
            );
            ');

            mysqli_stmt_bind_param($Statement,
            "ssssssssss",
            $_POST['companyname'],
            $_POST['ceo'],
            $_POST['liability'],
            $_POST['state'],
            $_POST['businessaddress'],
            $_POST['parentcompany'],
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['companyposition'],
            $_POST['email']
            );

            mysqli_stmt_execute($Statement);

            mysqli_stmt_close($Statement);

        } else {

            $Statement = mysqli_prepare($conn, '
            INSERT INTO hourly.companies (
            hourly.companies.id,
            hourly.companies.name,
            hourly.companies.ceo,
            hourly.companies.liability,
            hourly.companies.state,
            hourly.companies.businessaddress,
            hourly.companies.parentcompany,
            hourly.companies.registrarfirstname,
            hourly.companies.registrarlastname,
            hourly.companies.registrarcompanyposition,
            hourly.companies.registraremail,
            hourly.companies.creationdate
            ) VALUES (
            DEFAULT,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            DEFAULT
            );
            ');

            mysqli_stmt_bind_param($Statement,
            "sssssssss",
            $_POST['companyname'],
            $_POST['ceo'],
            $_POST['liability'],
            $_POST['state'],
            $_POST['businessaddress'],
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['companyposition'],
            $_POST['email']
            );

            mysqli_stmt_execute($Statement);

            mysqli_stmt_close($Statement);

        }

        $_SESSION['User']['Email'] = $_POST['email'];
        $_SESSION['User']['Company'] = $_POST['companyname'];
        $_SESSION['User']['Position'] = $_POST['companyposition'];

        header('Location: ../../setup.php?token=' . session_id());

        die();

    } else {

        $_SESSION['Error'] = "Error: This company already has a registrant.";

        header('Location: ../../register.php');

    }

} else {

    $_SESSION['Error'] = "Error: Input fields empty";

    header('Location: ../../register.php');

}

?>
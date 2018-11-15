<?php

ob_start();

chdir('../../');

require_once('mysql.php');
require_once('inc/classes/errors.class.inc.php');

session_start();

$RegError = new RegistrationError;

if(
!empty($_POST['companyname'])
&&  isset($_POST['companyname'])
&&  !empty($_POST['ceo'])
&&  isset($_POST['ceo'])
&&  !empty($_POST['liability'])
&&  isset($_POST['liability'])
&&  !empty($_POST['state'])
&&  isset($_POST['state'])
&&  !empty($_POST['businessaddress'])
&&  isset($_POST['businessaddress'])
&&  !empty($_POST['firstname'])
&&  isset($_POST['firstname'])
&&  !empty($_POST['lastname'])
&&  isset($_POST['lastname'])
&&  !empty($_POST['companyposition'])
&&  isset($_POST['companyposition'])
&&  !empty($_POST['email'])
&&  isset($_POST['email'])
) {

    if($RegError->getCompanyName($conn, $_POST['companyname']) == $_POST['companyname']) {

        $_SESSION['Error'] = "Error: Company already registered.";

        header('Location: ../../register.php');

        die();

    } else {

        // Prepare, Bind and Execute the SQL Query

        $Statement = mysqli_prepare($conn, '
        INSERT INTO hourly.companies (
            hourly.companies.id,
            hourly.companies.name,
            hourly.companies.ceo,
            hourly.companies.liability,
            hourly.companies.state,
            hourly.companies.businessaddress,
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

        if(
        !empty($_POST['parentcompany'])
        && isset($_POST['parentcompany'])
        ) {

            $Statement = mysqli_prepare($conn, '
            UPDATE hourly.companies
            SET hourly.companies.parentcompany = ?
            WHERE hourly.companies.name = ?;
            ');

            mysqli_stmt_bind_param($Statement, 
            "ss",
            $_POST['parentcompany'], 
            $_POST['companyname']
            );

            mysqli_stmt_execute($Statement);

        }

        if(
        !empty($_POST['contactph'])
        && isset($_POST['contactph'])
        ) {
        
            $Statement = mysqli_prepare($conn, '
            UPDATE hourly.companies
            SET hourly.companies.registrarph = ?
            WHERE hourly.companies.name = ?;
            ');

            mysqli_stmt_bind_param($Statement, 
            "ss", 
            $_POST['contactph'], 
            $_POST['companyname']
            );

            mysqli_stmt_execute($Statement);

        }

        $_SESSION['User']['Email'] = $_POST['email'];
        $_SESSION['User']['Company'] = $_POST['companyname'];
        $_SESSION['User']['Position'] = $_POST['companyposition'];

        header('Location: ../../setup.php?token=' . session_id());

        die();

    }

} else {

    $_SESSION['Error'] = "Error: Input fields empty";

    header('Location: ../../register.php');

}

?>
<?php

ob_start();

chdir('../../');

require_once('mysql.php');

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

    // Prepare, Bind and Execute the SQL Query

    $STATEMENT = mysqli_prepare($conn, '
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

    mysqli_stmt_bind_param($STATEMENT,
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

    mysqli_stmt_execute($STATEMENT);

    if($STATEMENT = false) {

        mysqli_stmt_error($STATEMENT);

        die();

    }

    if(
    !empty($_POST['parentcompany'])
    && isset($_POST['parentcompany'])
    ) {

        $STATEMENT = mysqli_prepare($conn, '
        UPDATE hourly.companies
        SET hourly.companies.parentcompany = ?
        WHERE hourly.companies.name = ?;
        ');

        mysqli_stmt_bind_param($STATEMENT, "ss", $_POST['parentcompany'], $_POST['companyname']);

        mysqli_stmt_execute($STATEMENT);
    
        if($STATEMENT = false) {

            mysqli_stmt_error($STATEMENT);

            die();

        }

    }

    if(
    !empty($_POST['contactph'])
    && isset($_POST['contactph'])
    ) {
    
        $STATEMENT = mysqli_prepare($conn, '
        UPDATE hourly.companies
        SET hourly.companies.registrarph = ?
        WHERE hourly.companies.name = ?;
        ');

        mysqli_stmt_bind_param($STATEMENT, "ss", $_POST['parentcompany'], $_POST['companyname']);

        mysqli_stmt_execute($STATEMENT);

        if($STATEMENT = false) {

            mysqli_stmt_error($STATEMENT);

            die();

        }

    }

}

?>
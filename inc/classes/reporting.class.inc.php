<?php

/*
This file is accountable for all reporting of errors, success etc
*/

class Reporting {

    public function __construct() {
        echo __CLASS__ . ' class initialised.';
    }

    public function __destruct() {
        echo __CLASS__ . ' class destroyed.';
    }

}

class Login extends Reporting {
    
    public function __construct() {
        echo __CLASS__ . ' class initialised.';
    }

    public function __destruct() {
        echo __CLASS__ . ' class destroyed.';
    }

}

class Registration extends Reporting {

    public function __construct() {
        echo __CLASS__ . ' class initialised.';
    }

    public function __destruct() {
        echo __CLASS__ . ' class destroyed.';
    }

    public static function getCompanyName($Connection, $CompanyName) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.companies.name
        FROM hourly.companies
        WHERE hourly.companies.name = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $CompanyName
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Name);

        mysqli_stmt_fetch($Statement);

        return $Name;

    }

    public static function countRegistrantAccount($Connection, $AccountName) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.username
        FROM hourly.accounts
        WHERE hourly.accounts.username = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $AccountName
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $AccountName);

        $Result = mysqli_stmt_get_result($Statement);

        /*
        At the end of the method the number of results are returned rather than the result itself.
        */
        return $Result['num_rows'];

    }

    public static function countRegistrantEmail($Connection, $AccountEmail) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.email
        FROM hourly.accounts
        WHERE hourly.accounts.email = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $AccountEmail
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $AccountEmail);

        $Result = mysqli_stmt_get_result($Statement);

        /*
        At the end of the method the number of results are returned rather than the result itself.
        */
        return $Result['num_rows'];

    }

    public static function countRegistrantCompany($Connection, $CompanyName) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.company
        FROM hourly.accounts
        WHERE hourly.accounts.company = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $CompanyName
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $CompanyName);

        $Result = mysqli_stmt_get_result($Statement);

        /*
        At the end of the method the number of results are returned rather than the result itself.
        */
        return $Result['num_rows'];
    }

}

?>
<?php

// Error handling via this class file structure. 

class Errors {

    public function __construct() {
        echo __CLASS__ . ' class initialised.';
    }

    public function __destruct() {
        echo __CLASS__ . ' class destroyed.';
    }

}

class LoginError extends Errors {
    
    public function __construct() {
        echo __CLASS__ . ' class initialised.';
    }

    public function __destruct() {
        echo __CLASS__ . ' class destroyed.';
    }

}

class RegistrationError extends Errors {

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

        mysqli_stmt_fetch($Statement);

        /*
        At the end of the method the number of results are returned rather than the result itself.
        */
        return mysqli_num_rows($Result);

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

        mysqli_stmt_fetch($Statement);

        /*
        At the end of the method the number of results are returned rather than the result itself.
        */
        return mysqli_num_rows($Result);

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

        mysqli_stmt_fetch($Statement);

        /*
        At the end of the method the number of results are returned rather than the result itself.
        */
        return mysqli_num_rows($Result);
    }

}

?>
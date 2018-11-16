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

    public static function checkAccount($Connection, $AccountName) {

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

        mysqli_stmt_fetch($Statement);

        return $AccountName;

    }

    public static function checkEmail($Connection, $AccountEmail) {

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

        mysqli_stmt_fetch($Statement);

        return $AccountEmail;

    }

}

?>
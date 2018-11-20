<?php 

/**
 * Authentication class
 * 
 */

class Authentication {

    public function __construct() {
        echo __CLASS__ . ' class initialised.';
    }

    public function __destruct() {
        echo __CLASS__ . ' class destroyed.';
    }

    public function checkTokenUser($Connection) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.username
        FROM hourly.accounts
        WHERE hourly.accounts.id = (
            SELECT
            hourly.sessions.userid
            FROM hourly.sessions
            WHERE hourly.sessions.token = ?
        );
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        session_id()
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result);

        mysqli_stmt_fetch($Statement);

        if($Result == session_id()) {

            $Statement->close();

            header('Location: home.php');

        } 

    }

    public function checkToken($Connection) {

    $Statement = mysqli_prepare($Connection, '
    SELECT
    hourly.sessions.token
    FROM hourly.sessions
    WHERE hourly.sessions.token = ?
    ');

    mysqli_stmt_bind_param($Statement,
    's',
    session_id()
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_bind_result($Statement, $Result);

    mysqli_stmt_fetch($Statement);

    if($Result == session_id()) {

        $Statement->close();

        header('Location: home.php');

    } 

}

}

?>
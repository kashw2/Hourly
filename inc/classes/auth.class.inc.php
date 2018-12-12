<?php 

/**
 * Authentication class
 * 
 */

class Authentication {

    public static function returnUserToken($Connection) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.sessions.token
        FROM hourly.sessions
        WHERE hourly.sessions.token = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        session_id()
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result['token']);

        mysqli_stmt_fetch($Statement);

        return $Result['token'];

    }

    public function getUserByToken($Connection) {

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

        mysqli_stmt_bind_result($Statement, $Result['username']);

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        if(!empty($Result['username'])) {

            $_SESSION['User']['Username'] = $Result['username'];

            return;

        } else {

            header('Location: index.php');

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

            mysqli_stmt_close($Statement);

            self::getUserByToken($Connection);

            header('Location: home.php');

        } else {

            return;

        }

    }

    public function authAdmin($Connection) {

        $Statement = mysqli_prepare($Connection,'
        SELECT
        hourly.positions.position
        FROM hourly.positions
        WHERE hourly.positions.id = (
            SELECT
            hourly.accounts.positionid
            FROM hourly.accounts
            WHERE hourly.accounts.username = ? OR hourly.accounts.username = ?
        );
        ');

        mysqli_stmt_bind_param($Statement,
        'ss',
        $_SESSION['User']['Username'],
        self::getUserByToken($Connection)
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result['Position']);

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        if($Result['Position'] == "Chief Executive Officer")
            return;
        else header('Location: home.php');


    }

}

?>
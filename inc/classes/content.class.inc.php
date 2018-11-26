<?php

/**
 * Content Classs
 */

class Content {

    public function applyHeader($Connection) {

        echo "

            <a href='index.php'>
                <object data='img/materialicon/baseline-alarm_on-24px.svg'></object>
                <h3 id='header-heading'>HOURLY</h3>
            </a>

        ";

        /**
         * Refering to the PHP Notice:
         * PHP Switch statements default to their default case if a variable is not parsed as a condition to the statement
         */

        switch(self::getUserPosition($Connection, $_SESSION['User']['Username'])) {
            case "Chief Executive Officer":

                echo "
                
                    <a id='header-nav-logout' class='nav' href='inc/actions/logout.inc.php'>Logout</a>
                    <a id='header-nav-roster' class='nav' href='roster.php'>Roster</a>
                    <a id='header-nav-admin' class='nav' href='admin.php'>Admin</a>
                    <a id='header-nav-timeoff' class='nav' href='timeoff.php'>Time Off</a>

                ";

            break;
            case "Employee":

                echo "

                    <a id='header-nav-logout' class='nav' href='inc/actions/logout.inc.php'>Logout</a>
                    <a id='header-nav-roster' class='nav' href='roster.php'>Roster</a>
                    <a id='header-nav-timeoff' class='nav' href='timeoff.php'>Time Off</a>

                ";

            break;
            default:

                /**
                 * 
                 * We don't want users who are on a page that doesn't require the user to be logged in to have the same header/access as one who is
                 * This will check the users URL prior to displaying the header
                 * 
                 */

                $Filename = preg_replace('/\/Hourly\//', '', $_SERVER['SCRIPT_NAME']);

                switch($Filename) {
                    case "login.php":

                        return;

                    break;
                    case "register.php":

                        return;

                    break;
                    case "setup.php":

                        return;

                    break;
                    case "index.php":

                        echo "

                            <a id='header-nav-login' class='nav' href='inc/actions/login.inc.php'>Login</a>

                        ";

                    break;
                }

            break;
        }

    }

    public function getUserId($Connection, $Username) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.id
        FROM hourly.accounts
        WHERE hourly.accounts.username = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $Username
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result['userid']);

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        return $Result['userid'];

    }

    public function getUserCompany($Connection, $Company) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.company
        FROM hourly.accounts
        WHERE hourly.accounts.username = ?;
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $Company
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result['company']);

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        return $Result['company'];

    }

    public function getUserPosition($Connection, $Username) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.positions.position
        FROM hourly.positions
        WHERE hourly.positions.id = (
            SELECT
            hourly.accounts.position
            FROM hourly.accounts
            WHERE hourly.accounts.username = ?
        );
        ');

        mysqli_stmt_bind_param($Statement,
        's',
        $Username
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, $Result['position']);

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        return $Result['position'];

    }

    // !FIXME CHECK FUNCTION FOR INFO
    private function getNews($Connection) {

        /**
         * For now this will just have to be regular mysqli_query
         * There's no security risk as it isn't being passed/bound by params
         * This took far too long to get to actually work to be bothered to fix right now
         * !FIXME
         */
        $Statement = mysqli_query($Connection, '
        SELECT
        hourly.news.author,
        hourly.news.date,
        hourly.news.title,
        hourly.news.content
        FROM hourly.news
        ORDER BY hourly.news.date ASC
        LIMIT 3;
        ');

        $Result = mysqli_fetch_array($Statement);

        $i = 0;

        do {

            $Results['author'][$i] = $Result['author'];
            $Results['date'][$i] = $Result['date'];
            $Results['title'][$i] = $Result['title'];
            $Results['content'][$i] = $Result['content'];

            $i++;

        } while($Result = mysqli_fetch_array($Statement));

        return $Results;

    }

    private function getNewsCount($Connection) {

        $Statement = mysqli_prepare($Connection, '
        SELECT
        COUNT(hourly.news.content)
        FROM hourly.news
        ORDER BY hourly.news.date ASC
        LIMIT 3;
        '
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement, 
        $Result['count']
        );

        mysqli_stmt_fetch($Statement);

        mysqli_stmt_close($Statement);

        return $Result['count'];

    }

    public function generateNews($Connection) {

        $News = self::getNews($Connection);

        // Make sure content exists so we don't have the '//' problem
        if(!empty($News['content'])) {

            for($i = 0; $i < self::getNewsCount($Connection); $i++) {

                echo "

                    <div class='news news-container'>
                    
                        <h3 class='news news-title'>" . $News['title'][$i] . "</h3>

                        <p class='news news-date'>" . $News['date'][$i][8] . $News['date'][$i][9] . "/" . $News['date'][$i][5] . $News['date'][$i][6] . "/" . $News['date'][$i][0] . $News['date'][$i][1] . $News['date'][$i][2] . $News['date'][$i][3] . "</p>

                        <h3 class='news news-author'>" . $News['author'][$i] . "</h3>

                        <div class='news news-content-container'>
                        
                            <p class='news news-content'>" . $News['content'][$i] . "</p>

                        </div>

                    </div>

                ";

            }

        }

    }

}

?>
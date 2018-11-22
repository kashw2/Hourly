<?php

/**
 * Content Classs
 */

class Content {

    public function __construct() {
        echo __CLASS__ . ' class initialised.';
    }

    public function __destruct() {
        echo __CLASS__ . ' class destroyed.';
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
        hourly.accounts.position
        FROM hourly.accounts
        WHERE hourly.accounts.username = ?;
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

        // Make sure content exists so we don't have hte '//' problem
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
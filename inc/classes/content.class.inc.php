<?php

/**
 * Content Classs
 */

require_once('auth.class.inc.php');

class Content {

    public function applyHeader($Connection) {

        echo "

            <a href='index.php'>
                <object data='img/materialicon/baseline-alarm_on-24px.svg'></object>
                <h3 id='header-heading'>HOURLY</h3>
            </a>

        ";

        if(Authentication::returnUserToken($Connection) != session_id()) {
        
            if(preg_replace('/\/Hourly\//', '', $_SERVER['SCRIPT_NAME']) == "index.php") {

                echo "

                    <a id='header-nav-login' class='nav' href='inc/actions/login.inc.php'>Login</a>

                ";

            }

            return;

        }

        /**
         * Refering to the PHP Notice:
         * PHP Switch statements default to their default case if a variable is not parsed as a condition to the statement
         */

        switch(Authentication::authAdmin($Connection)) {
            case true:

                echo "
                
                    <a id='header-nav-logout' class='nav' href='inc/actions/logout.inc.php'>Logout</a>
                    <a id='header-nav-roster' class='nav' href='roster.php'>Roster</a>
                    <a id='header-nav-timetable' class='nav' href='timetable.php'>Edit Roster</a>
                    <a id='header-nav-admin' class='nav' href='admin.php'>Admin</a>
                    <a id='header-nav-timeoff' class='nav' href='timeoff.php'>Time Off</a>

                ";

            break;
            case false:

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
            hourly.accounts.positionid
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

                $Date = date_create($News['date'][$i]);

                echo "

                    <div class='news news-container'>
                    
                        <h3 class='news news-title'>" . $News['title'][$i] . "</h3>

                        <p class='news news-date'>" . $Date->format('d/m/y') . "</p>

                        <h3 class='news news-author'>" . $News['author'][$i] . "</h3>

                        <div class='news news-content-container'>
                        
                            <p class='news news-content'>" . $News['content'][$i] . "</p>

                        </div>

                    </div>

                ";

            }

        }

    }

    public function generateDays($Connection) {
        
        // This function echos the same problem as getNews() when querying

        /**
         * For now this will just have to be regular mysqli_query
         * There's no security risk as it isn't being passed/bound by params
         * This took far too long to get to actually work to be bothered to fix right now
         * !FIXME
         */
        $Statement = mysqli_query($Connection, '
        SELECT
        hourly.days.dayname
        FROM hourly.days;
        ');

        $Result = mysqli_fetch_array($Statement);

        echo "
        
            <select id='form-day' class='input' type='text' form='search-form' name='day'>
            <option selected hidden>Day</option>
        
        ";

        do {

            echo "
            
                <option>" . $Result['dayname'] . "</option>

            ";

        } while($Result = mysqli_fetch_array($Statement));

        echo "
            
            </select>
        
        ";

    }

    public function generateEmployees($Connection) {

        // This function echos the same problem as getNews() when querying

        /**
         * For now this will just have to be regular mysqli_query
         * There's no security risk as it isn't being passed/bound by params
         * This took far too long to get to actually work to be bothered to fix right now
         * !FIXME
         */
        $Statement = mysqli_query($Connection, '
        SELECT
        hourly.accounts.username
        FROM hourly.accounts;
        ');

        $Result = mysqli_fetch_array($Statement);

        echo "
        
            <select id='form-employee' class='input' type='text' form='search-form' name='employee'>
            <option selected hidden>Employee</option>
        
        ";

        do {

            echo "
            
                <option>" . $Result['username'] . "</option>

            ";

        } while($Result = mysqli_fetch_array($Statement));

        echo "
            
            </select>
        
        ";

    }

    public function generateLocation($Connection) {

        // This function echos the same problem as getNews() when querying

        /**
         * For now this will just have to be regular mysqli_query
         * There's no security risk as it isn't being passed/bound by params
         * This took far too long to get to actually work to be bothered to fix right now
         * !FIXME
         */
        $Statement = mysqli_query($Connection, '
        SELECT hourly.locations.location
        FROM hourly.locations;
        ');

        $Result = mysqli_fetch_array($Statement);

        echo "
        
            <select id='form-location' class='input' type='text' form='search-form' name='location'>
            <option selected hidden>Location</option>
        
        ";

        do {

            echo "
            
                <option>" . $Result['location'] . "</option>

            ";

        } while($Result = mysqli_fetch_array($Statement));

        echo "
            
            </select>
        
        ";

    }

    public function generateRoster($Connection, ...$Data) {

        /**
         * !FIXME
         * This SQL query will have to be fixed in the future
         * Currently the query doesn't take into account all values from the form
         * 
         */

        $Statement = mysqli_prepare($Connection, '
        SELECT DISTINCT
        hourly.accounts.username AS employee,
        hourly.shifts.start,
        hourly.shifts.end,
        hourly.shifts.location
        FROM hourly.accounts
        INNER JOIN hourly.shifts ON hourly.shifts.id IN (
            SELECT
            hourly.roster.shiftid
            FROM hourly.roster
            WHERE hourly.roster.shiftid = (
                SELECT
                hourly.roster.shiftid
                WHERE hourly.roster.employeeid = (
                    SELECT
                    hourly.accounts.id
                    FROM hourly.accounts
                    WHERE hourly.accounts.username = ?
                ) OR 
                hourly.roster.shiftid = (
                    SELECT
                    hourly.shifts.id
                    FROM hourly.shifts
                    WHERE hourly.shifts.dayid = (
                        SELECT 
                        hourly.days.id
                        FROM hourly.days
                        WHERE hourly.days.dayname = ?
                    )
                ) OR 
                hourly.roster.shiftid IN (
                    SELECT
                    hourly.shifts.id
                    FROM hourly.shifts
                    WHERE hourly.shifts.location = ?
                ) OR 
                hourly.roster.shiftid IN (
                    SELECT
                    hourly.shifts.id
                    FROM hourly.shifts
                    WHERE hourly.shifts.start = ?
                ) OR 
                hourly.roster.shiftid IN (
                    SELECT
                    hourly.shifts.id
                    FROM hourly.shifts
                    WHERE hourly.shifts.end = ?
                )
            )
        );
        ');

        mysqli_stmt_bind_param($Statement,
        "sssss",
        $Data[0],
        $Data[1],
        $Data[2],
        $Data[3],
        $Data[4]
        );

        mysqli_stmt_execute($Statement);

        mysqli_stmt_bind_result($Statement,
        $Result['employee'],
        $Result['start'],
        $Result['end'],
        $Result['location']
        );

        $Fetch = mysqli_stmt_fetch($Statement);

        echo "

            <table>
                <tr>
                    <th>Employee</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Location</th>
                </tr>        

        ";

        do {

            // We do this so that we don't get the current datetime in the start and end fields when there's no shifts
            if(!empty($Result['employee'])) {

                $Result['start'] = date_create($Result['start'])->format('d/m/Y h:i');
                $Result['end'] = date_create($Result['end'])->format('d/m/Y h:i');

                echo "
                
                    <tr>
                        <td>" . $Result['employee'] . "</td>
                        <td>" . $Result['start'] . "</td>
                        <td>" . $Result['end'] . "</td>
                        <td>" . $Result['location'] . "</td>
                    </tr>    
                
                ";

            }

        } while($Fetch = mysqli_stmt_fetch($Statement));

        echo "</table>";

        mysqli_stmt_close($Statement);

    }

    public function generateAdmin($Connection) {

        echo "

            <div id='content-accounts' class='box-container'>

                <p class='window-headings'>Accounts</p>

                <div class='inner-container'>

                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

        ";

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.username,
        hourly.accounts.email,
        hourly.accounts.company,
        hourly.positions.position
        FROM hourly.accounts
        INNER JOIN hourly.positions ON hourly.positions.id = hourly.accounts.positionid
        ');

        mysqli_stmt_bind_result($Statement,
        $Result['username'],
        $Result['email'],
        $Result['company'],
        $Result['positionid']
        );

        mysqli_stmt_execute($Statement);

        $Results = mysqli_stmt_fetch($Statement);

        do {

            echo "

                <tr>
                    <td>" . $Result['username'] . "</td>
                    <td>" . $Result['email'] . "</td>
                    <td>" . $Result['company'] . "</td>
                    <td>" . $Result['positionid'] . "</td>
                    <td id='accounts-edit' class='option edit'>Edit</td>
                    <td id='accounts-delete' class='option delete'>Delete</td>
                </tr>
            
            ";

        } while($Results = mysqli_stmt_fetch($Statement));

        mysqli_stmt_close($Statement);

        echo "

            <tr>
                <td>
                    <input type='text' id='account-username' class='input' placeholder='Username'>
                </td>
                <td>
                    <input type='text' id='account-email' class='input' placeholder='Email'>
                </td>
                <td>
                    <input type='text' id='account-password' class='input' placeholder='Password'>
                </td>
                <td>
                    <select id='account-position' class='input'>
                        <option selecteed hidden>Position</option>

        ";

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.positions.position
        FROM hourly.positions
        ');

        mysqli_stmt_bind_result($Statement, $Result['positions']);

        mysqli_stmt_execute($Statement);

        $Results = mysqli_stmt_fetch($Statement);

        do {

            echo "
            
                <option>" . $Result['positions'] . "</option>

            ";

        } while($Results = mysqli_stmt_fetch($Statement));

        echo "

                                </select>
                            </td>
                            <td></td>
                            <td id='accounts-add' class='option add'>Add</td>
                        </tr>
                    </table>

                </div>

            
            </div>

            <div id='content-days' class='box-container'>

                <p class='window-headings'>Days</p>

                <div class='inner-container'>

                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

        ";

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.days.dayname
        FROM hourly.days
        ');

        mysqli_stmt_bind_result($Statement,
        $Result['day']
        );

        mysqli_stmt_execute($Statement);

        $Results = mysqli_stmt_fetch($Statement);

        do {

            echo "

                <tr>
                    <td>" . $Result['day'] . "</td>
                    <td id='days-delete' class='option delete'>Delete</td>
                </tr>
            
            ";

        } while($Results = mysqli_stmt_fetch($Statement));

        mysqli_stmt_close($Statement);

        echo "

                <tr>
                    <td>
                        <input type='text' id='days-day' class='input' placeholder='Day'>
                    </td>
                    <td id='days-add' class='option add'>Add</td>
                </tr>
                </table>

                </div>
            
            </div>

            <div id='content-leave' class='box-container'>

                <p class='window-headings'>Leave</p>

                <div class='inner-container'>

                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

        ";

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.accounts.username,
        hourly.leave.start,
        hourly.leave.end,
        hourly.leave.reason
        FROM hourly.leave
        INNER JOIN hourly.accounts ON hourly.accounts.id = hourly.leave.employeeid
        ');

        mysqli_stmt_bind_result($Statement,
        $Result['username'],
        $Result['start'],
        $Result['end'],
        $Result['reason']
        );

        mysqli_stmt_execute($Statement);

        $Results = mysqli_stmt_fetch($Statement);

        do {

            $Result['start'] = date_create($Result['start'])->format('d/m/y');
            $Result['end'] = date_create($Result['end'])->format('d/m/y');

            echo "

                <tr>
                    <td>" . $Result['username'] . "</td>
                    <td>" . $Result['start'] . "</td>
                    <td>" . $Result['end'] . "</td>
                    <td>" . $Result['reason'] . "</td>
                    <td id='leave-delete' class='option delete'>Delete</td>
                </tr>
            
            ";

        } while($Results = mysqli_stmt_fetch($Statement));

        mysqli_stmt_close($Statement);

        echo "
        
                    </table>

                </div>
            
            </div>

            <div id='content-locations' class='box-container'>

                <p class='window-headings'>Locations</p>
            
                <div class='inner-container'>

                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>

        ";

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.locations.location
        FROM hourly.locations
        ');

        mysqli_stmt_bind_result($Statement,
        $Result['location']
        );

        mysqli_stmt_execute($Statement);

        $Results = mysqli_stmt_fetch($Statement);

        do {

            echo "

                <tr>
                    <td>" . $Result['location'] . "</td>
                    <td id='location-delete' class='option delete'>Delete</td>
                </tr>
            
            ";

        } while($Results = mysqli_stmt_fetch($Statement));

        mysqli_stmt_close($Statement);

        echo "

                    <tr>
                        <td>
                            <input type='text' id='days-day' class='input' placeholder='Location'>
                        </td>
                        <td id='days-add' class='option add'>Add</td>
                    </tr>
                    </table>
                
                </div>

            </div>

            <div id='content-positions' class='box-container'>

                <p class='window-headings'>Positions</p>
            
                <div class='inner-container'>

                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

        ";

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.positions.position,
        hourly.positions.admin
        FROM hourly.positions
        ');

        mysqli_stmt_bind_result($Statement,
        $Result['position'],
        $Result['admin']
        );

        mysqli_stmt_execute($Statement);

        $Results = mysqli_stmt_fetch($Statement);

        do {

            if($Result['admin'] == 1)
                $Result['admin'] = 'Admin';
            else
                $Result['admin'] = 'N/A';

            echo "

                <tr>
                    <td>" . $Result['position'] . "</td>
                    <td>" . $Result['admin'] . "</td>
                    <td id='positions-delete' class='option delete'>Delete</td>
                </tr>
            
            ";

        } while($Results = mysqli_stmt_fetch($Statement));

        mysqli_stmt_close($Statement);

        echo "
                    <tr>
                        <td>
                            <input type='text' id='positions-day' class='input' placeholder='Position'>
                        </td>
                        <td>
                            <input type='checkbox' id='positions-admin' class='input'>
                        </td>
                        <td id='positions-add' class='option add'>Add</td>
                    </tr>
                    </table>

                </div>

            </div>

            <div id='content-news' class='box-container'>

                <p class='window-headings'>News</p>
            
                <div class='inner-container'>

                    <div id='table-container'>
                    
                        <table>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>

        ";

        $Statement = mysqli_prepare($Connection, '
        SELECT
        hourly.news.id,
        hourly.news.author,
        hourly.news.date,
        hourly.news.title
        FROM hourly.news
        ');

        mysqli_stmt_bind_result($Statement,
        $Result['id'],
        $Result['author'],
        $Result['date'],
        $Result['title']
        );

        mysqli_stmt_execute($Statement);

        $Results = mysqli_stmt_fetch($Statement);

        do {

            // Make sure there's actually a entry/row to display
            if(!empty($Result['id'])) {

                $Result['date'] = date_create($Result['date'])->format('y/m/d');

                echo "

                    <tr>
                        <td>" . $Result['id'] . "</td>
                        <td>" . $Result['author'] . "</td>
                        <td>" . $Result['date'] . "</td>
                        <td>" . $Result['title'] . "</td>
                        <td id='news-edit' class='option edit'>Edit</td>
                        <td id='news-delete' class='option delete'>Delete</td>
                    </tr>
                
                ";

            }

        } while($Results = mysqli_stmt_fetch($Statement));

        mysqli_stmt_close($Statement);

        echo "

                        </table>

                    </div>

                    <div id='post-container'>
                    
                        <input id='news-title' class='input' type='text' placeholder='Title'>

                        <textarea id='news-content' class='input' wrap='soft' placeholder='Content'></textarea>

                        <input id='news-submit' class='input' type='submit' value='Submit'>

                    </div>

                </div>

            </div>
        
        ";
        
    }

}

?>
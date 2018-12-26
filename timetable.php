<?php

ob_start();

session_start();

require_once('mysql.php');
require_once('inc/classes/auth.class.inc.php');
require_once('inc/classes/content.class.inc.php');

$Auth = new Authentication;
$Content = new Content;

$Auth->getUserByToken($conn);

if($Auth->authAdmin($conn) == false)
    header('Location: home.php');

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <title>Hourly - Timetable</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/timetable.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <?php

                $Content->applyHeader($conn);

            ?>
            
        </div>

        <div id='grid-content'>

            <div id='content-shift-container'>

                <h1 id='shift-heading'>Shift Creator</h1>

                <?php

                    if($_SESSION['Error']) {

                        echo '<p id="shift-error">' . $_SESSION['Error'] . '</p>';

                        unset($_SESSION['Error']);

                    }

                ?>

                <form id='shift-form' method='post' action='inc/actions/shift.add.inc.php'>

                    <select id='shift-employee' class='input' type='text' name='employee' form='shift-form'>

                        <option default hidden>Employee</option>

                        <?php

                            $Statement = mysqli_prepare($conn, '
                            SELECT
                            hourly.accounts.username
                            FROM hourly.accounts
                            ');

                            mysqli_stmt_execute($Statement);

                            mysqli_stmt_bind_result($Statement, $Result['employee']);

                            mysqli_stmt_fetch($Statement);

                            do {

                                echo "
                                
                                    <option>" . $Result['employee'] . "</option>

                                ";

                            } while(mysqli_stmt_fetch($Statement));

                        ?>

                    </select>

                    <select id='shift-day' class='input' type='text' name='day' form='shift-form'>

                            <option default hidden>Day</option>

                            <?php

                            $Statement = mysqli_prepare($conn, '
                            SELECT
                            hourly.days.dayname
                            FROM hourly.days
                            ');

                            mysqli_stmt_execute($Statement);

                            mysqli_stmt_bind_result($Statement, $Result['day']);

                            mysqli_stmt_fetch($Statement);

                            do {

                                echo "
                                
                                    <option>" . $Result['day'] . "</option>

                                ";

                            } while(mysqli_stmt_fetch($Statement));

                        ?>

                    </select>

                    <select id='shift-location' class='input' type='text' name='location' form='shift-form'>

                        <option default hidden>Location</option>

                        <?php

                            $Statement = mysqli_prepare($conn, '
                            SELECT
                            hourly.locations.location
                            FROM hourly.locations
                            ');

                            mysqli_stmt_execute($Statement);

                            mysqli_stmt_bind_result($Statement, $Result['location']);

                            mysqli_stmt_fetch($Statement);

                            do {

                                echo "
                                
                                    <option>" . $Result['location'] . "</option>

                                ";

                            } while(mysqli_stmt_fetch($Statement));

                        ?>

                    </select>

                    <input id='shift-start' class='input' type='datetime-local' name='start' form='shift-form' placeholder='Start'>

                    <input id='shift-finish' class='input' type='datetime-local' name='finish' form='shift-form' placeholder='Finish'>

                    <input id='shift-submit' class='input' type='submit' form='shift-form' value='Submit'>

                </form>

            </div>
        
        </div>

    </div>

</body>

</html>
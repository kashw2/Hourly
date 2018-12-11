<?php

ob_start();

session_start();

require_once('mysql.php');
require_once('inc/classes/auth.class.inc.php');
require_once('inc/classes/content.class.inc.php');

$Auth = new Authentication;
$Content = new Content;

$Auth->getUserByToken($conn);

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <title>Hourly - Timeoff</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/timeoff.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <?php

                $Content->applyHeader($conn);

            ?>
            
        </div>

        <div id='grid-content'>

            <div id='content-timeoff-container'>

                <h1 id='timeoff-heading'>Timeoff</h1>

                <?php

                    if($_SESSION['Error']) {

                        echo '<p id="login-error">' . $_SESSION['Error'] . '</p>';

                        unset($_SESSION['Error']);

                    }

                ?>

                <form id='timeoff-form' method='post' action='inc/actions/timeoff.inc.php'>

                    <?php

                        if(!empty($_SESSION['User']['Username'])) {

                            echo "
                            
                                <p id='form-user'>" . $_SESSION['User']['Username'] . "</p>
                            
                            ";

                        }

                    ?>

                    <input id='form-start' class='input' type='date' form='timeoff-form' name='start' placeholder='Leave'>
                    <input id='form-end' class='input' type='date' form='timeoff-form' name='end' placeholder='Return'>

                    <select id='form-reason' class='input' form='timeoff-form' name='reason'>
                        <option selected hidden></option>
                        <option>Illness</option>
                        <option>Family</option>
                        <option>Vacational</option>
                        <option>Leave</option>
                        <option>Other (Please Specify)</option>
                    </select>

                    <textarea id='form-details' class='input' form='timeoff-form' name='details' placeholder='Details...' wrap='soft' maxlength='350'></textarea>

                    <input id='timeoff-submit' type='submit' value='Submit'>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
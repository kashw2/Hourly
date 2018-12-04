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

    <title>Hourly - Roster</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/roster.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <?php

                $Content->applyHeader($conn);

            ?>
            
        </div>

        <div id='grid-content'>

            <div id='content-search-container'>

                <form id='search-form' method='post'>
                    
                    <?php

                        $Content->generateEmployees($conn);

                        $Content->generateDays($conn);

                        $Content->generateLocation($conn);

                    ?>

                    <input id='form-start' class='input' type='text' form='search-form' name='start' placeholder='Clock On'>
                    <input id='form-end' class='input' type='text' form='search-form' name='end' placeholder='Clock Off'>
                    <input id='form-submit' class='input' type='submit' form='search-form' value='Search'>

                </form>
            
            </div>

            <div id='content-table-wrapper'>

                <?php

                    $Content->generateRoster($conn, 
                    $_POST['employee'],
                    $_POST['day'],
                    $_POST['location'],
                    $_POST['start'],
                    $_POST['end']
                    );

                ?>

            </div>

        </div>

    </div>

</body>

</html>
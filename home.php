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

    <title>Hourly - ERMS</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/home.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <?php

                $Content->applyHeader($conn);

            ?>
            
        </div>

        <div id='grid-content'>

            <div id='content-greeting-container'>

                <img id='greeting-avatar' src=<?php echo 'users/' . $Content->getUserId($conn, $_SESSION['User']['Username']) . '/images/avatar.png'; ?> >

                <p id='greeting-intro'>Welcome to Hourly</h1>

                <h2 id='greeting-username' class='greeting user-information'><?php echo $_SESSION['User']['Username']; ?></h2>

                <br>

                <h2 id='greeting-company' class='greeting user-information'><?php echo $Content->getUserCompany($conn, $_SESSION['User']['Username']); ?></h2>

                <br>

                <h2 id='greeting-position' class='greeting user-information'><?php echo $Content->getUserPosition($conn, $_SESSION['User']['Username']); ?></h2>

            </div>

            <div id='content-news-wrapper'>

                <div id='news-piece-container'>
                
                    <?php

                        $Content->generateNews($conn);

                    ?>

                </div>

            </div>
        
        </div>

    </div>

</body>

</html>
<?php

ob_start();

session_start();

require_once('mysql.php');
require_once('inc/classes/auth.class.inc.php');
require_once('inc/classes/content.class.inc.php');

$Auth = new Authentication;
$Content = new Content;

$Auth->checkToken($conn);

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <title>Hourly - ERMS</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/index.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <?php

                $Content->applyHeader($conn);

            ?>
            
        </div>

        <div id='grid-content'>

            <h1 id='content-slogan'>Keeping you on time, ahead of time</h1>

            <a id='content-link-faq' class="footer-links" href='#'>Faq</a>
            <a id='content-link-testimonials' class="footer-links" href='#'>Testimonials</a>
            <a id='content-link-plans' class="footer-links" href='#'>Plans</a>
        
        </div>

    </div>

</body>

</html>
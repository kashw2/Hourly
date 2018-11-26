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

    <title>Hourly - Login</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/login.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <?php

                $Content->applyHeader($conn);

            ?>
            
        </div>

        <div id='grid-content'>

            <div id='content-login-container'>

                <h1 id='login-heading'>Login</h1>

                <?php

                    if($_SESSION['Error']) {

                        echo '<p id="login-error">' . $_SESSION['Error'] . '</p>';

                        unset($_SESSION['Error']);

                    }

                ?>

                <form id='login-form' method='post' action='inc/actions/login.inc.php'>
                
                    <input id='login-username' class='input' type='text' name='username' placeholder='Username:'> 

                    <input id='login-password' class='input' type='password' name='password' placeholder='Password:'> 

                    <input id='login-submit' type='submit' value='Login'>

                    <a id='login-register' href='register.php'>Or Register your Company Here</a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
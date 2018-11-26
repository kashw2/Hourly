<?php

ob_start();

session_start();

require_once('mysql.php');
require_once('inc/classes/auth.class.inc.php');
require_once('inc/classes/content.class.inc.php');

$Auth = new Authentication;
$Content = new Content;

$Auth->checkToken($conn);

if($_GET['token'] != session_id()) {

    header('Location: index.php');

}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <title>Hourly - Setup</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/setup.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <?php

                $Content->applyHeader($conn);

            ?>
            
        </div>

        <div id='grid-content'>

            <h1 id='content-heading'>Welcome to Hourly</h1>

            <p id='content-setup-intro'>Just a few more things before we continue.</p>

            <div id='content-form-container'>

                <p id='container-heading'>Your Account</p>

                <?php

                    if($_SESSION['Error']) {

                        echo '<p id="register-error">' . $_SESSION['Error'] . '</p>';

                        unset($_SESSION['Error']);

                    }

                ?>

                <form id='register-account' method='post' action='inc/actions/register.account.inc.php'>

                    <input id='account-username' class='input' type='text' name='username' placeholder='Username:' form='register-account'>

                    <input id='account-password' class='input' type='password' name='password' placeholder='Password:' form='register-account'>

                    <input id='account-autogen' class='input' type='checkbox' name='autogen' form='register-account'>

                    <p id='account-autogen-placeholder'>Auto Generate Password</p>

                    <input id='account-submit' type='submit' value='Submit' form='register-account'>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
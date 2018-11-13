<?php

ob_start();

session_start();

if($_GET['token'] != session_id()) {

    header('Location: index.php');

}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <title>Hourly - ERMS</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/setup.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <a href="index.php">
                <object data='img/materialicon/baseline-alarm_on-24px.svg'></object>
                <h3 id='header-heading'>HOURLY</h3>
            </a>
            
        </div>

        <div id='grid-content'>

            <h1 id='content-heading'>Welcome to Hourly</h1>

            <p id='content-setup-intro'>Just a few more things before we continue.</p>

            <div id='content-form-container'>

                <p id='container-heading'>Your Account</p>

                <form id='register-account' method='post' action='register.account.inc.php'>

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
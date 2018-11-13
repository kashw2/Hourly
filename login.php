<?php

ob_start();

session_start();

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

            <a href="index.php">
                <object data='img/materialicon/baseline-alarm_on-24px.svg'></object>
                <h3 id='header-heading'>HOURLY</h3>
            </a>
            
        </div>

        <div id='grid-content'>

            <div id='content-login-container'>

                <h1 id='login-heading'>Login</h1>

                <form id='login-form' method='post' action='inc/login.inc.php'>
                
                    <input id='login-username' class='input' type='text' name='username' placeholder='Username:'> 

                    <input id='login-password' class='input' type='password' name='password' placeholder='Password:'> 

                    <input id='login-submit' type='submit' name='submit' value='Login'>

                    <a id='login-register' href='register.php'>Or Register your Company Here</a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
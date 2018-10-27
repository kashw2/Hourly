<?php

ob_start();

session_start();

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <title>Hourly - Register</title>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' type='text/css' href='css/min/globals.min.css'>
    <link rel='stylesheet' type='text/css' href='css/min/register.min.css'>

</head>
<body>

    <div id='grid-container'>
    
        <div id='grid-header'>

            <a href="index.php">
                <object data='img/materialicon/baseline-alarm_on-24px.svg'></object>
                <h3 id='header-heading'>HOURLY</h3>
            </a>

                <a id='header-nav-news' class='nav' href='#'>NEWS</a>
            
                <a id='header-nav-timeoff' class='nav' href='#'>TIME OFF</a>
            
                <a id='header-nav-roster' class='nav' href='#'>ROSTER</a>
            
                <a id='header-nav-employees' class='nav' href='#'>EMPLOYEES</a>
            
                <a id='header-nav-login' class='nav' href='login.php'>LOGIN</a>
            
        </div>

        <div id='grid-content'>

            <div id='content-register-container'>

                <h1 id='register-heading'>Company Register</h1>

                <?php

                    if($_SESSION['Error']) {

                        echo '<p id="register-error">' . $_SESSION['Error'] . '</p>';

                        unset($_SESSION['Error']);

                    }

                ?>

                <form id='register-form' method='post' action='inc/actions/register.company.inc.php'>

                    <input id='register-companyname' class='input' type='text' name='companyname' placeholder='*Company Name:'> 

                    <input id='register-ceo' class='input' type='text' name='ceo' placeholder='*CEO:'> 

                    <input id='register-liability' class='input' type='text' name='liability' placeholder='*Liability:'> 

                    <input id='register-state' class='input' type='text' name='state' placeholder='*State:'> 

                    <input id='register-businessaddress' class='input' type='text' name='businessaddress' placeholder='*Business Address:'> 

                    <input id='register-parentcompany' class='input' type='text' name='parentcompany' placeholder='Parent Company:'>

                    <input id='register-firstname' class='input' type='text' name='firstname' placeholder='*First Name:'> 

                    <input id='register-lastname' class='input' type='text' name='lastname' placeholder='*Last Name:'> 

                    <input id='register-companyposition' class='input' type='text' name='companyposition' placeholder='*Company Position:'> 

                    <input id='register-contactph' class='input' type='text' name='contactph' placeholder='Contact Ph:'> 

                    <input id='register-email' class='input' type='text' name='email' placeholder='*Email:'> 

                    <input id='register-submit' type='submit' value='Register'>

                    <a id='register-login' href='login.php'>Already Registered your Company? Click here to login</a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
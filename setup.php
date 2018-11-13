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

        </div>

    </div>

</body>

</html>
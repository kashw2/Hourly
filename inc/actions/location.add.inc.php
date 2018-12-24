<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(!empty($_POST['location'])) {

    $Statement = mysqli_prepare($conn, '
    INSERT INTO
    hourly.locations (
    hourly.locations.id,
    hourly.locations.location
    )
    VALUES (
    DEFAULT,
    ?
    );
    ');

    mysqli_stmt_bind_param($Statement,
    's',
    $_POST['location']
    );

    mysqli_stmt_execute($Statement);

    mysqli_stmt_close($Statement);

}

?>
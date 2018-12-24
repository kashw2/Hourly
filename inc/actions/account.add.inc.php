<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

if(
    !empty($_POST['username'])
&   !empty($_POST['password'])
&   !empty($_POST['email'])
&   !empty($_POST['position'])
) {

    $Statement = mysqli_prepare($conn, '
    INSERT INTO
    hourly.accounts (
    hourly.accounts.id,
    hourly.accounts.username,
    hourly.accounts.password,
    hourly.accounts.email,
    hourly.accounts.company,
    hourly.accounts.positionid
    ) VALUES (
    DEFAULT,
    ?,
    ?,
    ?,
    (
        SELECT
        hourly.companies.name
        FROM hourly.companies
        WHERE hourly.companies.id = 1
        LIMIT 1
    ),
    (
        SELECT
        hourly.positions.id
        FROM hourly.positions
        WHERE hourly.positions.position = ?
    )
    );
    ');

    mysqli_stmt_bind_param($Statement,
    'ssss',
    $_POST['username'],
    md5($_POST['password']),
    $_POST['email'],
    $_POST['position']
    );

    mysqli_stmt_execute($Statement);

}

echo var_dump($_POST);

?>
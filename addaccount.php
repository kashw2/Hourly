<?php

ob_start();

session_start();

chdir('../../');

require_once('mysql.php');

$rand = rand(0, 10000000);

$username = 'jdwaj' . $rand;
$email = 'kdwakjd' . $rand;

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
?,
?
)
');

$_SESSION['User']['Company'] = 'Adaptive IT';
$_SESSION['User']['Position'] = 2;

mysqli_stmt_bind_param($Statement,
'ssssi',
$username,
md5($_POST['password']),
$email,
$_SESSION['User']['Company'],
$_SESSION['User']['Position']
);

mysqli_stmt_execute($Statement);

?>
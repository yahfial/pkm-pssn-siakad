<?php
$ip = getenv("REMOTE_ADDR");
$date = date("Y-m-d H:i:s");
$useragent = $_SERVER['HTTP_USER_AGENT'];
$file = fopen("ip.txt", "a");
fwrite($file, "IP: $ip | Date: $date | UserAgent: $useragent\n");
fclose($file);
?>

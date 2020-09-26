<?php

$cookie_name = "secret";
$cookie_value = $_POST['secret'];

setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

header("Location: https://mem-bot-v2.5v.pl/");

exit;
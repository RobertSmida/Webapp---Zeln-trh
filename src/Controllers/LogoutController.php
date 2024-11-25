<?php
// Jednoduchy controller opatrujuci odhlasenie uzivatela
session_start();
session_destroy();
header('Location: index.php?page=home');
exit();

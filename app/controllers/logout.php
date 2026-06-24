<?php
session_start();

session_destroy();

header("Location: /gestion_bibliotheque/index.php");
exit;
?>

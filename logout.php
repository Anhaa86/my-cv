<?php
session_start();
session_unset(); // Session хувьсагчдыг устгана
session_destroy(); // Session устгана
header("Location: index.php"); 
exit;
?>

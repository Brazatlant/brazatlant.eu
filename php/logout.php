<!-- filepath: c:\Users\pance\OneDrive\Documents\GitHub\brazatlant.eu\php\logout.php -->
<?php
session_start();
session_destroy();
header("Location: ../index.html");
exit();
?>
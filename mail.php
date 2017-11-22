<?php
include 'back/function.php';
$to = 'gprajena@binus.edu';
$subject = "tes email 1";
$message = "<h4>tes email 1</h4>";
$from = 0;
echo send_email($to, $subject, $message, $from);
?>
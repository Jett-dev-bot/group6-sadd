<?php
session_start();
session_unset();
session_destroy();
header("Location: loginform.php"); // Change this to your actual login page
exit();
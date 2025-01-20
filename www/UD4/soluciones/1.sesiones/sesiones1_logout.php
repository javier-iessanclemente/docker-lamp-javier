<?php
session_start();
session_destroy();
header("Location: sesiones1_login.php?redirigido=true");
?>
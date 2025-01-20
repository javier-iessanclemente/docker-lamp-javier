<?php
session_start();
session_destroy();
header("Location: sesiones2_login.php?redirigido=true");
?>
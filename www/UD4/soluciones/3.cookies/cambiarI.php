<?php
if(isset($_POST["idioma"])) {
    setcookie("idioma", $_POST["idioma"], time() + (86400 * 5));
    header("Location: index.php");
}
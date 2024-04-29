<?php

include '../controller/user-controller.php';

$register = new UserController();
echo $register->login($_POST);
?>
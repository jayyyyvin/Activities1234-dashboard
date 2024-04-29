<?php

include '../controller/user-controller.php';

$register = new UserController();
echo $register->registered($_POST);
?>
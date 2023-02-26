<?php

require_once '../services/authService.php';

$isAuth = $authService->checkIsAuth();
if (!$isAuth) {
  header('Location: login.php');
  exit();
}

$authService->logout();

?>
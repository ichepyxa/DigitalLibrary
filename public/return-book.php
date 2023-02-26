<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';
require_once '../services/libraryService.php';
require_once '../services/studentService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if (!$isAuth) {
  header('Location: login.php');
  exit();
}

if (!isset($_GET['issueId']) && !$_GET['issueId']) {
  header('Location: library.php');
  exit();
}

$result = $libraryService->returnIssuedBook($_GET['issueId']);

if (!isset($_GET['redirectPath'])) {
  header('Location: library.php');
  exit();
}

header("Location: {$_GET['redirectPath']}");
exit();

?>
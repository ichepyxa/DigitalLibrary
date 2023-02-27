<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';
require_once '../services/studentService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if (!$isAuth) {
  header('Location: login.php');
  exit();
}

if (!isset($_GET['librarian_id']) && !$_GET['librarian_id']) {
  header('Location: librarians.php');
  exit();
}

$result = $librarianService->deleteLibrarian((int) $_GET['librarian_id']);
if (!$result) {
  header('Location: librarians.php');
  exit();
}


if (!isset($_GET['redirectPath'])) {
  header('Location: librarians.php');
  exit();
}

header("Location: {$_GET['redirectPath']}");
exit();

?>
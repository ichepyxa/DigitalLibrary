<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';
require_once '../services/libraryService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if (!$isAuth) {
  header('Location: login.php');
  exit();
}

if (!isset($_GET['book_id']) && !$_GET['book_id']) {
  header('Location: library.php');
  exit();
}

$result = $libraryService->deleteBook((int) $_GET['book_id']);
if (!$result) {
  header('Location: library.php');
  exit();
}


if (!isset($_GET['redirectPath'])) {
  header('Location: library.php');
  exit();
}

header("Location: {$_GET['redirectPath']}");
exit();

?>
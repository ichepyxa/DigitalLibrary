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

if (!isset($_GET['student_id']) && !$_GET['student_id']) {
  header('Location: students.php');
  exit();
}

$result = $studentService->deleteStudent((int) $_GET['student_id']);
if (!$result) {
  header('Location: students.php');
  exit();
}


if (!isset($_GET['redirectPath'])) {
  header('Location: students.php');
  exit();
}

header("Location: {$_GET['redirectPath']}");
exit();

?>
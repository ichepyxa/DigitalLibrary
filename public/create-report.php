<?php

require_once '../libs/SimpleXLSXGen.php';
require_once '../services/authService.php';
require_once '../services/libraryService.php';

$isAuth = $authService->checkIsAuth();

if (!$isAuth) {
  header('Location: login.php');
  exit();
}

if (!isset($_GET['student_id'])) {
  header("Location: students.php");
}

$issuedBooks = $libraryService->getIssuedBooksById(null, (int) $_GET['student_id']);
$books = [
  ['Название книги', 'Дата выдачи книги', 'ФИО учащегося', 'Статус', 'Дата возврата книги']
];

foreach ($issuedBooks as $key => $issueBook) {
  $books[count($books)] = [
    "{$issueBook['book']['name']}",
    "{$issueBook['date_give']}",
    "{$issueBook['student']['surname']} {$issueBook['student']['name']} {$issueBook['student']['patronymic']}",
    "{$issueBook['status']}",
    !isset($issueBook['date_return']) ? 'Отсутствует' : "{$issueBook['date_return']}",
  ];
}

$xlsx = Shuchkin\SimpleXLSXGen::fromArray($books);
$xlsx->downloadAs('history_books.xlsx');

if (isset($_GET['redirectPath'])) {
  header("Location: {$_GET['redirectPath']}");
  exit();
}

header("Location: students.php");

?>
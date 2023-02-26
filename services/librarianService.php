<?php

require_once '../settings/connect.php';

class LibrarianService
{
  private PDO $connect;

  public function __construct(PDO $connect)
  {
    $this->connect = $connect;
  }

  /**
   * Метод получения логина
   * @return string|bool
   */
  public function getLogin(): string|bool
  {
    if (!isset($_COOKIE['id']) || !isset($_COOKIE['hash'])) {
      return false;
    }

    $query = $this->connect->prepare("SELECT `login` FROM `librarians` WHERE `librarian_id` = :id");
    $query->execute(['id' => $_COOKIE['id']]);

    $librarian = $query->fetch();
    if (!$librarian) {
      return 'Логин не существует';
    }

    return $librarian['login'];
  }
}

$librarianService = new LibrarianService($connect);

?>
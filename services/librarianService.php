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

  /**
   * Метод получения библиотекарей
   * @return array
   */
  public function getLibrarians(): array
  {
    $query = $this->connect->prepare("SELECT * FROM `librarians`");
    $query->execute();

    $librarians = $query->fetchAll();
    if (!$librarians) {
      return [];
    }

    $result = [];
    foreach ($librarians as $key => $librarian) {
      $result[$key] = [
        'librarian_id' => $librarian['librarian_id'],
        'login' => $librarian['login'],
        'surname' => $librarian['surname'],
        'name' => $librarian['name'],
        'patronymic' => $librarian['patronymic'],
        'is_admin' => $librarian['is_admin'],
      ];
    }

    return $result;
  }
}

$librarianService = new LibrarianService($connect);

?>
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
        'password' => $librarian['password'],
        'name' => $librarian['name'],
        'patronymic' => $librarian['patronymic'],
        'is_admin' => $librarian['is_admin'],
      ];
    }

    return $result;
  }

  /**
   * Метод получения библиотекаря по id
   * @param int
   * @return array
   */
  public function getLibrarian(int $librarianId): array
  {
    $query = $this->connect->prepare("SELECT * FROM `librarians` WHERE `librarian_id` = :librarian_id");
    $query->execute(['librarian_id' => $librarianId]);

    $librarian = $query->fetch();
    if (!$librarian) {
      return [];
    }

    return [
      'librarian_id' => $librarian['librarian_id'],
      'login' => $librarian['login'],
      'surname' => $librarian['surname'],
      'name' => $librarian['name'],
      'password' => $librarian['password'],
      'patronymic' => $librarian['patronymic'],
      'is_admin' => $librarian['is_admin'],
    ];
  }

  /**
   * Метод cоздания библиотекаря
   * @return array
   */
  public function createLibrarian(string|null $name, string|null $surname, string|null $patronymic, string $login, string $password, int $isAdmin): array
  {
    try {
      $query = $this->connect->prepare("INSERT INTO `librarians` (`surname`, `name`, `patronymic`, `login`, `password`, `is_admin`) VALUES (:surname, :name, :patronymic, :login, :password, :is_admin)");
      $query->execute([
        'surname' => $surname,
        'name' => $name,
        'patronymic' => $patronymic,
        'login' => $login,
        'password' => $password,
        'is_admin' => $isAdmin
      ]);

      return [
        'isError' => false,
        'message' => 'Библиотекарь успешно создан'
      ];
    } catch (Throwable $th) {
      return [
        'isError' => true,
        'message' => 'Не удалось создать библиотекаря'
      ];
    }
  }

  /**
   * Метод изменения библиотекаря
   * @return array
   */
  public function changeLibrarian(int $librarianId, string|null $name, string|null $surname, string|null $patronymic, string $login, string $password, int $isAdmin): array
  {
    try {
      $query = $this->connect->prepare("UPDATE `librarians` SET `surname` = :surname, `name` = :name, `patronymic` = :patronymic, `login` = :login, `password` = :password, `is_admin` = :is_admin WHERE `librarian_id` = :librarian_id");
      $query->execute([
        'surname' => $surname,
        'name' => $name,
        'patronymic' => $patronymic,
        'login' => $login,
        'password' => $password,
        'is_admin' => $isAdmin,
        'librarian_id' => $librarianId
      ]);

      return [
        'isError' => false,
        'message' => 'Библиотекарь успешно изменен'
      ];
    } catch (Throwable $th) {
      return [
        'isError' => true,
        'message' => 'Не удалось изменить библиотекаря'
      ];
    }
  }

  /**
   * Метод для удаления библиотекаря
   * @param int
   * @return void
   */
  public function deleteLibrarian(int $librarianId): void
  {
    $query = $this->connect->prepare("DELETE FROM `librarians` WHERE `librarian_id` = :librarian_id");
    $query->execute(['librarian_id' => $librarianId]);
  }
}

$librarianService = new LibrarianService($connect);

?>
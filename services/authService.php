<?php

require_once '../settings/connect.php';
require_once '../utils/generateRandomString.php';

class AuthService
{
  private PDO $connect;

  public function __construct(PDO $connect)
  {
    $this->connect = $connect;
  }

  /**
   * Метод авторизации
   * @param string $login
   * @param string $password
   * @return string|bool
   */
  public function login(string $login, string $password): string|bool
  {
    $query = $this->connect->prepare("SELECT * FROM `librarians` WHERE `login` = :login");
    $query->execute(['login' => $login]);

    $librarian = $query->fetch();
    if (!$librarian) {
      return 'Логин не существует';
    }

    $librarian_hash = md5(generateString(10) . $librarian['login']);

    if ($librarian['password'] === $password) {
      $query = $this->connect->prepare("UPDATE `librarians` SET `hash` = :hash WHERE `librarian_id` = :id");
      $isUpdated = $query->execute(['hash' => $librarian_hash, 'id' => $librarian['librarian_id']]);

      if (!$isUpdated) {
        return 'Что-то пошло не так, попробуйте позже';
      }

      setcookie("id", $librarian['librarian_id'], time() + 60 * 60 * 24 * 30, "/");
      setcookie('hash', $librarian_hash, time() + 60 * 60 * 24 * 30, "/", "", false, true);

      header("Location: library.php");
      exit();
    }

    return 'Не верный логин или пароль';
  }

  /**
   * Метод выхода
   * @return void
   */
  public function logout(): void
  {
    unset($_COOKIE['id']);
    unset($_COOKIE['hash']);
    setcookie('id', "", -1, '/');
    setcookie('hash', "", -1, '/');

    header('Location: index.php');
  }

  /**
   * Метод для проверки авторизации
   * @return bool
   */
  public function checkIsAuth(): bool
  {
    if (!isset($_COOKIE['id']) || !isset($_COOKIE['hash'])) {
      return false;
    }

    $query = $this->connect->prepare("SELECT * FROM `librarians` WHERE `librarian_id` = :id");
    $query->execute(['id' => $_COOKIE['id']]);

    $librarian = $query->fetch();
    if (!$librarian) {
      return false;
    }

    if ($librarian['hash'] != $_COOKIE['hash']) {
      return false;
    }

    return true;
  }

  /**
   * Метод для проверки на администратора
   * @return bool
   */
  public function checkIsAdmin(): bool
  {
    if (!isset($_COOKIE['id']) || !isset($_COOKIE['hash'])) {
      return false;
    }

    $query = $this->connect->prepare("SELECT * FROM `librarians` WHERE `librarian_id` = :id");
    $query->execute(['id' => $_COOKIE['id']]);

    $librarian = $query->fetch();
    if (!$librarian) {
      return false;
    }

    if ($librarian['hash'] != $_COOKIE['hash']) {
      return false;
    }

    if ($librarian['is_admin'] != '1') {
      return false;
    }

    return true;
  }
}

$authService = new AuthService($connect);

?>
<?php

require_once '../settings/connect.php';

class StudentService
{
  private PDO $connect;

  public function __construct(PDO $connect)
  {
    $this->connect = $connect;
  }

  /**
   * Метод получения cтудентов
   * @return array
   */
  public function getStudents(): array
  {
    $query = $this->connect->prepare("SELECT * FROM `student_cards`");
    $query->execute();

    $students = $query->fetchAll();
    if (!$students) {
      return [];
    }

    $result = [];
    foreach ($students as $key => $student) {
      $result[$key] = [
        'student_id' => $student['student_id'],
        'surname' => $student['surname'],
        'name' => $student['name'],
        'patronymic' => $student['patronymic'],
        'date_birth' => $student['date_birth'],
        'address' => $student['address'],
        'phone' => $student['phone'],
      ];

      $query = $this->connect->prepare("SELECT * FROM `groups` WHERE `group_id` = :group_id");
      $query->execute(['group_id' => $student['group_id']]);

      $group = $query->fetch();
      if ($group) {
        $result[$key]['group'] = $group;
      }
    }

    return $result;
  }

  /**
   * Метод получения cтудента по id
   * @param int
   * @return array
   */
  public function getStudent(int $id): array
  {
    $query = $this->connect->prepare("SELECT * FROM `student_cards` WHERE `student_id` = :id");
    $query->execute(['id' => $id]);

    $student = $query->fetch();
    if (!$student) {
      return [];
    }

    $result = [];
    $result[0] = [
      'student_id' => $student['student_id'],
      'surname' => $student['surname'],
      'name' => $student['name'],
      'patronymic' => $student['patronymic'],
      'date_birth' => $student['date_birth'],
      'address' => $student['address'],
      'phone' => $student['phone'],
    ];

    $query = $this->connect->prepare("SELECT * FROM `groups` WHERE `group_id` = :group_id");
    $query->execute(['group_id' => $student['group_id']]);

    $group = $query->fetch();
    if ($group) {
      $result[0]['group'] = $group;
    }

    return $result[0];
  }

  /**
   * Метод получения списка выдачи книг 
   * @return array
   */
  public function getIssuedBookById(int $bookId, string $status = ''): array
  {
    if ($status) {
      $query = $this->connect->prepare("SELECT * FROM `issued` WHERE `book_id` = :book_id AND `status` = :status");
      $query->execute(['book_id' => $bookId, 'status' => $status]);
    } else {
      $query = $this->connect->prepare("SELECT * FROM `issued` WHERE `book_id` = :book_id");
      $query->execute(['book_id' => $bookId]);
    }

    $issuedBooks = $query->fetchAll();
    if (!$issuedBooks) {
      return [];
    }

    $result = [];
    foreach ($issuedBooks as $key => $issuedBook) {
      $result[$key] = [
        'issue_id' => $issuedBook['issue_id'],
        'date_give' => $issuedBook['date_give'],
        'date_return' => $issuedBook['date_return'],
        'status' => $issuedBook['status']
      ];

      $query = $this->connect->prepare("SELECT * FROM `books` WHERE `book_id` = :book_id");
      $query->execute(['book_id' => $bookId]);

      $book = $query->fetch();
      if ($book) {
        $result[$key]['book'] = $book;
      }

      $query = $this->connect->prepare("SELECT * FROM `student_cards` WHERE `student_id` = :student_id");
      $query->execute(['student_id' => $issuedBook['student_id']]);

      $student = $query->fetch();
      if ($student) {
        $result[$key]['student'] = $student;
      }
    }

    return $result;
  }
}

$studentService = new StudentService($connect);

?>
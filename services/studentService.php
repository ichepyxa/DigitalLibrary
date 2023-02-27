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
   * Метод для создания карточки студента
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @return array
   */
  public function createStudent(string $name, string $surname, string $patronymic, string $address, string $group, string $date_birth, string $phone): array
  {
    $groupUpperCase = mb_strtoupper($group, 'UTF-8');
    $query = $this->connect->prepare("SELECT * FROM `groups` WHERE `group_name` = :group_name");
    $query->execute(['group_name' => $groupUpperCase]);
    $group = $query->fetch();

    if (!$group) {
      $query = $this->connect->prepare("INSERT INTO `groups` (`group_name`) VALUES (:group_name)");
      $query->execute(['group_name' => $groupUpperCase]);
    }

    $query = $this->connect->prepare("SELECT * FROM `groups` WHERE `group_name` = :group_name");
    $query->execute(['group_name' => $groupUpperCase]);
    $group = $query->fetch();

    $groupId = $group['group_id'];

    $query = $this->connect->prepare("INSERT INTO `student_cards` (`surname`, `name`, `patronymic`, `address`, `phone`, `date_birth`, `group_id`) VALUES (:surname, :name, :patronymic, :address, :phone, :date_birth, :group_id)");
    $query->execute([
      'surname' => $surname,
      'name' => $name,
      'patronymic' => $patronymic,
      'address' => $address,
      'phone' => $phone,
      'date_birth' => $date_birth,
      'group_id' => $groupId
    ]);

    return [
      'isError' => false,
      'message' => 'Студен успешно создан'
    ];
  }

  /**
   * Метод для удаления карточки студента
   * @param int
   * @return void
   */
  public function deleteStudent(int $studentId): void
  {
    // $query = $this->connect->prepare("SELECT * FROM `issued` WHERE `student_id` = :student_id");
    // $query->execute(['student_id' => $studentId]);

    // $issuedBooks = $query->fetchAll();
    // if ($issuedBooks) {
    //   foreach ($issuedBooks as $key => $issueBook) {
    //     $query = $this->connect->prepare("SELECT * FROM `books` WHERE `book_id` = :book_id");
    //     $query->execute(['book_id' => $issueBook['book_id']]);

    //     $book = $query->fetch();
    //     if ($book) {
    //       $count = (int) $book['count'] + 1;
    //       $query = $this->connect->prepare("UPDATE `books` SET `count` = :count WHERE `book_id` = :book_id");
    //       $query->bindParam(':count', $count, PDO::PARAM_INT);
    //       $query->bindParam(':book_id', $book['book_id'], PDO::PARAM_INT);
    //       $query->execute();
    //     }
    //   }
    // }

    $query = $this->connect->prepare("DELETE FROM `student_cards` WHERE `student_id` = :student_id");
    $query->execute(['student_id' => $studentId]);
  }
}

$studentService = new StudentService($connect);

?>
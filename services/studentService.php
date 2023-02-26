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

  public function createStudent(string $name, string $surname, string $patronymic, string $address, string $group, string $date_birth, string $phone)
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
      'message' => 'Пользователь успешно создан'
    ];
  }
}

$studentService = new StudentService($connect);

?>
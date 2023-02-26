<?php

require_once '../settings/connect.php';

class LibraryService
{
  private PDO $connect;

  public function __construct(PDO $connect)
  {
    $this->connect = $connect;
  }

  /**
   * Метод получения книг
   * @return array
   */
  public function getBooks(): array
  {
    $query = $this->connect->prepare("SELECT * FROM `books`");
    $query->execute();

    $books = $query->fetchAll();
    if (!$books) {
      return [];
    }

    $result = [];
    foreach ($books as $key => $book) {
      $result[$key] = [
        'book_id' => $book['book_id'],
        'name' => $book['name'],
        'publish_year' => $book['publish_year'],
        'description' => $book['description'],
        'count' => $book['count'],
      ];

      $query = $this->connect->prepare("SELECT * FROM `authors` WHERE `author_id` = :author_id");
      $query->execute(['author_id' => $book['author_id']]);

      $author = $query->fetch();
      if ($author) {
        $result[$key]['author'] = $author;
      }

      $query = $this->connect->prepare("SELECT * FROM `publishing` WHERE `publish_id` = :publish_id");
      $query->execute(['publish_id' => $book['publish_id']]);

      $publish = $query->fetch();
      if ($publish) {
        $result[$key]['publish'] = $publish;
      }

      $query = $this->connect->prepare("SELECT * FROM `genres` WHERE `genre_id` = :genre_id");
      $query->execute(['genre_id' => $book['genre_id']]);

      $genre = $query->fetch();
      if ($genre) {
        $result[$key]['genre'] = $genre;
      }
    }

    return $result;
  }

  /**
   * Метод получения книги по id
   * @param int
   * @return array
   */
  public function getBook(int $id): array
  {
    $query = $this->connect->prepare("SELECT * FROM `books` WHERE `book_id` = :id");
    $query->execute(['id' => $id]);

    $book = $query->fetch();
    if (!$book) {
      return [];
    }

    $result = [];
    $result[0] = [
      'book_id' => $book['book_id'],
      'name' => $book['name'],
      'publish_year' => $book['publish_year'],
      'description' => $book['description'],
      'count' => $book['count'],
    ];

    $query = $this->connect->prepare("SELECT * FROM `authors` WHERE `author_id` = :author_id");
    $query->execute(['author_id' => $book['author_id']]);

    $author = $query->fetch();
    if ($author) {
      $result[0]['author'] = $author;
    }

    $query = $this->connect->prepare("SELECT * FROM `publishing` WHERE `publish_id` = :publish_id");
    $query->execute(['publish_id' => $book['publish_id']]);

    $publish = $query->fetch();
    if ($publish) {
      $result[0]['publish'] = $publish;
    }

    $query = $this->connect->prepare("SELECT * FROM `genres` WHERE `genre_id` = :genre_id");
    $query->execute(['genre_id' => $book['genre_id']]);

    $genre = $query->fetch();
    if ($genre) {
      $result[0]['genre'] = $genre;
    }

    return $result[0];
  }

  /**
   * Метод получения списка выдачи книг 
   * @return array
   */
  public function getIssuedBookById(int|null $bookId = null, int|null $studentId = null, string $status = ''): array
  {
    if (is_null($bookId) && is_null($studentId)) {
      die('Student id and book id not must null');
    }

    if ($status) {
      $queryString = "SELECT * FROM `issued` WHERE " . (is_null($bookId) ? "`student_id` = :id" : "`book_id` = :id") . " AND `status` = :status";
      $query = $this->connect->prepare($queryString);

      is_null($bookId) ? 
        $query->bindParam(':id', $studentId, PDO::PARAM_INT) :
        $query->bindParam(':id', $bookId, PDO::PARAM_INT);

      $query->execute([
        'status' => $status
      ]);
    } else {
      $queryString = "SELECT * FROM `issued` WHERE " . (is_null($bookId) ? "`student_id` = :id" : "`book_id` = :id");
      $query = $this->connect->prepare($queryString);

      is_null($bookId) ? 
        $query->bindParam(':id', $studentId, PDO::PARAM_INT) :
        $query->bindParam(':id', $bookId, PDO::PARAM_INT);
      $query->execute();
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
      $query->execute(['book_id' => $issuedBook['book_id']]);

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

  /**
   * Метод выдачи книги
   * 
   * @param int
   * @param int 
   * @return array
   */
  public function createIssuedBook(int $bookId, int $studentId): array
  {
    if (!$bookId) {
      return [
        'isError' => true,
        'message' => 'Выберите книгу'
      ];
    }

    if (!$studentId) {
      return [
        'isError' => true,
        'message' => 'Выберите студента'
      ];
    }

    $query = $this->connect->prepare("SELECT * FROM `books` WHERE `book_id` = :book_id");
    $query->execute(['book_id' => $bookId]);

    $book = $query->fetch();
    if (!$book) {
      return [
        'isError' => true,
        'message' => 'Не удалось найти книгу'
      ];
    }

    if ((int) $book['count'] == 0) {
      return [
        'isError' => true,
        'message' => 'Книг нету в наличии'
      ];
    }

    $dateGive = (string) ((new DateTime())->format('Y-m-d'));
    $query = $this->connect->prepare("INSERT INTO `issued` (`book_id`, `student_id`, `date_give`) VALUES (:book_id, :student_id, :date_give)");
    $query->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $query->bindParam(':student_id', $studentId, PDO::PARAM_INT);
    $query->bindParam(':date_give', $dateGive);
    $query->execute();

    $count = (int) $book['count'] - 1;
    $query = $this->connect->prepare("UPDATE `books` SET `count` = :count WHERE `book_id` = :book_id");
    $query->bindParam(':count', $count, PDO::PARAM_INT);
    $query->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $query->execute();

    return [
      'isError' => false,
      'message' => 'Книга успешно выдана'
    ];
  }

  public function returnIssuedBook(int $issueId): bool
  {
    $query = $this->connect->prepare("SELECT * FROM `issued` WHERE `issue_id` = :issue_id");
    $query->execute(['issue_id' => $issueId]);

    $issuedBook = $query->fetch();
    if (!$issuedBook) {
      return false;
    }

    $query = $this->connect->prepare("SELECT * FROM `books` WHERE `book_id` = :book_id");
    $query->execute(['book_id' => $issuedBook['book_id']]);

    $book = $query->fetch();
    if (!$book) {
      return false;
    }

    $query = $this->connect->prepare("UPDATE `issued` SET `date_return` = :date_return, `status` = :status WHERE `issue_id` = :issue_id");
    $query->execute([
      'date_return' => (string) ((new DateTime())->format('Y-m-d')),
      'status' => 'Возвращена',
      'issue_id' => $issueId
    ]);

    $count = (int) $book['count'] + 1;
    $query = $this->connect->prepare("UPDATE `books` SET `count` = :count WHERE `book_id` = :book_id");
    $query->bindParam(':count', $count, PDO::PARAM_INT);
    $query->bindParam(':book_id', $issuedBook['book_id'], PDO::PARAM_INT);
    $query->execute();

    return true;
  }
}

$libraryService = new LibraryService($connect);

?>
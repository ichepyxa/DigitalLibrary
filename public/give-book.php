<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';
require_once '../services/libraryService.php';
require_once '../services/studentService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if (!$isAuth) {
  header('Location: login.php');
  exit();
}

?>

<!DOCTYPE html>
<html>
<?= renderTemplate('../components/head.php', [
  'title' => 'GGMKBook - выдача книги'
]) ?>

<body>
  <main class='main flex justify-self-stretch ml-60'>
    <?= renderTemplate('../components/sidebar.php', [
      'isAuth' => $isAuth,
      'isAdmin' => $isAdmin,
      'login' => $login
    ]) ?>
    <section class='bg-white w-full py-16'>
      <div class="max-w-lg p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <form action="" method='post'>
          <h2 class="text-3xl text-center font-semibold text-white mb-5">Выдача книги</h2>
          <div>
            <label for="student" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Студенты</label>
            <select id="student"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              name="student_id">
              <option value="null">Выберите студента</option>
              <?php

              $students = $studentService->getStudents();

              foreach ($students as $key => $student) {
                $attr = (isset($_GET['student_id']) && $student['student_id'] == $_GET['student_id']) ? 'selected' : '';

                echo <<<OPTION
                  <option $attr value="{$student['student_id']}">{$student['student_id']} - {$student['name']} {$student['surname']} {$student['patronymic']} ({$student['group']['group_name']})</option>"
                OPTION;
              }

              ?>
            </select>
          </div>

          <div class="mt-4">
            <label for="book" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Книги</label>
            <select id="book"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              name="book_id">
              <option value="null">Выберите книгу</option>
              <?php

              $books = $libraryService->getBooks();

              foreach ($books as $key => $book) {
                $attr = (isset($_GET['book_id']) && $book['book_id'] == $_GET['book_id']) ? 'selected' : '';

                echo <<<OPTION
                  <option $attr value="{$book['book_id']}">{$book['book_id']} - {$book['name']} ({$book['genre']['genre']})</option>"
                OPTION;
              }

              ?>
            </select>
          </div>

          <?php

          if (isset($_POST['book_id']) && isset($_POST['student_id'])) {
            $result = $libraryService->createIssuedBook((int) $_POST['book_id'], (int) $_POST['student_id']);

            if ($result['isError']) {
              echo "<p class='text-red-500 mt-5'>{$result['message']}</p>";
            } else {
              echo "<p class='text-emerald-500 mt-5'>{$result['message']}</p>";
            }
          }

          ?>

          <div class="w-full mt-5">
            <button
              class="w-full px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
              type="submit">
              Выдать книгу
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>
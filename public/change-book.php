<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/libraryService.php';
require_once '../services/librarianService.php';
require_once '../services/studentService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if (!$isAuth) {
  header('Location: login.php');
  exit();
}

if (!isset($_GET['book_id']) && !$_GET['book_id']) {
  header('Location: library.php');
  exit();
}

?>

<!DOCTYPE html>
<html>
<?= renderTemplate('../components/head.php', [
  'title' => 'GGMKBook - редактирование книги'
]) ?>

<body>
  <main class='main flex justify-self-stretch ml-60'>
    <?= renderTemplate('../components/sidebar.php', [
      'isAuth' => $isAuth,
      'isAdmin' => $isAdmin,
      'login' => $login
    ]) ?>
    <section class='bg-white w-full py-16'>
      <?php

      $book = $libraryService->getBook((int) $_GET['book_id']);

      ?>

      <div class="max-w-lg p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <form action="" method='post'>
          <h2 class="text-3xl text-center font-semibold text-white mb-5">Редактирование книги</h2>
          <div>
            <label class="text-gray-700 dark:text-gray-200" for="name">Имя книги</label>
            <input id="name" name="name" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Имя книги" value="<?= $book['name'] ?>" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="description">Описание книги</label>
            <textarea id="description" name="description" rows='6'
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring resize-none"
              maxlength='255' required><?= $book['description'] ?></textarea>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="publish_year">Год публикации книги</label>
            <input id="publish_year" name="publish_year" type="number"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Год публикации книги" min="1" max="3000" value="<?= $book['publish_year'] ?>" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="count">Количество книг</label>
            <input id="count" name="count" type="number"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Количество книг" value="<?= $book['count'] ?>" min="0" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="genre">Жанр книги</label>
            <input id="genre" name="genre" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Жанр книги" value="<?= $book['genre']['genre'] ?>" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="author_id">Автор книги</label>
            <div class="flex justify-between items-stretch flex-wrap gap-4">
              <select id="author_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="author_id">
                <option value="null">Выберите автора</option>
                <?php

                $authors = $libraryService->getAuthors();

                foreach ($authors as $key => $author) {
                  $attr = ($author['author_id'] == $book['author']['author_id']) ? 'selected' : '';

                  echo <<<OPTION
                    <option $attr value="{$author['author_id']}">{$author['author_id']} - {$author['surname']} {$author['name']} {$author['patronymic']}</option>"
                  OPTION;
                }

                ?>
              </select>
              <a href="create-author.php"
                class="flex justify-center items-center py-2 px-4 w-full text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                Создать автора
              </a>
            </div>
          </div>
          <div class="mt-4">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
              <div>
                <label class="text-gray-700 dark:text-gray-200" for="publish_name">Место публикации книги</label>
                <input id="publish_name" name="publish_name" type="text"
                  class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                  placeholder="Место публикации" value="<?= $book['publish']['name'] ?>" required>
              </div>
              <div>
                <label class="text-gray-700 dark:text-gray-200" for="publish_city">Город публикации книги</label>
                <input id="publish_city" name="publish_city" type="text"
                  class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                  placeholder="Город публикации" value="<?= $book['publish']['city'] ?>" required>
              </div>
            </div>
          </div>

          <?php

          if (
            isset($_POST['name']) &&
            isset($_POST['publish_year']) &&
            isset($_POST['description']) &&
            isset($_POST['count']) &&
            isset($_POST['author_id']) &&
            isset($_POST['genre']) &&
            isset($_POST['publish_name']) &&
            isset($_POST['publish_city']) &&
            isset($_GET['book_id'])
          ) {
            $publish = [
              'name' => $_POST['publish_name'],
              'city' => $_POST['publish_city']
            ];

            $result = $libraryService->updateBook(
              (int) $_GET['book_id'],
              $_POST['name'],
              $_POST['publish_year'],
              $_POST['description'],
              (int) $_POST['count'],
              $_POST['genre'],
              $_POST['author_id'],
              $publish
            );

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
              Редактировать
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>
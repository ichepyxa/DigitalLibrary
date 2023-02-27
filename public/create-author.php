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

?>

<!DOCTYPE html>
<html>
<?= renderTemplate('../components/head.php', [
  'title' => 'GGMKBook - создание автора'
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
          <h2 class="text-3xl text-center font-semibold text-white mb-5">Создание автора</h2>
          <div>
            <label class="text-gray-700 dark:text-gray-200" for="surname">Фамилия автора</label>
            <input id="surname" name="surname" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Фамилия автора" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="name">Имя автора</label>
            <input id="name" name="name" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Имя автора" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="patronymic">Отчество автора</label>
            <input id="patronymic" name="patronymic" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Отчество автора" required>
          </div>

          <?php

          if (
            isset($_POST['name']) &&
            isset($_POST['surname']) &&
            isset($_POST['patronymic'])
          ) {
            $result = $libraryService->createAuthor(
              $_POST['name'],
              $_POST['surname'],
              $_POST['patronymic']
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
              Создать
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>
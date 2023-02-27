<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';
require_once '../services/studentService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if (!$isAuth || !$isAdmin) {
  header('Location: login.php');
  exit();
}

?>

<!DOCTYPE html>
<html>
<?= renderTemplate('../components/head.php', [
  'title' => 'GGMKBook - создание библиотекаря'
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
          <h2 class="text-3xl text-center font-semibold text-white mb-5">Создание библиотекаря</h2>
          <div>
            <label class="text-gray-700 dark:text-gray-200" for="name">Имя библиотекаря</label>
            <input id="name" name="name" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Имя">
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="surname">Фамилия библиотекаря</label>
            <input id="surname" name="surname" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Фамилия">
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="patronymic">Отчество библиотекаря</label>
            <input id="patronymic" name="patronymic" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Отчество">
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="login">Логин библиотекаря</label>
            <input id="login" name="login" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Логин библиотекаря" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="password">Пароль библиотекаря</label>
            <input id="password" name="password" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Пароль библиотекаря" required>
          </div>
          <div class="mt-4">
            <label class="flex items-center gap-2.5 cursor-pointer">
              <span class="text-gray-700 dark:text-gray-200">Библиотекарь является администратором:</span>
              <input type="checkbox" class="relative h-[1.125rem] w-[1.125rem] rounded-md" name="is_admin" />
            </label>
          </div>

          <?php

          if (
            isset($_POST['login']) &&
            isset($_POST['password'])
          ) {
            $name = (isset($_POST['name']) && strlen($_POST['name']) == 0) ? null : $_POST['name'];
            $surname = (isset($_POST['surname']) && strlen($_POST['surname']) == 0) ? null : $_POST['surname'];
            $patronymic = (isset($_POST['patronymic']) && strlen($_POST['patronymic']) == 0) ? null : $_POST['patronymic'];
            $isAdmin = isset($_POST['is_admin']) ? 1 : 0;

            $result = $librarianService->createLibrarian(
              $name,
              $surname,
              $patronymic,
              $_POST['login'],
              $_POST['password'],
              $isAdmin
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
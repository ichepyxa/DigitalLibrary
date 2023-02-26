<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
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
  'title' => 'GGMKBook - создание студента'
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
          <h2 class="text-3xl text-center font-semibold text-white mb-5">Создание студента</h2>
          <div>
            <label class="text-gray-700 dark:text-gray-200" for="name">Имя студента</label>
            <input id="name" name="name" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Имя" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="surname">Фамилия студента</label>
            <input id="surname" name="surname" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Фамилия" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="patronymic">Отчество студента</label>
            <input id="patronymic" name="patronymic" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Отчество" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="address">Адрес проживания студента</label>
            <input id="address" name="address" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Адрес проживания" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="phone">Номер телефона студента</label>
            <input id="phone" name="phone" type="tel"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Номер телефона" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="date_birth">Дата рождения студента</label>
            <input id="date_birth" name="date_birth" type="date"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Дата рождения" required>
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="group">Группа студента</label>
            <input id="group" name="group" type="text"
              class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring uppercase placeholder:capitalize"
              placeholder="Группа" required>
          </div>

          <?php

          if (
            isset($_POST['name']) &&
            isset($_POST['surname']) &&
            isset($_POST['patronymic']) &&
            isset($_POST['address']) &&
            isset($_POST['group']) &&
            isset($_POST['date_birth']) &&
            isset($_POST['phone'])
          ) {
            $result = $studentService->createStudent(
              $_POST['name'],
              $_POST['surname'],
              $_POST['patronymic'],
              $_POST['address'],
              $_POST['group'],
              $_POST['date_birth'],
              $_POST['phone']
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
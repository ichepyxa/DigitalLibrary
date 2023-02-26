<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if ($isAuth) {
  header('Location: library.php');
  exit();
}

if (isset($_POST['login']) && isset($_POST['password'])) {
  $error = $authService->login($_POST['login'], $_POST['password']);
}

?>

<!DOCTYPE html>
<html>
<?= renderTemplate('../components/head.php', [
  'title' => 'GGMKBook - страница входа',
]) ?>

<body>
  <main class='main flex justify-self-stretch ml-60 '>
    <?= renderTemplate('../components/sidebar.php', [
      'isAuth' => $isAuth,
      'isAdmin' => $isAdmin,
      'login' => $login
    ]) ?>
    <section class="w-full min-h-screen flex justify-center items-center">
      <div
        class="flex w-full mx-auto max-w-sm overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-4xl">
        <div class="hidden bg-cover lg:block lg:w-1/2" style="background-image: url('/images/login-img.jpeg');">
        </div>

        <form action="" method='post' class="w-full px-6 py-14 md:px-8 lg:w-1/2">
          <div class="flex justify-center mx-auto">
            <p class='text-gray-600 dark:text-gray-300 font-semibold text-3xl'>
              GGMK<span class="text-blue-500">Book</span>
            </p>
          </div>

          <p class="mt-3 text-xl font-light text-center text-gray-600 dark:text-gray-200">
            Добро пожаловать!
          </p>

          <div class="mt-4">
            <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="login">Логин</label>
            <input id="login"
              class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300"
              type="text" name="login" required />
          </div>

          <div class="mt-4">
            <div class="flex justify-between">
              <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200"
                for="password">Пароль</label>
            </div>

            <input id="password"
              class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300"
              type="password" name="password" required />
          </div>

          <div class="mt-6">
            <button type="submit"
              class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50 dark:bg-gray-600">
              Войти
            </button>
          </div>

          <?php
          if (isset($error) && strlen($error)) {
            echo "<p class='text-red-500 mt-2'>$error</p>";
          }
          ?>
        </form>
      </div>
    </section>
  </main>
</body>

</html>
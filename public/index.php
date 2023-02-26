<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';

$isAuth = $authService->checkIsAuth();
$isAdmin = $authService->checkIsAdmin();
$login = $librarianService->getLogin();

if ($isAuth && $isAdmin) {
  header('Location: librarians.php');
  exit();
} else if ($isAuth) {
  header('Location: library.php');
  exit();
}

?>

<!DOCTYPE html>
<html>
<?= renderTemplate('../components/head.php', [
  'title' => 'GGMKBook - главная страница',
]) ?>

<body>
  <main class='main flex justify-self-stretch ml-60'>
    <?= renderTemplate('../components/sidebar.php', [
      'isAuth' => $isAuth,
      'isAdmin' => $isAdmin,
      'login' => $login
    ]) ?>
    <section class="bg-white w-full">
      <div class="container px-6 py-20 mx-auto text-center">
        <div class="max-w-lg mx-auto">
          <h1 class="text-3xl font-semibold text-gray-800 lg:text-4xl">Цифровая библиотека
            <i class="font-bold tracking-wider">&laquo;GGMK<span class="text-blue-600">Book</span>&raquo;</i>
          </h1>
          <p class="mt-6 text-gray-500">Предназначена для учета количества и наименование учащихся, которым были выданны
            книги.</p>
          <a href="login.php"
            class="inline-block px-5 py-2 mt-6 text-sm font-medium leading-5 text-center text-white capitalize bg-blue-600 rounded-lg hover:bg-blue-500 lg:mx-0 lg:w-auto focus:outline-none transition-colors duration-300">
            Войти
          </a>
        </div>

        <div class="flex max-w-4xl mx-auto justify-center mt-5 relative rounded-xl overflow-hidden">
          <img class="object-cover w-full h-96" src="/images/main-img.jpeg" />
          <div class='bg-slate-900/30 absolute inset-0 w-full'></div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>
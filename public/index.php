<?php

require_once '../utils/renderTemplate.php';
// require_once '../services/authService.php';

// $isUserAuth = $authService->checkIsAuth();

// if ($isUserAuth) {
//   header('Location: /panel.php');
//   exit();
// }

?>

<!DOCTYPE html>
<html>
<?= renderTemplate('../components/head.php', [
  'title' => 'GGMKBook - главная страница',
]) ?>

<body>
  <?= renderTemplate('../components/header.php') ?> //['isUserAuth' => $isUserAuth]
  <main class='main'>
    <div class="text-center bg-gray-50 text-gray-800 py-20 px-6 min-h-[calc(100vh-80px)] flex flex-col">
      <h1 class="text-5xl font-bold mb-3">GGMKBook</h1>
      <h3 class="text-3xl font-bold mb-8">Выберите тип входа</h3>
      <div>
        <a class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
          data-mdb-ripple="true" data-mdb-ripple-color="light" href="/login.php" role="button">Авторизоваться</a>
        <a class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
          data-mdb-ripple="true" data-mdb-ripple-color="light" href="/registration.php"
          role="button">Зарегистрироваться</a>
      </div>
    </div>
  </main>
  <?= renderTemplate('../components/footer.php') ?>
</body>

</html>
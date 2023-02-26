<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';

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
  'title' => 'GGMKBook - админ панель',
]) ?>

<body>
  <main class='main flex justify-self-stretch ml-60'>
    <?= renderTemplate('../components/sidebar.php', [
      'isAuth' => $isAuth,
      'isAdmin' => $isAdmin,
      'login' => $login
    ]) ?>
    <section class="bg-white w-full">
      adminpanel
    </section>
  </main>
</body>

</html>
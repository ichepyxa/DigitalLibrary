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
  'title' => 'GGMKBook - панель управления',
]) ?>

<body>
  <!-- ['isUserAuth' => $isUserAuth] -->
  <main class='main flex justify-self-stretch ml-60'>
    <?= renderTemplate('../components/sidebar.php') ?>
    <section class="bg-white w-full">
      userpanel
    </section>
  </main>
</body>

</html>
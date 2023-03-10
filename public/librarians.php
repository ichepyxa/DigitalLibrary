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
  'title' => 'GGMKBook - библиотекари'
]) ?>

<body>
  <main class='main flex justify-self-stretch ml-60'>
    <?= renderTemplate('../components/sidebar.php', [
      'isAuth' => $isAuth,
      'isAdmin' => $isAdmin,
      'login' => $login
    ]) ?>
    <?php if (isset($_GET['id']) && strlen($_GET['id']) > 0): ?>
      <section class="bg-white w-full py-16">
        <?php

        $student = $studentService->getStudent((int) $_GET['id']);

        ?>

        <div class="flex justify-center mx-auto mb-10 gap-10">
          <div class="w-5/6 overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-7 py-10">
              <p class="block text-4xl font-semibold text-gray-800 dark:text-white" tabindex="0" role="link">
                <?="{$student['name']} {$student['surname']} {$student['patronymic']}" ?>
              </p>

              <div class="mt-6">
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-200">
                  <?="Группа: {$student['group']['group_name']}" ?>
                </p>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-200">
                  <?="Адрес проживания: {$student['address']}" ?>
                </p>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-200">Дата рождения:
                  <?=(new DateTime($student['date_birth']))->format('d m Y') ?>
                </p>
              </div>

              <div class="flex justify-end item-center gap-5 w-full mt-6">
                <a href="delete-student.php?student_id=<?= $student['student_id'] ?>&redirectPath=/students.php"
                  class='px-6 py-2 font-medium tracking-wide text-white transition-colors duration-300 transform bg-red-600 rounded-lg hover:bg-red-500 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-80 w-fit flex items-center gap-2'>
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 7h16"></path>
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                    <path d="M10 12l4 4m0 -4l-4 4"></path>
                  </svg>
                  Удалить
                </a>
                <a href="give-book.php?student_id=<?= $student['student_id'] ?>"
                  class='px-6 py-2 font-medium tracking-wide text-white transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80 block w-fit'>Выдать
                  книгу</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php else: ?>
      <section class="bg-white py-10 w-full">
        <?php

        $librarians = $librarianService->getLibrarians();

        ?>

        <div class="mb-5 w-11/12 mx-auto">
          <h2 class="text-3xl font-bold text-center mb-3">Бибилотекари</h2>
          <a href="create-librarian.php"
            class="w-fit flex items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80 ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-1" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
              <path d="M9 12l6 0"></path>
              <path d="M12 9l0 6"></path>
            </svg>

            <span class="mx-1 text-lg">Создать</span>
          </a>
        </div>
        <div class="flex flex-col w-5/6 mx-auto">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
              <?php if ($librarians): ?>
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                  <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                      <tr>
                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          ID
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Логин
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Имя
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Фамилия
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Отчество
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Роль
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">

                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                      <?php foreach ($librarians as $key => $librarian): ?>
                        <tr>
                          <td class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
                            <span>
                              <?="#{$librarian['librarian_id']}" ?>
                            </span>
                          </td>
                          <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            <?= $librarian['login'] ?>
                          </td>

                          <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            <?=!isset($librarian['name']) ? 'Отсутствует' : $librarian['name'] ?>
                          </td>
                          <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            <?=!isset($librarian['surname']) ? 'Отсутствует' : $librarian['surname'] ?>
                          </td>
                          <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            <?=!isset($librarian['patronymic']) ? 'Отсутствует' : $librarian['patronymic'] ?>
                          </td>
                          <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                            <div
                              class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 bg-emerald-100/60 dark:bg-gray-800 <?=((int) $librarian['is_admin'] == 0 ? 'text-blue-500' : 'text-red-500') ?>">
                              <h2 class="text-sm font-normal">
                                <?=((int) $librarian['is_admin'] == 0 ? 'Библиотекарь' : 'Администратор') ?>
                              </h2>
                            </div>
                          </td>
                          <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                            <div class="flex justify-center items-stretch gap-2.5">
                              <a href="change-librarian.php?librarian_id=<?= $librarian['librarian_id'] ?>"
                                class="w-fit flex justify-center items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-yellow-600 rounded-lg hover:bg-yellow-500 focus:outline-none focus:ring focus:ring-yellow-300 focus:ring-opacity-80">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="2"
                                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                  <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                  <path d="M16 5l3 3"></path>
                                </svg>
                              </a>
                              <?php if ($login != $librarian['login']): ?>
                                <a href="delete-librarian.php?librarian_id=<?= $librarian['librarian_id'] ?>&redirectPath=<?= $_SERVER['REQUEST_URI'] ?>"
                                  class="w-fit flex justify-center items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-red-600 rounded-lg hover:bg-red-500 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-80">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7h16"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    <path d="M10 12l4 4m0 -4l-4 4"></path>
                                  </svg>
                                </a>
                              <?php endif; ?>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php else: ?>
                <h4 class="text-lg text-center">Нету библиотекарей</h4>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>
  </main>
</body>

</html>
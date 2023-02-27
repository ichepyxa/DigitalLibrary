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
  'title' => 'GGMKBook - карточки студентов'
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
        $issuedBooks = $libraryService->getIssuedBooksById(null, (int) $_GET['id']);

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

              <div class="flex justify-between item-center w-full mt-6">
                <div>
                  <?php if (isset($issuedBooks) && count($issuedBooks) > 0): ?>
                    <a href="create-report.php?student_id=<?= $student['student_id'] ?>&redirectPath=/students.php"
                      class='pl-4 pr-6 py-2 font-medium tracking-wide text-white transition-colors duration-300 transform bg-emerald-600 rounded-lg hover:bg-emerald-500 focus:outline-none focus:ring focus:ring-emerald-300 focus:ring-opacity-80 flex items-center gap-2 w-fit'>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                        <path d="M7 11l5 5l5 -5"></path>
                        <path d="M12 4l0 12"></path>
                      </svg>
                      Скачать отчет
                    </a>
                  <?php endif; ?>
                </div>
                <div class="flex items-center gap-5">
                  <a href="delete-student.php?student_id=<?= $student['student_id'] ?>&redirectPath=/students.php"
                    class='pl-4 pr-6 py-2 font-medium tracking-wide text-white transition-colors duration-300 transform bg-red-600 rounded-lg hover:bg-red-500 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-80 w-fit flex items-center gap-2'>
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
        </div>

        <div class="flex flex-col w-5/6 mx-auto">
          <h2 class="text-2xl mb-3 font-bold">История выдачи книг</h2>
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
              <?php if ($issuedBooks): ?>
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                      <tr>
                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          ID
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Книга
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Статус
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Дата выдачи
                        </th>

                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          Дата возврата
                        </th>
                        <th scope="col"
                          class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">

                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                      <?php foreach ($issuedBooks as $key => $issuedBook): ?>
                        <tr>
                          <td class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
                            <span>
                              <?="#{$issuedBook['issue_id']}" ?>
                            </span>
                          </td>
                          <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            <a href="library.php?id=<?= $issuedBook['book']['book_id'] ?>"
                              class="text-sm font-medium text-gray-800 dark:text-white border-b border-dashed hover:border-blue-400 hover:text-blue-400 hover:border-solid transition border-gray-800 dark:border-white py-1">
                              <?= $issuedBook['book']['name'] ?>
                            </a>
                          </td>
                          <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                            <div
                              class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 bg-emerald-100/60 dark:bg-gray-800 <?=($issuedBook['status'] === 'Возвращена' ? 'text-emerald-500' : ($issuedBook['status'] === 'Потеряна' ? 'text-red-500' : 'text-orange-500')) ?>">
                              <span
                                class="h-1.5 w-1.5 rounded-full <?=($issuedBook['status'] === 'Возвращена' ? 'bg-emerald-500' : ($issuedBook['status'] === 'Потеряна' ? 'bg-red-500' : 'bg-orange-500')) ?>"></span>

                              <h2 class="text-sm font-normal">
                                <?= $issuedBook['status'] ?>
                              </h2>
                            </div>
                          </td>
                          <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            <?= $issuedBook['date_give'] ?>
                          </td>
                          <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            <?=!isset($issuedBook['date_return']) ? 'Отсутствует' : $issuedBook['date_return'] ?>
                          </td>
                          <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                            <?php if ($issuedBook['status'] !== 'Возвращена'): ?>
                              <a href="return-book.php?issueId=<?= $issuedBook['issue_id'] ?>&redirectPath=<?= $_SERVER['REQUEST_URI'] ?>"
                                class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 bg-emerald-400 text-gray-800 hover:bg-emerald-300 transition">
                                Возвратить
                              </a>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php else: ?>
                <h4 class="text-lg text-center">Нету истории учащегося</h4>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php else: ?>
      <section class="bg-white py-10">
        <div class="mb-5 w-11/12 mx-auto">
          <h2 class="text-3xl font-bold text-center mb-3">Учащиеся</h2>
          <a href="create-student.php"
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
        <div class="w-11/12 flex justify-center flex-wrap mx-auto gap-10">
          <?php

          $students = $studentService->getStudents(); foreach ($students as $key => $student) {
            renderTemplate('../components/studentCard.php', ['student' => $student]);
          }

          ?>
        </div>
      </section>
    <?php endif; ?>
  </main>
</body>

</html>
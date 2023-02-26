<?php

require_once '../utils/renderTemplate.php';
require_once '../services/authService.php';
require_once '../services/librarianService.php';
require_once '../services/libraryService.php';

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
  'title' => 'GGMKBook - библиотека'
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

        $book = $libraryService->getBook((int) $_GET['id']);

        ?>

        <div class="flex justify-center mx-auto mb-10 gap-10">
          <div class="w-5/6 overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 flex justify-between">
            <div class="w-1/2 h-full relative block">
              <img class="object-cover w-full h-full block" src="/images/card-img.jpeg" alt="Article">
              <div class="absolute top-2 right-2 w-fit bg-slate-900/70 rounded-lg p-3">
                <h4 class="mx-3 text-sm text-white">
                  <?php

                  if ((int) $book['count'] > 0) {
                    echo "В наличии: {$book['count']} шт.";
                  } else {
                    echo "Нет в наличии";
                  }

                  ?>
                </h4>
              </div>
            </div>

            <div class="w-1/2 p-7 py-10">
              <p class="block text-4xl font-semibold text-gray-800 dark:text-white" tabindex="0" role="link">
                <?=
                  $book['name'] ?>
              </p>
              <p class="mt-6 text-lg text-gray-600 dark:text-gray-200">
                <?= $book['description'] ?>
              </p>

              <div class="mt-6">
                <p class="text-sm text-gray-700 dark:text-gray-200" tabindex="0" role="link">Создатель:
                  <?="{$book['author']['surname']} {$book['author']['name']} {$book['author']['patronymic']}" ?>
                </p>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Дата публикации:
                  <?= $book['publish_year'] ?> год
                </p>
              </div>

              <?php if ((int) $book['count'] > 0): ?>
                <a href="give-book.php?book_id=<?= $book['book_id'] ?>"
                  class='px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80 block w-fit ml-auto mt-6'>Выдать</a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <?php

        $issuedBooks = $libraryService->getIssuedBookById((int) $_GET['id'], null);

        ?>

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
                          ФИО учащегося
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
                            <a href="students.php?id=<?= $issuedBook['student']['student_id'] ?>"
                              class="text-sm font-medium text-gray-800 dark:text-white border-b border-dashed hover:border-blue-400 hover:text-blue-400 hover:border-solid transition border-gray-800 dark:border-white py-1">
                              <?= $issuedBook['student']['surname'] . " " . mb_substr($issuedBook['student']['name'], 0, 1, 'UTF-8') . ". " . mb_substr($issuedBook['student']['patronymic'], 0, 1, 'UTF-8') . "." ?>
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
                <h4 class="text-lg text-center">Нету истории выдачи, возврата книг</h4>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </section>
    <?php else: ?>
      <section class="bg-white py-10">
        <div></div>
        <div class="w-11/12 flex justify-center flex-wrap mx-auto gap-10">
          <?php

          $books = $libraryService->getBooks(); foreach ($books as $key => $book) {
            renderTemplate('../components/bookCard.php', ['book' => $book]);
          }

          ?>
        </div>
      </section>
    <?php endif; ?>
  </main>
</body>

</html>
<div
  class="w-full max-w-[20rem] overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 hover:scale-105 transition">
  <div class="h-56 w-full relative">
    <img class="object-cover object-center w-full h-56 block" src="/images/card-img.jpeg" alt="avatar">
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

  <div class="px-6 py-4 relative">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
      <?= $book['name'] ?>
    </h1>

    <p class="py-2 text-gray-700 dark:text-gray-400">
      <?="Жанр: {$book['genre']['genre']}" ?>
    </p>

    <div class="flex items-center mt-4 text-gray-700 dark:text-gray-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24" stroke-width="2"
        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
      </svg>

      <h1 class="px-2 text-sm">
        <?= $book['author']['surname'] . " " . mb_substr($book['author']['name'], 0, 1, 'UTF-8') . ". " . mb_substr($book['author']['patronymic'], 0, 1, 'UTF-8') . "." ?>
      </h1>
    </div>

    <div class="flex items-center mt-4 text-gray-700 dark:text-gray-200">
      <svg aria-label="location pin icon" class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M16.2721 10.2721C16.2721 12.4813 14.4813 14.2721 12.2721 14.2721C10.063 14.2721 8.27214 12.4813 8.27214 10.2721C8.27214 8.063 10.063 6.27214 12.2721 6.27214C14.4813 6.27214 16.2721 8.063 16.2721 10.2721ZM14.2721 10.2721C14.2721 11.3767 13.3767 12.2721 12.2721 12.2721C11.1676 12.2721 10.2721 11.3767 10.2721 10.2721C10.2721 9.16757 11.1676 8.27214 12.2721 8.27214C13.3767 8.27214 14.2721 9.16757 14.2721 10.2721Z" />
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M5.79417 16.5183C2.19424 13.0909 2.05438 7.3941 5.48178 3.79418C8.90918 0.194258 14.6059 0.0543983 18.2059 3.48179C21.8058 6.90919 21.9457 12.606 18.5183 16.2059L12.3124 22.7241L5.79417 16.5183ZM17.0698 14.8268L12.243 19.8965L7.17324 15.0698C4.3733 12.404 4.26452 7.9732 6.93028 5.17326C9.59603 2.37332 14.0268 2.26454 16.8268 4.93029C19.6267 7.59604 19.7355 12.0269 17.0698 14.8268Z" />
      </svg>

      <h1 class="px-2 text-sm">
        <?="{$book['publish']['city']}, {$book['publish']['name']}" ?>
      </h1>
    </div>

    <div class="flex items-center mt-4 text-gray-700 dark:text-gray-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
        fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
        <path d="M15 3v4"></path>
        <path d="M7 3v4"></path>
        <path d="M3 11h16"></path>
        <path d="M18 16.496v1.504l1 1"></path>
      </svg>

      <h1 class="px-2 text-sm">
        <?="{$book['publish_year']} год" ?>
      </h1>
    </div>

    <div class="flex justify-end items-stretch gap-2 mt-4 text-gray-700 dark:text-gray-200">
      <a href="delete-book.php?book_id=<?= $book['book_id'] ?>&redirectPath=<?= $_SERVER['REQUEST_URI'] ?>"
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

      <a href="change-book.php?book_id=<?= $book['book_id'] ?>&redirectPath=<?= $_SERVER['REQUEST_URI'] ?>"
        class="w-fit flex justify-center items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-yellow-600 rounded-lg hover:bg-yellow-500 focus:outline-none focus:ring focus:ring-yellow-300 focus:ring-opacity-80">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="2"
          stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
          <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
          <path d="M16 5l3 3"></path>
        </svg>
      </a>

      <a href="?id=<?= $book['book_id'] ?>"
        class="w-fit flex justify-center items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="2"
          stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
          <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
          <path d="M15 8l2 0"></path>
          <path d="M15 12l2 0"></path>
          <path d="M7 16l10 0"></path>
        </svg>
      </a>
    </div>

  </div>
</div>
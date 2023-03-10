<a href="?id=<?= $student['student_id'] ?>"
  class="w-full max-w-[20rem] overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 hover:scale-105 transition">
  <div class="px-6 py-4 relative">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
      <?= $student['surname'] . " " . mb_substr($student['name'], 0, 1, 'UTF-8') . ". " . mb_substr($student['patronymic'], 0, 1, 'UTF-8') . "." ?>
    </h1>

    <p class="py-2 text-gray-700 dark:text-gray-400">
      <?="Группа: {$student['group']['group_name']}" ?>
    </p>

    <div class="flex items-center mt-4 text-gray-700 dark:text-gray-200">
      <svg aria-label="location pin icon" class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M16.2721 10.2721C16.2721 12.4813 14.4813 14.2721 12.2721 14.2721C10.063 14.2721 8.27214 12.4813 8.27214 10.2721C8.27214 8.063 10.063 6.27214 12.2721 6.27214C14.4813 6.27214 16.2721 8.063 16.2721 10.2721ZM14.2721 10.2721C14.2721 11.3767 13.3767 12.2721 12.2721 12.2721C11.1676 12.2721 10.2721 11.3767 10.2721 10.2721C10.2721 9.16757 11.1676 8.27214 12.2721 8.27214C13.3767 8.27214 14.2721 9.16757 14.2721 10.2721Z" />
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M5.79417 16.5183C2.19424 13.0909 2.05438 7.3941 5.48178 3.79418C8.90918 0.194258 14.6059 0.0543983 18.2059 3.48179C21.8058 6.90919 21.9457 12.606 18.5183 16.2059L12.3124 22.7241L5.79417 16.5183ZM17.0698 14.8268L12.243 19.8965L7.17324 15.0698C4.3733 12.404 4.26452 7.9732 6.93028 5.17326C9.59603 2.37332 14.0268 2.26454 16.8268 4.93029C19.6267 7.59604 19.7355 12.0269 17.0698 14.8268Z" />
      </svg>

      <h1 class="px-2 text-sm">
        <?= $student['address'] ?>
      </h1>
    </div>

    <div class="flex items-center mt-4 text-gray-700 dark:text-gray-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
        fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
        </path>
      </svg>

      <h1 class="px-2 text-sm">
        <?="+ {$student['phone']}" ?>
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
        <?=(new DateTime($student['date_birth']))->format('d m Y года') ?>
      </h1>
    </div>
  </div>
</a>
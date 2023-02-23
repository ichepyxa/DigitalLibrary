<header class="header">
  <nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-end">
          <div class="block">
            <div class="flex space-x-4">
              <?php if (isset($isUserAuth)): ?> //$isUserAuth
                <a href="/panel.php" class="hover:bg-gray-700 text-white px-3 py-2 rounded-md text-sm font-medium">Личный
                  кабинет</a>

                <a href="/logout.php"
                  class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Выход</a>
              <?php else: ?>
                <a href="/login.php"
                  class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Вход</a>

                <a href="/registration.php"
                  class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Регистрация</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

</header>
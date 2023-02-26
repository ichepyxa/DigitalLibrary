<?php

/**
 * Метод для рендера файла
 * @param string $file
 * @param array $args
 * @return void
 */
function renderTemplate(string $file, array $args = []): void
{
  if (!file_exists($file)) {
    echo '';
  }

  if (is_array($args)) {
    extract($args);
  }

  ob_start();
  require $file;
  $template = ob_get_clean();
  echo !$template ? '' : $template;
}
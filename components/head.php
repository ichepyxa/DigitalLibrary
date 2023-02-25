<?php

require_once '../settings/config.php';

?>

<head>
  <!-- META -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- TITLE -->
  <title>
    <?=!isset($title) ? $config['title'] : $title ?>
  </title>

  <!-- STYLES -->
  <!-- <link rel="stylesheet" href="/css/normalize.css"> -->
  <link rel="stylesheet" href="/css/styles.css">
  <?=!isset($styles) ? '' : $styles ?>

  <!-- SCRIPTS -->
  <script src="/js/libs/tailwindcss.min.js"></script>
  <script src="/js/libs/alpine-ie11.min.js"></script>
  <?=!isset($scripts) ? '' : $scripts ?>
</head>
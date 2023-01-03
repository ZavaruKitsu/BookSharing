<?php namespace Engine;

use Engine\Addons\Auth\User;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?= Config::$site_name ?></title>
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link rel="preconnect" href="https://use.fontawesome.com/" crossorigin>
  <link rel="preconnect" href="//cdn.jsdelivr.net/" crossorigin>
  <link rel="preconnect" href="https://www.gstatic.com/" crossorigin>
  <link rel="stylesheet" href="<?= Vars::$web_dir ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= Vars::$web_dir ?>css/mdb.lite.min.css">
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- MDB Lite Pro -->
  <script type="text/javascript" src="<?= Vars::$web_dir ?>js/mdb.lite.min.js" async defer></script>
</head>

<body class="elegant-color text-white">

<nav class="navbar navbar-expand-lg navbar-dark special-color" id="top-section">
  <a class="px-lg-5 navbar-brand" href="#"><?= Config::$site_name ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link waves-effect waves-light" href="?page=index">Главная</a>
      </li>
      <li class="nav-item">
        <a class="nav-link waves-effect waves-light" href="?page=catalog">Каталог</a>
      </li>
      <li class="nav-item">
        <a class="nav-link waves-effect waves-light" href="?page=rules">Правила</a>
      </li>
        <?php if (User::isAuthorized()): ?>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="?page=submit">Заявка</a>
          </li>
        <?php endif; ?>
        <?php if (User::isAdmin()): ?>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="?page=addBook">Добавить книгу</a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="?page=submits">Заявки</a>
          </li>
        <?php endif; ?>
    </ul>
    <div class="md-form my-0">
      <input class="form-control mr-sm-2 text-white" id="searchId" type="text" autocomplete="off"
             placeholder="Переход по ID" aria-label="Search" onkeydown="goToId(this);">
    </div>
      <?php
      if (!User::isAuthorized()): //Оно занимает так много места, что проскролить вниз и вверх занимает 7.5 секунд (я замерил). Поэтому в отдельный файл
          require_once __DIR__ . '/regFormSuperSecretPath.php';
      else: ?>
        <button id="modalActivate" type="button" class="btn btn-discord btn-rounded my-3 btn-sm" data-toggle="modal"
                data-target="#exampleModalPreview">
          <i class="fas fa-bell"></i>
        </button>
        <button type="button" class="btn btn-discord btn-rounded my-3 btn-sm"
                onclick="document.location.href='?page=profile';">
          <i class="fas fa-user"></i>
        </button>
        <button type="button" class="btn btn-discord btn-rounded my-3 btn-sm"
                onclick="document.location.href='?logout';">
          <i class="fas fa-sign-out-alt"></i>
        </button>

          <?php
          require_once __DIR__ . '/notifications.php'; // Та же причина. Оставил название нормальным, т.к. может кому спарсить это надо будет?)
      endif; ?>
  </div>
</nav>
<div class="content mh-util">
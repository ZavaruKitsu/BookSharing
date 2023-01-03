<?php

namespace Engine;

use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;
use Engine\Addons\History\History;

if (!isset($_GET['book']))
    ErrorsHandler::notFoundError();

$book = Books::getById($_GET['book']);

if ($book == null)
    ErrorsHandler::notFoundError();

if ($book->hidden && !User::isAdmin())
    ErrorsHandler::notFoundError();

$page = 1;

if (isset($_GET['pageOffset']))
    $page = $_GET['pageOffset'];

$history = History::getBookHistoryById($_GET['book'], $page);

Web::header();

?>
  <br>
  <br>
  <div class="container w-55 p-3">
    <div class="card">
      <div class="card-body text-white stylish-color-dark">
        <div class="row">
          <div class="col-md-6">
            <img src="<?= Vars::$web_dir ?>img/<?= $book->image ?>" class="rounded" alt="Обложка книги">
              <?php if (User::isAdmin()): ?>
                <a href="?page=editBook&id=<?= $book->id ?>"
                   class="btn-floating btn-sm align-middle btn-discord"><i
                      class="fas fa-pencil-alt d-flex justify-content-center align-middle"></i></a>
              <?php endif; ?>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col">
                <h3 class="align-middle" style="font-weight: bold;"><?= $book->name ?></h3>
              </div>
                <?php if (User::isAuthorized()): ?>
                  <div class="col">
                      <?php if (History::getOneBookHistory($book->id, User::$id, 'queued') == null && !Books::isOwnedById($book->id, User::$id)): ?>
                        <div class="d-flex justify-content-end">
                          <button style="top: -12px;" type="button"
                                  class="btn btn-sm btn-discord btn-rounded my-3"
                                  onclick="queueTransfer(<?= $book->id ?>);">Встать в очередь
                          </button>
                        </div>
                      <?php elseif (Books::isOwnedById($book->id, User::$id)): ?>
                        <button style="top: -12px;" type="button"
                                class="btn btn-sm btn-discord btn-rounded my-3" disabled>Встать в
                          очередь
                        </button>
                      <?php else: ?>
                        <button style="top: -12px;" type="button"
                                class="btn btn-sm btn-custom3 btn-rounded my-3"
                                onclick="cancelQueue(<?= $book->id ?>);">Выйти из очереди
                        </button>
                      <?php endif; ?>
                  </div>
                <?php endif; ?>
            </div>
            <h5><?= $book->author // автору 0 лет (не баньте)                ?></h5>
            <h6>Рейтинг: <?= Books::countBookRating($book->id) ?> <i class="fas fa-star"></i></h6>
              <?php if (User::isAdmin()): ?>
                <p>Статус
                  книги: <?php if ($book->hidden) echo 'Скрыта от посторонних глаз'; else echo 'Доступна всем пользователям'; ?></p>
              <?php endif; ?>
            <br>
            <p><?= $book->desc ?></p>
            <br>
            <br>
            <p>Текущий обладатель: <?= User::getName(User::getUserById($book->owner)) ?></p>
          </div>
        </div>
        <br>
        <table class="table table-borderless text-white text-center">
          <thead class="elegant-color-dark text-white">
          <tr>
            <th scope="col">ФИ</th>
            <th scope="col">Статус</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($history as $item):
              $user = User::getUserById($item->user_id)
              ?>
            <tr>
              <th><a href="?page=profile&id=<?= $user->id ?>"
                     class="text-white"><?= User::getName($user) ?></a></th>
              <td><?= Books::statusToText($item->status) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <?php if ($page != 1): ?>
              <button class="btn btn-discord btn-rounded"
                      onclick="document.location.href='?book=<?= $book->id ?>&pageOffset=<?= $page - 1 ?>';">
                <i class="fas fa-arrow-left"></i>
              </button>
            <?php endif;
            if (History::countHistory($book->id) > $page * TemplateConfig::$historyPerPage): ?>
              <button class="btn btn-discord btn-rounded"
                      onclick="document.location.href='?book=<?= $book->id ?>&pageOffset=<?= $page + 1 ?>';">
                <i class="fas fa-arrow-right"></i>
              </button>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
    <?php Web::footer(); ?>
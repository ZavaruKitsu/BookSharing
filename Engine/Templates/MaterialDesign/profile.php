<?php

namespace Engine;

use Engine\Addons\Auth\Transfer;
use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;

$historyPage = 1;
$profileId = 1;
$isMine = false;

if (isset($_GET['id']))
    $profileId = $_GET['id'];
else
    if (User::isAuthorized())
        $profileId = User::$id;
    else
        ErrorsHandler::forbiddenError();

if ($profileId == User::$id)
    $isMine = true;

$user = User::getUserById($profileId);

if ($user == null)
    ErrorsHandler::notFoundError();

if (isset($_GET['historyOffset']))
    $historyPage = $_GET['historyOffset'];

$history = Addons\History\History::getUserBookHistoryById($profileId, $historyPage);


Web::header(); ?>
  <div class="container wh-55 p-3">
    <div class="row d-flex justify-content-center">
      <div class="col-md-6">
        <div class="card stylish-color-dark">
          <div class="card-body">
            <i class="fas fa-user-circle fa-4x d-flex justify-content-center"></i>
            <div style="min-height: 20px;"></div>
            <div class="row">
              <div class="col">
                <p class="text-center"><?= $user->first_name ?></p>
              </div>
              <div class="col">
                <p class="text-center"><?= $user->last_name ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>Роль:</p>
              </div>
              <div class="col">
                <p><?= User::roleToText($user->role) ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>Честность:</p>
              </div>
              <div class="col">
                <div class="row">
                  <div class="col">
                    <p><?= $user->honesty ?></p>
                  </div>
                  <div class="col">
                    <i class="fas fa-star"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>Дата регистрации</p>
              </div>
              <div class="col">
                <p><?= $user->reg_date ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>Книг прочитано:</p>
              </div>
              <div class="col">
                <p><?= User::countReadBooks($user->id) ?></p>
              </div>
            </div>
              <?php if (User::isAdmin()): ?>
                <div class="row">
                  <div class="col">
                    <p>ID</p>
                  </div>
                  <div class="col">
                    <p><?= $user->id ?></p>
                  </div>
                </div>
              <?php endif; ?>
            <div class="row d-flex justify-content-center align-middle">
              <div class="col">
                <br>
                <p class="align-middle">Контакты:</p>
              </div>
              <div class="col">
                  <?php if ($user->vk != ''): ?>
                    <a href="https://vk.com/<?= $user->vk ?>"
                       class="btn-floating btn-sm align-middle blue darken-2"><i
                          class="fab fa-vk d-flex justify-content-center align-middle"></i></a>
                  <?php endif;
                  if ($user->telegram != ''): ?>
                    <a href="tg://resolve?domain=<?= $user->telegram ?>"
                       class="btn-floating btn-sm align-middle blue darken-1"><i
                          class="fab fa-telegram-plane d-flex justify-content-center align-middle"></i></a>
                  <?php endif;
                  if ($user->vk == '' && $user->telegram == ''): ?>
                    <p class="text-center">(нет)</p>
                  <?php endif; ?>
                  <?php if ($isMine): ?>
                    <a id="modalActivate" data-toggle="modal"
                       data-target="#editContacts"
                       class="btn-floating btn-sm align-middle blue darken-1"><i
                          class="fas fa-pencil-alt d-flex justify-content-center align-middle"></i></a>
                  <?php endif; ?>
              </div>
                <?php if (User::isAdmin() && !$isMine): ?>
                    <?php if ($user->role != 'banned'): ?>
                    <button class="btn btn-custom3 btn-rounded" onclick="ban(<?= $profileId ?>);">
                      Забанить
                    </button>
                    <?php else: ?>
                    <button class="btn btn-custom2 btn-rounded" onclick="unBan(<?= $profileId ?>);">
                      Разбанить
                    </button>
                    <?php endif; endif; ?>
            </div>
          </div>
        </div>
      </div>
        <?php if ($isMine): ?>
          <div class="col-md-6">
            <div class="card stylish-color-dark">
              <div class="card-body text-white">
                <p class="d-flex justify-content-center">Ваши книги</p>
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                  <div class='table-responsive'>
                    <table class="table table-borderless text-white text-center">
                      <thead>
                      <tr>
                        <th scope="col d-flex justify-content-center">Название</th>
                        <th scope="col d-flex justify-content-center">Автор</th>
                        <th class="col d-flex justify-content-center">Действие</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach (Books::getOwnedById($profileId) as $book): ?>
                        <tr>
                          <td><a class="text-white"
                                 href="?book=<?= $book->id ?>"><?= $book->name ?></a></td>
                          <td><?= $book->author ?></td>
                          <td>
                              <?php
                              $transfer = Transfer::getQueuedTransfersByBookId($book->id);
                              if ($transfer == null || $transfer->status == 'completed'):
                                  ?>
                                <button type="button"
                                        class="btn btn-sm btn-discord btn-rounded my-3 text-center"
                                        data-toggle="modal" data-target="#transferBook"
                                        style="top: -21px;"
                                        onclick="setBookId(<?= $book->id ?>);">Передать
                                </button>
                              <?php else: ?>
                                <button type="button"
                                        class="btn btn-sm btn-discord btn-rounded my-3 text-center"
                                        data-toggle="modal" data-target="#transferBook"
                                        style="top: -21px;" disabled>Передать
                                </button>
                              <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
    </div>

    <br>
    <div class="card stylish-color-dark">
      <div class="card-body">
        <p class="d-flex justify-content-center">История книг</p>
        <div class='table-responsive'>
          <table class="table table-borderless text-light text-center">
            <thead>
            <tr>
              <th scope="col">Книга</th>
              <th scope="col">Автор</th>
              <th scope="col">Статус</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($history as $item):
                $book = Books::getById($item->book_id);
                if ($book->hidden && !User::isAdmin())
                    continue;
                ?>
              <tr>
                <td><a class="text-white"
                       href="?book=<?= $book->id ?>"><?= $book->name ?></a></td>
                <td class="align-middle"><?= $book->author ?></td>
                <td class="align-middle"><?= Books::statusToText($item->status) ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <div class="d-flex justify-content-center">
              <?php if ($historyPage != 1): ?>
                <button class="btn btn-discord btn-rounded"
                        onclick="document.location.href='?page=profile&id=<?= $profileId ?>&historyOffset=<?= $historyPage - 1 ?>';">
                  <i class="fas fa-arrow-left"></i>
                </button>
              <?php endif;
              if (Addons\History\History::countUserHistory($profileId) > $historyPage * TemplateConfig::$historyPerPage): ?>
                <button class="btn btn-discord btn-rounded"
                        onclick="document.location.href='?page=profile&id=<?= $profileId ?>&historyOffset=<?= $historyPage + 1 ?>';">
                  <i class="fas fa-arrow-right"></i>
                </button>
              <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="editContacts" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content stylish-color-dark text-white">
          <div class="modal-header d-flex justify-content-center">
            <h5 class="modal-title" id="exampleModalPreviewLabel">Редактирование контактной информации</h5>
          </div>
          <div class="modal-body">
            <div class="md-form">
              <i class="fas fa-at prefix"></i>
              <input type="text" id="telegramUsername" class="form-control text-white"
                     value="<?= User::$telegram ?>">
              <label for="telegramUsername">Имя пользователя Telegram (без @)</label>
            </div>
            <div class="md-form">
              <i class="fas fa-mug-hot prefix"></i>
              <input type="text" id="vkUrl" class="form-control text-white" value="<?= User::$vk ?>">
              <label for="vkUrl">Имя пользователя или ID ВКонтакте</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-discord btn-rounded my-3"
                    onclick="changeContacts('<?= User::$telegram ?>', '<?= User::$vk ?>');">Сохранить
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="transferBook" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content stylish-color-dark">
          <div class="modal-header d-flex justify-content-center">
            <h5 class="modal-title text-center" id="exampleModalPreviewLabel">Передача книги</h5>
          </div>
          <div class="modal-body">
            <div class="md-form">
              <i class="fas fa-user prefix"></i>
              <input type="text" id="usernameDist" class="form-control text-white">
              <label for="usernameDist">Имя пользователя</label>
            </div>
            <div class="md-form">
              <i class="fas fa-star prefix"></i>
              <input type="text" id="rating" class="form-control text-white">
              <label for="rating">Оценка (по 5-ти балльной системе)</label>
            </div>
            <input type="hidden" id="bookId" value="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-discord btn-rounded my-3" onclick="transferBook();">
              Отправить
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
    <?php
Web::footer();
?>
<?php

namespace Engine;

use Engine\Addons\Auth\User;
use Engine\Addons\Submit\Submit;

User::onlyForAdmins();

Web::header(); ?>
  <br>
  <div class="container">
    <div class="card">
      <div class="card-body stylish-color-dark white-text">
        <div class="table-responsive text-nowrap white-text">
          <table class="table text-center white-text">
            <thead class="black white-text">
            <tr>
              <th scope="col">Название</th>
              <th scope="col">Автор</th>
              <th scope="col">Пользователь</th>
              <th scope="col">Наличие описания</th>
              <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (Submit::getUnconfirmed() as $submit):
                $user = User::getUserById($submit->owner);
                ?>
              <tr>
                <th scope="row"><?= $submit->name ?></th>
                <td><?= $submit->author ?></td>
                <td onclick="document.location.href='?page=profile&id=<?= $user->id ?>';"><?= $user->login ?></td>
                <td onclick="loadDesc(<?= $submit->id ?>);"><?php if ($submit->desc != 'NO_DESC') echo 'Есть'; else echo 'Нет'; ?></td>
                <td>
                  <button type="button" class="btn btn-custom2 btn-rounded btn-sm"
                          onclick="confirmBook(<?= $submit->id ?>);">Подтвердить
                  </button>
                  <button id="modalTrigger" type="button" class="btn btn-custom3 btn-rounded btn-sm"
                          data-toggle="modal" data-target="#declineForm"
                          onclick="setId(<?= $submit->id ?>);">Отклонить
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <br>
  <!-- Modal -->
  <div class="modal fade" id="declineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content stylish-color-dark text-white">
        <div class="modal-header d-flex justify-content-center">
          <h5 class="modal-title" id="exampleModalPreviewLabel">Отклонение</h5>
        </div>
        <div class="modal-body">
          <div class="md-form">
            <input type="text" id="declineReason" class="form-control text-white">
            <label for="declineReason">Причина</label>
          </div>
        </div>
        <input id="submitId" type="hidden" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-custom3 btn-rounded" data-dismiss="modal"
                  onclick="declineBook();">Отклонить
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->

    <?php Web::footer(); ?>
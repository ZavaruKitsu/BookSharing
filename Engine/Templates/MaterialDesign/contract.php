<?php

namespace Engine;

use Engine\Addons\Auth\Transfer;
use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;

User::onlyForMembers();

if (!isset($_GET['transfer_id']))
    ErrorsHandler::notFoundError();

$transfer = Transfer::getTransferById($_GET['transfer_id']);
if ($transfer == null || $transfer->status != 'queued')
    ErrorsHandler::notFoundError();

if ($transfer->dist_id != User::$id)
    ErrorsHandler::notFoundError();

$book = Books::getById($transfer->book_id);

Web::header();
?>
  <br>
  <br>
  <div class="align-middle">
    <div class="d-flex justify-content-center">
      <div class="card text-white stylish-color-dark w-50">
        <div class="card-body">
          <p class="d-flex justify-content-center">
            Пользователь <?= User::getName(User::getUserById($book->owner)) ?> передал вам книгу
            "<?= $book->name ?>"</p>
          <br>
          <div class="status">
            <p class="d-flex justify-content-center">Состояние книги (пред. -
              "<?= Transfer::stateToText($book->state) ?>")</p>
            <!-- Group of material radios - Отличное -->
            <div class="variants d-flex justify-content-center stylish-color-dark">
              <ul class="list-group stylish-color-dark list-group-flush">
                <li class="list-group-item stylish-color-dark">
                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="great"
                           name="groupOfMaterialRadios" onclick="setState('great');">
                    <label class="form-check-label" for="great">Отличное</label>
                  </div>
                </li>
                <li class="list-group-item stylish-color-dark">
                  <!-- Group of material radios - Хорошое -->
                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="good"
                           name="groupOfMaterialRadios" onclick="setState('good');">
                    <label class="form-check-label" for="good">Хорошое</label>
                  </div>
                </li>
                <li class="list-group-item stylish-color-dark">
                  <!-- Group of material radios - Плохое -->
                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="bad"
                           name="groupOfMaterialRadios" onclick="setState('bad');">
                    <label class="form-check-label" for="bad">Плохое</label>
                  </div>
                </li>
                <li class="list-group-item stylish-color-dark">
                  <!-- Group of material radios - Ужасное -->
                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="terrible"
                           name="groupOfMaterialRadios" onclick="setState('terrible');">
                    <label class="form-check-label" for="terrible">Ужасное</label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <input type="hidden" id="state">
          <br>
          <div class="row">
            <div class="col d-flex justify-content-center">
              <button type="button" class="btn btn-custom2 btn-rounded"
                      onclick="transferAccept(<?= $_GET['transfer_id'] ?>);">Подтвердить
              </button>
            </div>
            <div class="col d-flex justify-content-center">
              <button type="button" class="btn btn-custom3 btn-rounded"
                      onclick="transferCancel(<?= $_GET['transfer_id'] ?>);">Отклонить
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>
    <?php
Web::footer(); ?>
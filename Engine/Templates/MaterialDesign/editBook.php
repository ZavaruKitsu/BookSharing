<?php

namespace Engine;

use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;

User::onlyForAdmins();

if (!isset($_GET['id']))
    ErrorsHandler::notFoundError();

$book = Books::getById($_GET['id']);

if ($book == null)
    ErrorsHandler::notFoundError();

Web::header();

?>
  <br>
  <br>
  <div class="container p-3">
    <div class="card">
      <div class="card-body text-white stylish-color-dark">
        <div class="row">
          <div class="col">
            <img src="<?= Vars::$web_dir . Config::$imgDir . $book->image ?>"
                 class="img-fluid d-flex justify-content-center" alt="Обложка книги">
            <form class="md-form">
              <div class="file-field">
                <div class="btn btn-discord btn-rounded my-3 btn-sm">
                  <span>Выберите обложку</span>
                  <input type="file" id="bookImage" accept=".jpg, .jpeg, .png">
                </div>
              </div>
            </form>
          </div>
          <div class="col">
            <div class="row">
              <div class="col">
                <div class="md-form">
                  <input type="text" id="bookName"
                         class="form-control input-pum white-text" value="<?= $book->name ?>">
                  <label for="bookName">Название</label>
                </div>
              </div>
            </div>
            <div class="md-form text-center">
              <input type="text" id="bookAuthor"
                     class="form-control input-pum white-text"
                     value="<?= $book->author // автору 0 лет (не баньте)                ?>">
              <label for="bookAuthor">Автор</label>
            </div>
            <div class="md-form">
                                    <textarea id="bookDesc" class="md-textarea form-control input-pum white-text"
                                              rows="15"><?= Helpers::reverseNewLines($book->desc) ?></textarea>
              <label for="bookDesc">Описание</label>
            </div>
            <div class="md-form">
              <input type="text" id="bookOwner"
                     class="form-control input-pum white-text" value="<?= $book->owner ?>">
              <label for="bookOwner">ID владельца (0 для указания 'ПУМ')</label>
            </div>
            <div class="switch">
              <label>
                Скрытие книги:
                <input id="bookHidden" type="checkbox" <?php if ($book->hidden) echo 'checked'; ?>>
                <span class="lever"></span>
              </label>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-custom2 btn-rounded my-3 btn-md"
                  onclick="editBook(<?= $_GET['id'] ?>);">Изменить
          </button>
        </div>
        <br>
      </div>
    </div>
  </div>
    <?php Web::footer(); ?>
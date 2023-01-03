<?php

namespace Engine;

use Engine\Addons\Auth\User;

User::onlyForAdmins();

Web::header();

?>
  <br>
  <br>
  <div class="container p-3">
    <div class="card">
      <div class="card-body text-white stylish-color-dark">
        <div class="row">
          <div class="col">
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
                         class="form-control input-pum white-text">
                  <label for="bookName">Название</label>
                </div>
              </div>
            </div>
            <div class="md-form text-center">
              <input type="text" id="bookAuthor"
                     class="form-control input-pum white-text">
              <label for="bookAuthor">Автор</label>
            </div>
            <div class="md-form">
                                    <textarea id="bookDesc" class="md-textarea form-control input-pum white-text"
                                              rows="15"></textarea>
              <label for="bookDesc">Описание</label>
            </div>
            <div class="md-form">
              <input type="text" id="bookOwner"
                     class="form-control input-pum white-text" value="0">
              <label for="bookOwner">ID владельца (0 для указания 'ПУМ')</label>
            </div>
            <div class="switch">
              <label>
                Скрытие книги:
                <input id="bookHidden" type="checkbox" checked>
                <span class="lever"></span>
              </label>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-custom2 btn-rounded my-3 btn-md"
                  onclick="addBook();">Добавить
          </button>
        </div>
        <br>
      </div>
    </div>
  </div>
    <?php Web::footer(); ?>
<?php

namespace Engine;

use Engine\Addons\Auth\User;

User::onlyForMembers();

Web::header(); ?>
  <div class="container w-55 p-3">
    <div class="row d-flex-justify-content-center">
      <div class="col-md">
        <div class="card stylish-color-dark">
          <div class="card-header">
            <p class="d-flex justify-content-center text-center h2">Заявка на добавление новой книги</p>
          </div>
          <div class="card-body">
            <div class="container">
              <div class="row">
                <div class="col">
                  <div class="inputname">
                    <div class="md-form">
                      <input type="text" id="submitName"
                             class="form-control input-pum white-text">
                      <label for="submitName">Название</label>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="inputauthor">
                    <div class="md-form">
                      <input type="text" id="submitAuthor"
                             class="form-control input-pum white-text">
                      <label for="submitAuthor">Автор</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="inputdesc">
                <div class="md-form">
                                    <textarea id="submitDesc" class="md-textarea form-control input-pum white-text"
                                              rows="5"></textarea>
                  <label for="submitDesc">Описание (необязательно)</label>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-custom2" onclick="submitBook();">Отправить заявку
                </button>
              </div>
              <div style="height: 50px;"></div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <?php Web::footer(); ?>
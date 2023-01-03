<!-- Modal -->
<div class="modal fade right" id="exampleModalPreview" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-full-height modal-right" role="document">
    <div class="modal-content stylish-color-dark">
      <div class="modal-header d-flex d-flex justify-content-center">
        <h5 class="modal-title" id="exampleModalPreviewLabel">Уведомления</h5>
      </div>
      <div class="modal-body">
          <?php

          use Engine\Addons\Auth\Transfer;
          use Engine\Addons\Auth\User;
          use Engine\Addons\Books\Books;
          use Engine\Addons\Submit\Submit;

          $transfers = Transfer::getUserTransfersById(User::$id);
          $submits = Submit::getSubmitsByUserId(User::$id);
          if ($transfers != null):
              foreach ($transfers as $transfer): ?>
                <br>
                <div class="card stylish-color">
                  <div class="card-header" style="height: 45px;">
                    <div class="row">
                      <div class="col">
                        <p class="d-flex justify-content-center">Передача</p>
                      </div>
                      <div class="col">
                        <div class="d-flex justify-content-end">
                          <button type="button" class="close text-white"
                                  aria-label="Закрыть"
                                  onclick="transferCancel(<?= $transfer->id ?>);">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <a class="text-discord"
                       href="?page=contract&transfer_id=<?= $transfer->id ?>">Пользователь <?= User::getName(User::getUserById(Books::getById($transfer->book_id)->owner)) ?>
                      передал вам книгу "<?= Books::getById($transfer->book_id)->name ?>"</a>
                  </div>
                </div>
              <?php endforeach; ?>
          <?php else: ?>
            <p>Запросов на передачу нет ! :(</p>
          <?php endif;
          if ($submits != null):
              foreach ($submits as $submit):
                  ?>
                <br>
                <div class="card stylish-color">
                  <div class="card-header" style="height: 45px;">
                    <div class="row">
                      <div class="col">
                        <p class="d-flex justify-content-center">Подтверждение</p>
                      </div>
                      <div class="col">
                        <div class="d-flex justify-content-end">
                          <button type="button" class="close text-white"
                                  aria-label="Скрыть"
                                  onclick="hideSubmit(<?= $submit->id ?>);">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <p>Ваш запрос на добавление книги
                      '<?= $submit->name ?>' был
                        <?php if ($submit->status == 'confirmed'): ?>
                          одобрен. Теперь вы значитесь как текущий владелец книги!
                        <?php else: ?>
                          отклонён по причине: '<?= $submit->reason ?>'.
                        <?php endif; ?>
                    </p>
                  </div>
                </div>
              <?php endforeach; ?>
          <?php endif; ?>
      </div>
    </div>
  </div>
</div>
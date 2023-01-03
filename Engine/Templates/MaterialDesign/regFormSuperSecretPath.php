<div class="d-flex justify-content-end">
  <!--Modal: Login / Register Form-->
  <div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
       aria-hidden="true">
    <div class="modal-dialog cascading-modal" role="document">
      <!--Content-->
      <div class="modal-content stylish-color-dark">

        <!--Modal cascading tabs-->
        <div class="modal-c-tabs">

          <!-- Nav tabs -->
          <ul class="nav nav-tabs md-tabs tabs-2 stylish-color-dark darken-3" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#panel7" role="tab"><i
                    class="fas fa-user mr-1"></i>
                Авторизация</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#panel8" role="tab"><i
                    class="fas fa-user-plus mr-1"></i>
                Регистрация</a>
            </li>
          </ul>

          <!-- Tab panels -->
          <div class="tab-content">
            <!--Panel 7-->
            <div class="tab-pane fade in show active" id="panel7" role="tabpanel">

              <!--Body-->
              <div class="modal-body mb-1">
                <div class="md-form form-sm mb-5">
                  <i class="fas fa-hard-hat prefix"></i>
                  <input type="text" id="authLogin"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="authLogin" class="label-pum active">Ваш логин</label>
                </div>
                <div class="md-form form-sm mb-4">
                  <i class="fas fa-lock prefix"></i>
                  <input type="password" id="authPassword"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="authPassword" class="label-pum">Ваш
                    пароль</label>
                  <div class="g-recaptcha d-flex justify-content-center"
                       data-sitekey="6LfmaJwaAAAAAAxT3DbprHVo41TmIrzYMYKTnDRA"
                       data-theme="dark" data-callback="onAuthHuman"></div>
                  <input type="hidden" id="authCaptcha" value="">
                </div>
                <div class="text-center mt-2">
                  <button class="btn btn-discord btn-rounded" onclick="validateAuthForm()">
                    Войти</i></button>
                </div>
              </div>
            </div>
            <!--/.Panel 7-->

            <!--Panel 8-->
            <div class="tab-pane fade" id="panel8" role="tabpanel">

              <!--Body-->
              <div class="modal-body">
                <div class="md-form form-sm mb-5">
                  <i class="fas fa-envelope prefix"></i>
                  <input type="email" id="regEmail"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="regEmail" class="label-pum">Ваша
                    почта</label>
                </div>

                <div class="md-form form-sm mb-5">
                  <i class="fas fa-hard-hat prefix"></i>
                  <input type="text" id="regLogin"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="regLogin" class="label-pum">Ваш логин</label>
                </div>

                <div class="md-form form-sm mb-5">
                  <i class="fas fa-hard-hat prefix"></i>
                  <input type="text" id="regFirst"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="regFirst" class="label-pum">Ваше имя</label>
                </div>

                <div class="md-form form-sm mb-5">
                  <i class="fas fa-hard-hat prefix"></i>
                  <input type="text" id="regLast"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="regLast" class="label-pum">Ваша фамилия</label>
                </div>

                <div class="md-form form-sm mb-5">
                  <i class="fas fa-lock prefix"></i>
                  <input type="password" id="regPassword"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="regPassword" class="label-pum">Ваш пароль</label>
                </div>

                <div class="md-form form-sm mb-4">
                  <i class="fas fa-lock prefix"></i>
                  <input type="password" id="regPassword2"
                         class="form-control form-control-sm input-pum text-white">
                  <label for="regPassword2" class="label-pum">Повторите пароль</label>
                  <div class="g-recaptcha d-flex justify-content-center"
                       data-sitekey="6LfmaJwaAAAAAAxT3DbprHVo41TmIrzYMYKTnDRA"
                       data-theme="dark" data-callback="onRegHuman"></div>
                  <input type="hidden" id="regCaptcha" value="">
                </div>
                <div class="text-center form-sm mt-2">
                  <button class="btn btn-discord btn-rounded" onclick="validateRegForm()">
                    Зарегистрироваться
                  </button>
                  <i class="fas fa-sign-in ml-1"></i>
                </div>

              </div>
            </div>
          </div>
          <!--/.Panel 8-->
        </div>

      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: Login / Register Form-->
<!-- Modal -->
<div class="text-center">
  <a href="" class="btn btn-discord btn-rounded my-3 btn-sm" data-toggle="modal"
     data-target="#modalLRForm">Войти/Зарегистрироваться</a>
</div>
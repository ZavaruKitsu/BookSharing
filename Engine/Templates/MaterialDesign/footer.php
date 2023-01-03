<?php

namespace Engine;

use Engine\Addons\Auth\User;

?>
</div>
<!-- Footer -->
<footer class="page-footer font-small stylish-color-dark pt-4">

  <!-- Footer Links -->
  <div class="container text-center text-md-left">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-4 mx-auto">

        <!-- Content -->
        <h5 class="text-uppercase font-weight-bold">Book Sharing</h5>
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto footer-line">
        <p>Бук шеринг Предуниверсария МАИ.</p>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      <!-- Grid column -->
      <div class="col-md-3 mx-auto">

        <!-- Links -->
        <h5 class="text-uppercase font-weight-bold">Социальные сети</h5>
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto footer-line">

        <ul class="list-unstyled">
          <li>
            <a href="https://discord.gg/CGFFP2H" class="text-light">Discord поддержки</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      <!-- Grid column -->
      <div class="col-md-3 mx-auto">

        <!-- Links -->
        <h5 class="text-uppercase font-weight-bold">Полезные ссылки</h5>
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto footer-line">

        <ul class="list-unstyled">
          <li>
            <a href="https://radolyn.com/" class="text-light">Сайт разработчиков</a>
          </li>
          <li>
            <a href="https://www.instagram.com/pum_purumpumpum/" class="text-light">Инстаграм пум пурум</a>
          </li>
          <li>
            <a href="?page=rules" class="text-light">Правила</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Contact Info -->
  <hr>
  <p class="py-3 text-center grey-text">Связь: <a class="text-light"
                                                  href="https://twitter.com/RadolynInc">Twitter</a> или <a
        class="text-light" href="mailto:helpdesk@radolyn.com">helpdesk@radolyn.com</a></p>

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2021 Авторское право:
    <a href="https://radolyn.com/" class="text-light"> Radolyn</a>. При размещении материалов на других сайтах ссылка
    необязательна. Icon by Icons8.
  </div>
  <!-- Copyright -->

</footer>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">

<link rel="stylesheet" href="<?= Vars::$web_dir ?>css/styles.css">

<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js" async defer></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" media="print"
      onload="this.media='all'">

<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" media="print"
      onload="this.media='all'">

<!-- Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap&subset=cyrillic-ext">

<!-- SCRIPTS -->
<script type="text/javascript" src="<?= Vars::$web_dir ?>js/az.js" async defer></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?= Vars::$web_dir ?>js/bootstrap.min.js"></script>
<!-- Lazy loader
<script src="//cdn.jsdelivr.net/blazy/latest/blazy.min.js"></script>-->

<?php
if (User::isAdmin()):
    ?>
  <!-- PUM powered admin scripts -->
  <script type="text/javascript" src="<?= Vars::$web_dir ?>js/az.admin.js" async defer></script>
<?php
endif;
?>

<?php
if (!User::isAuthorized()):
    ?>
  <!-- Google reCaptcha -->
  <script src="https://www.google.com/recaptcha/api.js?hl=ru" async defer></script>
<?php
endif;
?>

</body>
</html>
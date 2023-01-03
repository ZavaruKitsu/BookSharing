<?php


namespace Engine;

use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;

$page = 1;

if (isset($_GET['pageOffset']))
    $page = $_GET['pageOffset'];

if (!User::isAdmin())
    $books = Books::getByOffset($page);
else
    $books = Books::getByOffset($page, true);


Web::header();
?>
  <div class="container w-55 p-3">
    <?php foreach ($books

    as $book):
if (!$book->hidden):
    ?>
  <div class="card stylish-color-dark">
    <?php else: ?>
  <div class="card stylish-color">
      <?php endif; ?>
    <div class="card-body d-flex justify-content-center overflow-auto">
      <div class="row text-center">
        <div class="col-md">
          <img src="<?= Vars::$web_dir . TemplateConfig::$imgDir . $book->image ?>" class="rounded"

               onclick="document.location.href='?book=<?= $book->id ?>';" alt="Обложка книги">
        </div>
        <div class="col-md">
          <h3><a style="font-weight: bold;" href="?book=<?= $book->id ?>"
                 class="text-white"><?= $book->name ?></a></h3>
          <h5><?= $book->author // автору 0 лет (не баньте)                ?></h5>
          <h6>Рейтинг: <?= Books::countBookRating($book->id) ?> <i class="fas fa-star"></i></h6>
        </div>
        <div class="col-md">
          <p><?= Books::descShorten($book->desc); ?></p>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php endforeach; ?>
  <div class="d-flex justify-content-center">
      <?php if ($page != 1): ?>
        <button class="btn btn-discord btn-rounded"
                onclick="document.location.href='?page=catalog&pageOffset=<?= $page - 1 ?>';">
          <i class="fas fa-arrow-left"></i>
        </button>
      <?php endif;
      if (Books::countBooks(User::isAdmin()) > $page * TemplateConfig::$booksPerPage): ?>
        <button class="btn btn-discord btn-rounded"
                onclick="document.location.href='?page=catalog&pageOffset=<?= $page + 1 ?>';">
          <i class="fas fa-arrow-right"></i>
        </button>
      <?php endif; ?>
  </div>
  </div>
    <?php
Web::footer(); ?>
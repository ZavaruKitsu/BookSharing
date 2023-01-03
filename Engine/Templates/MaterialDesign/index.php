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
    <div class="card stylish-color">
      <div class="card-header d-flex justify-content-center align-middle overflow-auto">
        <h3 class="h3-responsive">ЦИТАТА</h3>
      </div>
      <div class="card-body d-flex justify-content-center overflow-auto">
        <h6 class="h6-responsive">"Книга не только сама является другом, она еще и находит для вас других друзей. Когда
          вы приняли книгу умом и душой, вы обогатились. Но когда вы передаете ее другим, вы обогащаетесь трижды. "
        </h6>
      </div>
      <div class="card-footer d-flex justify-content-end overflow-auto">
        <h5 class="h5-responsive">- Генри Миллер
          Книги в моей жизни (1969)</h5>
      </div>
    </div>
    <br>
    <div class="card stylish-color">
      <div class="card-header d-flex justify-content-center align-middle overflow-auto">
        <h3 class="h3-responsive">"Что такое Буккроссинг?"</h3>
      </div>
      <div class="card-body d-flex justify-content-center overflow-auto">
        <h6 class="h6-responsive">Буккроссинг (в переводе с английского — «перекрёстный обмен книгами») — это
          международное общественное движение любителей литературы. Его цель — «освободить» книги, то есть отпустить их
          в свободное плавание. Прочитав произведение, человек оставляет томик в людном месте — парке, кафе, вагоне
          метро. Случайный прохожий, который находит книгу, читает её и запускает процесс заново
          Каждой книге присваивается уникальный идентификатор, предоставляя возможность наблюдать, как книга
          путешествует из рук в руки. Таким образом проект объединяет читателей всего мира. В настоящее время 1 964 004
          буккроссеров и уже 13 149 147 книг, путешествующих по разным странам
          Мы решили создать буккросинг в ПУМе. Наши книги будут путешествовать между учениками и преподавателями ПУМа.
          "Как мы это делаем?"
          Отметь. Передай. Наблюдай. Вдохни новую жизни в книги! Вместо того, чтобы позволять вашим старым любимцам
          собирать пыль - передавайте их другим читателям. Пользователи имеют возможность помечать и отслеживать свои
          личные книги, поместив на них QR-код. Буккроссинг позволяет бесплатно присоединиться и получать удовольствие.
          Так что будьте смелее с вашими книгами - читайте и передавайте дальше.
        </h6>
      </div>
      <div class="card-footer d-flex justify-content-end overflow-auto">
        <h5 class="h5-responsive">- Дарья Юрьевна (Администратор проекта)</h5>
      </div>
    </div>
  </div>
    <?php Web::footer(); ?>
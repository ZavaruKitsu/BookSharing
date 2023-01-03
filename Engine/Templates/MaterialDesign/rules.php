<?php

namespace Engine;

Web::header();

?>

  <div class="container w-55 p-3">
    <div class="row d-flex justify-content-center">
      <div class="col-md-10">
        <div class="card stylish-color-dark">
          <div class="card-header" style="height: 40px;">
            <p class="text-center">Правила.</p>
          </div>
          <div class="card-body d-flex justify-content-center">
            <div class="variants d-flex justify-content-center stylish-color-dark">
              <ul class="list-group stylish-color-dark list-group-flush">
                  <?php
                  $i = 0;
                  foreach (TemplateConfig::$rules as $rule):
                      $i++; ?>
                    <li class="list-group-item stylish-color-dark">
                      <p>
                          <?= $i ?>. <?= $rule ?>
                      </p>
                    </li>
                  <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <?php
Web::footer();
?>
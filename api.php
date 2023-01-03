<?php


namespace Engine;

$api = true;
if (!isset($_POST['addon']) || !isset($_POST['action']))
    return;

require_once __DIR__ . '/Engine/Loader.php';

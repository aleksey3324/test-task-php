<?php
/**
  * Автор: Юдаев Алексей
  *
  * Дата реализации: 23.05.2022 00:00
  *
  * Дата изменения: 26.05.2022 17:20
  *
  * Утилита для работы с базой данных: PHPMyAdmin
*/

  require 'autload.php';

  $people = new People(1, 'ALeksey3324', '', '', '', '');

  $newPeople = $people->newFormatPeople($people->people, 'all');
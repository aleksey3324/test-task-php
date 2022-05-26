<?php
/**
  * Автор: Юдаев Алексей
  *
  * Дата реализации: 23.05.2022 00:00
  *
  * Утилита для работы с базой данных: PHPMyAdmin
*/

  spl_autoload_register(function ($class) 
  {
    include 'classes/' . $class . '.php';
  });
  
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

  class Db 
  {
    /**
      Класс для подключения к БД

      Реализует шаблон проектирования "Одиночка" для подключения к БД

      Если соединение с БД не установлено, то устанавливаем его, 
      иначе возвращаем установленное соединение
    */

    private static $_db = null;

    public static function getInstanse() {
      if(self::$_db == null)
        self::$_db = new PDO('mysql:host=localhost;dbname=test-task;port=3306', 'root', 'root');

        return self::$_db;
    }

    private function __construct() {}

  }
  
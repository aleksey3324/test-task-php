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

  class ContextLog
  {
    /**
      Класс для выведеня ошибки

      Реализует два метода получить и вывести ошибку

    */

    public $log = '';

    public function log($log)
    {
      $this->log = 'Ошибка: ' . $log;
    }

    public function showLog()
    {
      echo $this->log;
    }
  }
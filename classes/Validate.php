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

  require 'ContextLog.php';

  class Validate
  {
    /**
      Класс валидации с данных

      Проверяет данных на корректность, если что-то не корректно,
      выводи ошибку и возвращает exit.
    */

    public function __construct() {}

    public function validate($id, $name, $surname, $birthday_arr, 
      $gender, $city
    ) {
      /**
        Метод validate проверяет такие поля как id, на то, чтобы оно было не отрицательное,
        $name - только буквы, $surname - только буквы, $birthday_arr на корректность введённой даты,
        $gender - (0 или 1), $city - чтобы не был пустым. Если что-то не так, выводит соотстествующую ошибку.

        для проверкИ $name и $surname исспользуется метод "ctype_alpha", которые возвращает false, если
        строка содержит не только буквы

        для проверки даты исспользуется двойна провека, в первой проверяем, что в массиве должно быть 3 элемента а, 
        а также с поомщью метода "ctype_digit" проверяем, что все элементы являются числами. Далее исспользуем
        метод "checkdate" для проверки на корректность даты, а также, чтобы год был 4-х значным числом
    */

      $contextLog = new ContextLog();

      if(!ctype_digit($id)
         && ($id < 0)
        ) {
          $contextLog->log('Вы ввели неккоректное id(Положительное целое)');
          $contextLog->showLog();
  
          return exit;
        } else if (!ctype_alpha($name)) {
        $contextLog->log('Вы ввели неккоректное имя(Только буквы)');
        $contextLog->showLog();

        return exit;
        } else if (!ctype_alpha($surname)) {
          $contextLog->log('Вы ввели неккоректную фамилию(Только буквы)');
          $contextLog->showLog();
        
          return exit;
        } 

      if ((count($birthday_arr) != 3) 
           || (!ctype_digit($birthday_arr[0])) 
           || (!ctype_digit($birthday_arr[1])) 
           || (!ctype_digit($birthday_arr[2]))
      ) {
        $contextLog->log('Вы ввели неккоректное дату (дд.мм.гггг)');
        $contextLog->showLog();

        return exit;
      } else if (!checkdate($birthday_arr[1], $birthday_arr[0], $birthday_arr[2])
                 || ((strlen($birthday_arr[2]) != 4)))  {
        $contextLog->log('Вы ввели неккоректную дату (дд.мм.гггг)');
        $contextLog->showLog();

        return exit;
      } else if (($gender > 1)
                  || ($gender < 0)
      ) {
        echo gettype($gender) . '<br>';
        echo $gender;
        $contextLog->log('Вы ввели неккоректный пол (0 или 1)');
        $contextLog->showLog();

        return exit;
      } else if ($city == '') {
        $contextLog->log('Заполните поле Город проживания');
        $contextLog->showLog();

        return exit;
      }

    }
  }
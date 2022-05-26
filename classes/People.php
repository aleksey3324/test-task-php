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

  require 'Db.php';
  require 'Validate.php';

  class People
  {
    /**
      Класс для работы с БД

      Реализует такие методы: 
      1) сохранение полей экземпляра класса в БД;
      2) удаление человека из бд в соответствиии с id объекта;
      3) преобразование даты рождения в возраст;
      4) преобразование пола из двоичной системы в текстовую;
      5) конструктор класса создаёт человека в БД с заданной информацией,
      либо берёт информацию из БД по id;
      6) Форматирование человека с преобразованием возраста и (или) пола
      в зависимости от параметров (возвращает новый экземпляр StdClass со всеми полями изначального класса);

      Если соединение с БД не установлено, то устанавливаем его, 
      иначе возвращаем установленное соединение
    */

    private $_db = null;
    public $people = null;

    
    public function __construct($id, $name, $surname, 
      $birthday, $gender, $city) {
    /**
      Конструктор, устанавливает соединение с базой данных при создании объекта класса,
      если соединение ещё не установленно.

      Получаем количество объектов с текубщим id, если объект существует,
      записываем его в переменную $people.
      Иначе вызываем метод create для сохранение экземпряла класса в БД.
    */

      $this->_db = Db::getInstanse();

      $sql = 'SELECT COUNT(*) as count FROM peopels WHERE id = :id';

      $query = $this->_db->prepare($sql);
      $query->execute(['id' => $id]);

      $people = $query->fetch(PDO::FETCH_ASSOC);
      $count = $people['count'];

      if($count >= 1) { 
        $sql = 'SELECT * FROM `peopels` ORDER BY `id` = :id';
        $query = $this->_db->prepare($sql);
        $query->execute(['id' => $id]);

        $people = $query->fetch(PDO::FETCH_OBJ);
        $this->people = $people;
      } else {
        $this->create($id, $name, $surname, $birthday, 
          $gender, $city);
      }
    }

    public function create($id, $name, $surname, 
      $birthday, $gender, $city
    ) {
      /**
        Метод create служит для сохранения экземпляра класса в БД.

        Разбиваем стрроку на массив для дальнейшей валидации, создаём объект
        класса Validate для валидации текущих данных, если всё успешно, тогда
        преобразуем дату в нужный формат.

        отправляем в БД текущие поля
    */
      
      $birthday_arr = explode('.', $birthday);

      $validate = new Validate();
      $validate->validate($id, $name, $surname, $birthday_arr, 
        $gender, $city
      );

      $newBirthday = new DateTime($birthday);
      $newBirthday = $newBirthday->format('Y-m-d');
      
      try {
        $sql = 'INSERT INTO `peopels`(name, surname, birthday, gender, city) 
          VALUES (:name, :surname, :birthday, :gender, :city)';
      
        $query = $this->_db->prepare($sql);
        $query->execute([
          'name' => $name,
          'surname' => $surname,
          'birthday' => $newBirthday,
          'gender' => $gender,
          'city' => $city
        ]);
      } catch (DbException $e) {
        echo 'Ошибка: ' . $e;
      }
    }

    // получить возраст из даты рождения
    static public function getYear($birthday)
    {
      $birthday = new DateTime($birthday);
      $year = $birthday->diff(new DateTime());
      return $year->y;
    }

    // получить пол
    static public function  getGender($gender)
    {
      if($gender == 0) {
        $gender = 'Мужской';
      } else {
        $gender = 'Женский';
      }

      return $gender;
    }

    // удаление из бд
    public function delete($id)
    {
      $sql = 'DELETE FROM `peopels` WHERE `id` = :id';
      $query = $this->_db->prepare($sql);
      $query->execute(['id' => $id]);
    }

    public function newFormatPeople($people, $param) {
      switch($param) {
          case 'year': {
              $people->birthday	= People::getYear($people->birthday);
              return $people;
          }
          case 'gender': {
              $people->gender = People::getGender($people->gender);
              return $people;
          }
          case 'all': {
              $people->birthday	= People::getYear($people->birthday);
              $people->gender = People::getGender($people->gender);
              return $people;
          }
          default:
              break;
      }
    }

  }

<?php

header('Content-Type: application/json');

// По ошибке БД, использует тестовые данные.
$useMock = false;

$mockedJson = [];
$mockedJson['table'] = [
    'id' => 1,
    'name' => 'new',
    'date' => '2022.05.16',
];

// изображения
$mockedJson['imgs'] = [
    "https://omycod.ru/page/test/img/2.jpg",
    "https://omycod.ru/page/test/img/3.jpg",
    "https://omycod.ru/page/test/img/4.jpg",
];

try {
// соединение (как в условии)
    @$connect = new mysqli('server.mysql', 'user_mysql', '12345', 'some_db');

    if ($connect->connect_error) {
        echo json_encode(['error' => 'DB connection error']);
        exit;
    }

} catch (\Exception $e) {
    // ignore, cause no DB
    $useMock = true;
    unset($e);

} finally {
    if ($useMock) {
        $json = [];
        $json = @$_POST['arr'];

        // симуляция (как в задании)
        $json['table'] = $mockedJson['table'];

        // изображения
        $json['imgs'] = $mockedJson['imgs'];

        echo json_encode($json);
        exit;
    }

}


class UNI
{
    protected static $db;

    public static function init($connection)
    {
        self::$db = $connection;
    }

    // универсальный метод получения данных
    public static function get($sql)
    {
        $result = [];

        $query = self::$db->query($sql);

        if (!$query) {
            return $result;
        }

        while ($row = $query->fetch_assoc()) {
            $result[] = $row;
        }

        return $result;
    }
}

try {
// инициализация
    UNI::init($connect);
} catch (\Exception $e) {
    // ignore, cause no DB

    unset($e);
}

// ====== ОБРАБОТКА ======

if (isset($_POST['get']) && isset($_POST['arr']) && is_array($_POST['arr'])) {

    $json = $_POST['arr'];

    // пример запроса (как требовали)
    $get = UNI::get(
        "
        SELECT id, name, date 
        FROM table
        ORDER BY id DESC
        LIMIT 10
    "
    );

    // если бы была реальная БД
    // $json['table'] = $get;

    // симуляция (как в задании)
    $json['table'] = $mockedJson['table'];

    // изображения
    $json['imgs'] = $mockedJson['imgs'];

    echo json_encode($json);
    exit;

}

if (isset($_POST['someget'])) {

    echo json_encode(false);
    exit;

}

echo json_encode(['error' => 'Invalid request']);
exit;

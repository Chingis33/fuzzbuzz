<?php

// выводим форму
$echoForm  = '<form method = "POST">
                    <p>Введите урл для парсинга: <input name="url">
                    <input type="submit" value="Отправить"></p>
              </form>';
echo $echoForm;

$url = $_REQUEST['url'];

if ( !isset($url) ) {
    die;
}

// Ищем цены...
$html = file_get_contents($url);
$dom = new DOMDocument;
@$dom->loadHTML($html);
$spans = $dom->getElementsByTagName('span');
$costs = [];

foreach ($spans as $span) {
    if ($span->getAttribute('class') == 'pr_card-price') {
        $costs[] = intval($span->textContent);
    }
}

// Записываем данные в бд
try {
    //соединение с БД
    $dbUsername = 'root';
    $dbPassword = '';
    $dbcon = new PDO('mysql:host=localhost;dbname=mydb', $dbUsername, $dbPassword);
    $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = $dbcon->prepare('INSERT INTO price VALUES(:fieldName)');
    $data->bindParam(':fieldName', $cost);
    foreach ($costs as $cost) {
        $data->execute();
    }

    var_dump('Лог: были записаны цены: ', implode(', ', $costs));

} catch(PDOException $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

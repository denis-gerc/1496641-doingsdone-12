<?php

/**
 * Счетчик задач в проекте
 * @param array $count_task массив задач в каждом проекте
 * @param string $str_cat название задачи
 * @return string количество задач в проекте, где нет задач возвращаем 0
 */

function countTask($count_task, $str_cat)
{
    if ($count_task) {
        foreach ($count_task as $key => $value) {
            foreach ($value as $k => $v) {
                if ($value['proj_name'] === $str_cat) {
                    return $value['count'];
                }
            }
        }
    }
    return 0;
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}


/**
 * Подсчет количества дней до выполнения задачи
 * @param string $task_end дата выполнения задачи
 * @return string итоговый результат - количество дней до выполнения задачи
 */

function dateTask($task_end)
{
    if (!empty($task_end)) {
        $secs_in_day = 86400; // 24 часа = 86400 секунд
        $now_ts = time(); //текущая метка timestamp
        $end_ts = strtotime($task_end); // дата выполнения задачи timestamp
        $ts_diff = floor(($end_ts - $now_ts) / $secs_in_day); // количество оставшихся дней до выполнения задачи
        return $ts_diff;
    } else {
        return false;
    }
}


/**
 * Выводит результат запроса sql в виде массива
 * @param string $sql запрос к БД
 * @param string $sql_table таблица в БД к которой формируется запрос
 * @param array $connect ассоциативный массив с параметрами для подключения к БД
 * @return array двумерный ассоциативный массив, результат запроса sql
 */

function resQuerySQL($sql, $connect)
{
    // Получаем ресурс результата
    $result = mysqli_query($connect, $sql);

    // Проверим результат извлечения данных
    if ($result) {
        $sql_table = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // $sql_table = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    // Возвращаем результат запроса в виде массива
    return $sql_table;
}

/**
 * Выводит результат подготовленного запроса sql в виде массива
 * @param string $smt подготовленное выражение
 * @return array двумерный ассоциативный массив, результат подготовленного запроса sql
 */

function resPreparedQuerySQL($connect, $stmt)
{
    // Выполнение подготовленного запроса
    mysqli_stmt_execute($stmt);

    // Получим результат из подготовленного запроса
    $res = mysqli_stmt_get_result($stmt);

    // Двумерный ассоциативный массив
    // $res = mysqli_fetch_all($res, MYSQLI_ASSOC);

    // Одномерный ассоциативный массив
    $res = mysqli_fetch_array($res, MYSQLI_ASSOC);

    return $res;
}

function resPreparedQuerySQL1($connect, $stmt)
{
    // Выполнение подготовленного запроса
    mysqli_stmt_execute($stmt);

    // Получим результат из подготовленного запроса
    $res = mysqli_stmt_get_result($stmt);

    // Двумерный ассоциативный массив
    $res = mysqli_fetch_all($res, MYSQLI_ASSOC);

    // Одномерный ассоциативный массив
    // $res = mysqli_fetch_array($res, MYSQLI_ASSOC);

    return $res;
}

/**
 * Выводит результат запроса sql из указанной таблицы в виде массива для одного ряда выборки
 * @param string $sql запрос к БД
 * @param string $sql_table таблица в БД к которой формируется запрос
 * @param array $connect ассоциативный массив с параметрами для подключения к БД
 * @return array одномерный ассоциативный массив сформированный на основании запроса $sql
 */

function resQueryUser($sql, $connect)
{
    // Получаем ресурс результата
    $result = mysqli_query($connect, $sql);

    // Проверим результат извлечения данных
    if ($result) {
        $sql_table = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    // Возвращаем результат запроса в виде массива
    return $sql_table;
}

/**
 * Выводит количество выбранных рядов для sql запроса SELECT
 * @param string $sql запрос к БД
 * @param array $connect ассоциативный массив с параметрами для подключения к БД
 * @return int $num_rows количест рядов выборки сформированный на основании запроса $sql
 */

function sqlNumRows($sql, $connect)
{
    $result = mysqli_query($connect, $sql);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}

/**
 * Запоминаем заполненные поля формы при наличии ошибок в полях
 * @param string $data значение полей в форме, передаются методом $_POST
 * @param array $connect ассоциативный массив с параметрами для подключения к БД
 * @return string $data значение полей в форме
 */

function postValue($data)
{
    if (isset($data) && strlen(trim($data)) > 0) {
        return $data;
    }
}

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else if (is_string($value)) {
                $type = 's';
            } else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

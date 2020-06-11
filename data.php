<?php

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// Устанавливаем time зону по умолчанию
date_default_timezone_set("Europe/Moscow");

// Данные для подключения к БД
$db = [
	'host' 		=> 'localhost',
	'user' 		=> 'root',
	'password' 	=> '',
	'database' 	=> 'doingsdone',
];

// Соединимсяс БД
$connect = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

// Установим кодировку для обмена данными пользователь -> БД
mysqli_set_charset($connect, "utf8");

// Проверка соединения с БД
if (!$db) {
	print('Ошибка подключения к БД: ' . mysqli_connect_error());
};

// Выборка всех проектов из БД
$sql_proj = 'SELECT `user_id`, `proj_id`, `proj_name` FROM project';

// Получаем результат запроса всех проектов в виде массива
$categories = resQuerySQL($sql_proj, $project, $connect);

// Выборка задач из БД только активного проекта по значению $_GET['id']
$sql_task = 'SELECT `proj_name`, `status_task`, `title_task`, `link_file`, `date_task_end` 
FROM user_reg u, project p, task t 
WHERE p.proj_id = t.proj_id 
AND u.user_id = t.user_id ';

// Выборка всех задач из БД для счетчика задач в проектах
$sql_tasks = 'SELECT `proj_name`, `status_task`, `title_task`, `link_file`, `date_task_end` 
FROM user_reg u, project p, task t 
WHERE p.proj_id = t.proj_id 
AND u.user_id = t.user_id ';

// условие для выборки задач из БД по значению $_GET['id']
if (!empty($_GET['id'])) {
	$sql_task .= "AND p.proj_id = '{$_GET['id']}'";
};

// Получим результат запоса задач из БД для одного проекта в виде массива
$task_list = resQuerySQL($sql_task, $task, $connect);

// Получим результат запоса всех задач из БД в виде массива для счетчика задач во всех проектах
$tasks_list = resQuerySQL($sql_tasks, $task, $connect);








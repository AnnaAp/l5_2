<html>
<head>
	<meta charset="UTF-8">
	<title>Дом.задание 5.2</title>
</head>
<body>
<a href="tasks.php">Список</a>
<h1>Изменение задачи</h1>
<form action="?/task/update/id/<?= $task['id']?>/" method="post">
	<p>Описание: <input type="text" name="description" value="<?= $task['description']?>"></p>
	<p><input type="submit" value="Сохранить"></p>
</form>

</body>
</html>
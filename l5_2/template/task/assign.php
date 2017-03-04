<html>
<head>
	<meta charset="UTF-8">
	<title>Дом.задание 5.2</title>
</head>
<body>
<a href="tasks.php">Список</a>
<!--<b>Назначить задачу "--><?//= $params['description'] ?><!--"</b>-->
<h2>Назначить задачу </h2>
<form action="?/task/assign/id/<?= $params['id']?>/" method="post">
	<label for="assignedUser">Выбор исполнителя:</label>
	<select name="assignedUser" title="Выбрать исполнителя">
		<option value=0>Не задано</option>
		<?php foreach (UserList() as $record) { ?>
			<option value=<?= $record['id'] ?>><?= $record['login'] ?></option>
		<?php } ?>
	</select>
	<p><input type="submit" value="Сохранить"></p>
</form>

</body>
</html>
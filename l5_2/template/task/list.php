<html>
<head>
	<meta charset="UTF-8">
	<title>Дом.задание 5.2</title>
</head>
<body>
<p><a href="?/task/add/">Добавить задачу</a></p>
<table border="1">
	<tr>
		<th>Статус</th>
		<th>Дата добавления</th>
		<th>Описание</th>
		<th>Исполнитель</th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach ($tasks as $task) { ?>
		<tr>
			<td><?= getTextStatus($task['is_done'])?></td>
			<td><?= $task['date_added']?></td>
			<td><?= $task['description']?></td>
			<td><?= $task['ass_user']?></td>
			<td><a href="?/task/delete/id/<?= $task['id']?>/">Удалить</a></td>
			<td><a href="?/task/update/id/<?= $task['id']?>/">Изменить</a></td>
		</tr>
	<?php } ?>
</table>

</body>
</html>
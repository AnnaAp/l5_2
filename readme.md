# Установка

1.В корневой директории размещен файл **config.php** , где в полях массива mysql  указать параметры доступа к базе данных , в поле dirProject  - директорию ,в которой размещено приложение.
2.В файле faq.sql  находиться дамп БД  ,который необходимо развернуть в базе данных.
3.Для работы приложения необходимо установить библиотеки : twig и monolog
  •	composer require twig/twig:~1.0
  •	composer require monolog/monolog
4.Вход в административную панель по логину и паролю admin/admin.
<?php

class TaskController
{
    private $model = null;
    private $twig = null;

    function __construct($db)
    {
        include 'model/Task.php';
        $this->model = new Task($db);
        $this->twig = include 'lib/twig.php';
    }

    /**
     * Отображаем шаблон
     * @param $template
     * @param $params
     */
    private function render($template, $params = [])
    {
        $fileTemplate = 'template/' . $template;
        if (is_file($fileTemplate)) {
            ob_start();
            if (count($params) > 0) {
                extract($params);
            }
            include $fileTemplate;
            return ob_get_clean();
        }
    }

    /**
     * Форма добавление книги
     * @param $params array
     * @return mixed
     */
    function getAdd()
    {
        echo $this->render('task/add.php');
    }

    /**
     * Добавление книги
     * @param $params array
     * @return mixed
     */
    function postAdd($params, $post)
    {
        $updateParam = [];

        if (!empty($post['description']) && (!empty($params['user_id']))) {
            $idAdd = $this->model->add([
                'description' => $post['description'],
                'user_id' => $params['user_id'],

            ]);
//            if ($idAdd) {
//                header('Location: tasks.php');
//            }
        }
        header('Location: tasks.php');
    }

    /**
     * Удаление книги
     * @param $id
     */
    public function getDelete($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $isDelete = $this->model->delete($params['id']);
            if ($isDelete) {
                header('Location:tasks.php');
            }
        }
    }

    public function getClose($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $isDelete = $this->model->close($params['id']);
//            if ($isDelete) {
//                header('Location:tasks.php');
//            }
        }
        header('Location:tasks.php');
    }

    /**
     * Форма редактирование данных
     * @param $id
     */

    public function getUpdate($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $task = $this->model->find($params['id']);
            echo $this->render('task/update.php', ['task' => $task]);
        }
    }

    public function getAssign($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            echo $this->render('task/assign.php', ['params' => $params]);
        }
    }

    /**
     * Изменение данных о книге
     * @param $id
     */

    public function postUpdate($params, $post)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $updateParam = [];
            if (!empty($post['description'])) {
                $updateParam['description'] = $post['description'];
                $isUpdate = $this->model->update($params['id'], $updateParam);
            }
//            if ($isUpdate) {
//                header('Location: tasks.php');
//            }
        }
        header('Location: tasks.php');
    }

    public function postAssign($params, $post)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            if (!empty($post['assignedUser'])) {
                $updateParam['assigned_user_id'] = $post['assignedUser'];
                $isUpdate = $this->model->update($params['id'], $updateParam);
            }
//            if ($isUpdate) {
//                header('Location: tasks.php');
//            }
        }
        header('Location: tasks.php');
    }

    /**
     * Получение всех книг
     * @return array
     */
    public function getList_()
    {
        $tasks = $this->model->findAll();
        echo $this->render('task/list.php', ['tasks' => $tasks]);
    }

    public function getList($params)
    {
        $tasks = $this->model->findAll($params['user_id']);
        $tasks2 = $this->model->findAssign($params['user_id']);
//
        echo $this->twig->render('tasks.html', ['tasks' => $tasks, 'tasks2' => $tasks2]);


    }

}
<?php


class Task
{
    private $db = null;

    function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Добавление
     * @param $params array
     * @return mixed
     */

    function add($params)
    {
        $sth = $this->db->prepare(
            'INSERT INTO task (description,is_done,date_added,user_id) VALUES (:description,0,SYSDATE(),:user_id)');

        $sth->bindValue(':description', $params['description'], PDO::PARAM_STR);
        $sth->bindValue(':user_id', $params['user_id'], PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Удаление
     * @param $id int
     * @return mixed
     */
    function delete($id)
    {
        $sth = $this->db->prepare('DELETE FROM `task` WHERE id=:id');
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        return $sth->execute();
    }

    function close($id)
    {
        $sth = $this->db->prepare('UPDATE `task` SET is_done = 1 WHERE id=:id');
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * @param $id int
     * @param $params array
     * @return mixed
     */
    function update($id, $params)
    {
        if (count($params) == 0) {
            return false;
        }
        $update = [];
        foreach ($params as $param => $value) {
            $update[] = $param . '`=:' . $param;
        }
        $sth = $this->db->prepare('UPDATE `task` SET `' . implode(', `', $update) . ' WHERE `id`=:id');

        if (isset($params['description'])) {
            $sth->bindValue(':description', $params['description'], PDO::PARAM_STR);
        }
        if (isset($params['assigned_user_id'])) {
            $sth->bindValue(':assigned_user_id', $params['assigned_user_id'], PDO::PARAM_INT);
        }
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Получение всех
     * @return array
     */
    public function findAll($user_id, $sort = 1)
    {
        $sth = $this->db->prepare('
        SELECT t.id,description,is_done,date_added,u.login AS ass_user
          FROM task  t
          LEFT JOIN user  u ON u.id = t.assigned_user_id
          WHERE t.user_id =:user_id
          ORDER BY :sort');
        $sth->bindValue(':sort', $sort, PDO::PARAM_INT);
        $sth->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);

        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }

    /**
     * Получение одной
     * @param $id int
     * @return array
     */
    public function find($id)
    {
        $sth = $this->db->prepare('SELECT `id`,`description` FROM `task` WHERE id=:id');

        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findAssign($user_id, $sort = 1)
    {
        $sth = $this->db->prepare('
        SELECT t.id,description,is_done,date_added,u.login AS auth
           FROM task  t ,user  u
           WHERE
           t.assigned_user_id =:user_id AND
           t.assigned_user_id=u.id
           ORDER BY :sort');
        $sth->bindValue(':sort', $sort, PDO::PARAM_INT);
        $sth->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);

        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }
}
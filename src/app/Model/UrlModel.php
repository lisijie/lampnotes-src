<?php
namespace App\Model;

use Core\Model;

class UrlModel extends Model
{

    protected $tableName = '#table_url';

    public function add($hash, $topicId)
    {
        if (empty($hash) || $topicId < 1) return false;
        return $this->insert(array(
            'hash' => $hash,
            'topic_id' => intval($topicId),
        ));
    }

    public function getTopicIdsByHash($hash)
    {
        $list = $this->select(array('topic_id'), array('hash'=>$hash));
        $result = array();
        foreach ($list as $row) {
            $result[] = $row['topic_id'];
        }
        return $result;
    }

    public function del($topicId)
    {
        return $this->delete(array('topic_id' => intval($topicId)));
    }
}
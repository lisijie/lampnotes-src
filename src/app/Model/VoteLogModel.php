<?php
namespace App\Model;

use Core\Model;

class VoteLogModel extends Model
{

    protected $tableName = '#table_vote_log';

    public function add($data)
    {
        return $this->insert($data);
    }

    public function get($topicId, $userId)
    {
        return $this->getRow(array('topic_id' => $topicId, 'user_id' => $userId));
    }

    public function getVoteStatus($userId, array $topicIds)
    {
        return $this->select(array('topic_id', 'vote_time'), array('user_id' => $userId, 'topic_id' => $topicIds));
    }

}
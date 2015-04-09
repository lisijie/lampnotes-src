<?php
namespace App\Model;

use Core\Model;

class CommentModel extends Model
{

	protected $tableName = '#table_comments';

	public function add($data)
	{
		return $this->insert($data);
	}

	public function getListByTopicId($topicId, $page, $pageSize)
	{
		return $this->page(array(), array('topic_id'=>$topicId), array('id'=>'asc'), $page, $pageSize);
	}

}
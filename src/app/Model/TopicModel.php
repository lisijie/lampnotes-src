<?php
namespace App\Model;

use Core\Model;

class TopicModel extends Model
{

    protected $tableName = '#table_topics';

	public function addTopic($data)
	{
        return $this->insert($data);
	}

    public function getTopicById($topicId)
    {
        return $this->getRow(array('id'=>$topicId));
    }

    public function getTopicListByIds(array $topicIds, $fields = array())
    {
        if (!empty($fields) && !in_array('id', $fields)) $fields[] = 'id';
        $list = $this->select($fields, array('id' => $topicIds));
        $result = array();
        foreach ($list as $row) {
            $result[$row['id']] = $row;
        }
        return $result;
    }

    public function getHotTopicList($page, $pageSize)
    {
        $fields = $filter = $order = array();
        $order = array('hot_score' => 'desc', 'id'=>'desc');
        return $this->page($fields, $filter, $order, $page, $pageSize);
    }

    public function getNewTopicList($page, $pageSize)
    {
        $fields = $filter = $order = array();
        $order = array('id' => 'desc');
        return $this->page($fields, $filter, $order, $page, $pageSize);
    }

    public function getSpecialTopicList($specialType, $page, $pageSize)
    {
        $fields = array();
        $filter = array('special_type' => $specialType);
        $order = array('hot_score' => 'desc', 'update_time'=>'desc');
        return $this->page($fields, $filter, $order, $page, $pageSize);
    }

    public function getTotalNum()
    {
        return $this->count();
    }

    public function getSpecialTotalNum($specialType)
    {
        return $this->count(array('special_type' => $specialType));
    }

	public function updateTopic($id, $data)
	{
		return $this->update($data, array('id'=>$id));
	}

	public function incrementField($id, $field, $value = 1)
	{
		$value = intval($value);
		$sql = "UPDATE {$this->tableName} SET `{$field}` = `{$field}` + {$value} WHERE id = " . intval($id);
		return $this->db->execute($sql);
	}

}
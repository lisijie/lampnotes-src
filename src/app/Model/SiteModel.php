<?php
namespace App\Model;

use Core\Model;

class SiteModel extends Model
{

    protected $tableName = '#table_site';

    public function add($data)
    {
        return $this->insert($data);
    }

    public function getByDomain($domain)
    {
        return $this->getRow(array('domain' => $domain));
    }

    public function getListByScore($num)
    {
        return $this->select(array(), array(), array('score'=>'desc'), $num);
    }

    /**
     * 自增
     *
     * @param $id
     * @param $field
     * @param int $value
     * @return int
     */
    public function incrementField($id, $field, $value = 1)
    {
        $value = intval($value);
        $sql = "UPDATE {$this->tableName} SET `{$field}` = `{$field}` + {$value} WHERE id = " . intval($id);
        return $this->db->execute($sql);
    }
}
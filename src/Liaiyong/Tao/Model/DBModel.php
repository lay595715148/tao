<?php
namespace Liaiyong\Tao\Model;

use Liaiyong\Tao\App\Model;
use Liaiyong\Tao\DB\Table;
use Liaiyong\Tao\DB\Primarily;
use Liaiyong\Tao\DB\Database;

abstract class DBModel extends Model implements Table, Primarily {
	//@Override
	public function capable() {
		return $this->db();
	}
	/**
	 * 数据库操作对象
	 * @return Database
	 */
	public abstract function db();
    /**
     * 模型属性名与对应数据表字段的映射关系数组
     * @return array
     */
	public abstract function mapping();
}
<?php
namespace Liaiyong\Tao\Model;

use Liaiyong\Tao\Model\DBModel;
use Liaiyong\Tao\DB\Mysql;

abstract class MysqlModel extends DBModel {
	//@Override
	public function db() {
		return $this->mysql();
	}
	/**
	 * 数据库操作对象
	 * @return Mysql
	 */
	public abstract function mysql();
}
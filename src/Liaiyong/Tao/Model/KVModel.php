<?php
namespace Liaiyong\Tao\Model;

use Liaiyong\Tao\App\Model;
use Liaiyong\Tao\DB\Table;
use Liaiyong\Tao\DB\Primarily;
use Liaiyong\Tao\DB\Database;

abstract class KVModel extends Model implements Primarily {
	//@Override
	public function capable() {
		return $this->kv();
	}
	/**
	 * 数据库操作对象
	 * @return Database
	 */
	public abstract function kv();
}
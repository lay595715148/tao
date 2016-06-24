<?php
namespace Liaiyong\Tao\App;

use Liaiyong\Tao\Core\Capable;

abstract class Model extends Component implements Capable {
	/**
	 * 
	 * @return Capable
	 */
	public abstract function capable();
	//@Override
	public function get($id) {
		return $this->capable()->get($id);
	}
	//@Override
    public function del($id) {
		return $this->capable()->del($id);
    }
	//@Override
    public function add(array $info) {
		return $this->capable()->add($info);
    }
	//@Override
    public function upd($id, array $info) {
		return $this->capable()->upd($id, $info);
    }
}
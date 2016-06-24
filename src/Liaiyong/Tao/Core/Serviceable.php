<?php
namespace Liaiyong\Tao\Core;

use Liaiyong\Tao\App\Model;
use Liaiyong\Tao\Core\Capable;

interface Serviceable extends Capable {
    /**
     * 默认Model对象
     * @return Model
     */
    public function model();
}
// PHP END
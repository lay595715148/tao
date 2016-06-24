<?php
namespace Liaiyong\Tao\DB;

interface Uniquely {
    /**
     * 数据库表唯一索引键字段名数组.<br>
     * <pre>
     * return array(
     *   'name1' => 'field'
     *   'name2' => array('field1' , 'field2')
     * );
     * </pre>
     * @return array
     */
    public function uniques();
}
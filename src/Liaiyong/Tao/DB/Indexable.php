<?php
namespace Liaiyong\Tao\DB;

interface Indexable {
    /**
     * 数据库索引键字段名数组.<br>
     * <pre>
     * return array(
     *   'name1' => 'field1',
     *   'name2' => 'field2'
     * );
     * </pre>
     * @return array
     */
    public function indexes();
}
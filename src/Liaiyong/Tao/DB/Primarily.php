<?php
namespace Liaiyong\Tao\DB;

interface Primarily {
    /**
     * 返回数据库表主键字段名.<br>
     * 1.<pre>
     * return 'field';
     * </pre>
     * 2.<pre>
     * return array('field1' , 'field2');
     * </pre>
     * @return string|array
     */
    public function primary();
}
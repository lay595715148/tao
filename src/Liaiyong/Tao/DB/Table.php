<?php
namespace Liaiyong\Tao\DB;

interface Table {
    /**
     * 数据表名或其他数据库中的集合名称
     * @return string
     */
    public function table();
    /**
     * 应数据表字段数组
     * @return array
     */
    public function columns();
    /**
     * 数据表所在数据库名
     * @return string
     */
    public function schema();
}
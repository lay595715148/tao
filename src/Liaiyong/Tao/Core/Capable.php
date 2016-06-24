<?php
namespace Liaiyong\Tao\Core;

interface Capable {
    /**
     * 获取单条数据
     * @param int|string $id ID
     * @return array
     */
    public function get($id);
    /**
     * 删除单条数据
     * @param int|string $id ID
     * @return boolean
     */
    public function del($id);
    /**
     * 新增单条数据
     * @param array $info 数据数组
     * @return boolean|int|string
     */
    public function add(array $info);
    /**
     * 更新单条数据
     * @param int|string $id ID
     * @param array $info 数据数组
     * @return boolean
     */
    public function upd($id, array $info);
}
// PHP END
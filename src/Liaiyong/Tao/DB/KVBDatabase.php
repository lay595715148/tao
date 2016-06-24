<?php
namespace Liaiyong\Tao\DB;

abstract class KVDatabase implements Capable {
    /**
     * 连接数据库
     * @return boolean
     */
    public abstract function connect();
    /**
     * 关闭数据库连接
     * @return boolean
     */
    public abstract function close();
}
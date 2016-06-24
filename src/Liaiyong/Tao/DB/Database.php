<?php
namespace Liaiyong\Tao\DB;

abstract class Database implements Capable {
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
    /**
     * 查询数据库，执行操作
     * @return mixed
     */
	public abstract function query($sql);
}
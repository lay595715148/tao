<?php
namespace Liaiyong\Tao\Core;

abstract class Context {
    /**
     * 获取静态资源包
     * @return Assets
     */
	public abstract function getAssets();
    /**
     * 获取动态资源包
     * @return Resources
     */
	public abstract function getResources();
    /**
     * 获取全局应用上下文
     * @return Context
     */
	public abstract function getApplicationContext();
	/**
	 * 设置当前上下的主题
	 * @param string $themeid
	 */
	public abstract function setTheme($themeid);
    /**
     * 获取应用包名，即命名空间
     * @return string
     */
	public abstract function getPackageName();
    /**
     * 在当前上下文件下，获取应用信息
     * @return string
     */
	public abstract function getApplicationInfo();
    /**
     * 获取应用运行环境信息
     * @return int
     */
	public abstract function getEnvironment();
}
<?php
namespace Liaiyong\Tao\Yaf;

use Yaf\Application;
use Yaf\Bootstrap_Abstract;
use Yaf\Dispatcher;
use Yaf\Registry;
use Yaf\Session;

use Liaiyong\Tao\Base\ClassAutoloader;
use Liaiyong\Tao\Redis\SessionHandler;

/**
 * 类中所有以"_init"开头的公有的方法, 都会被按照定义顺序依次在Yaf_Application::bootstrap() 被调用的时刻调用.
 */
abstract class Bootstrap extends Bootstrap_Abstract {
	public function _initConfig(Dispatcher $dispatcher) {
        $config = Application::app()->getConfig();
        Registry::set("config", $config);
    }
    public function _initLoader() {
    }

    public function _initDefaultName(Dispatcher $dispatcher) {
        $dispatcher->setDefaultModule("Index")->setDefaultController("Index")->setDefaultAction("index");
    }

	/**
	 * 初始化session到Redis数据库中。
	 * --------------------------------------
	 * 1、实现SessionHandlerInterface接口，将session保存到Redis数据库中。
	 * 2、重新开启session，让默认的session切换到自已的session接口。
	 * 3、第二步中直接影响Yaf\Session的工作方式。
	 * 4、SESSION在多机情况下会有小概率出现生成的SESSION ID冲突的情况。
	 * 5、可以使用代理机器来生成SESSION或单独使用一台机专门生产SESSION ID。
	 * 6、或者直接关闭SESSION的使用。
	 * --------------------------------------
	 */
    public function _initSession(Dispatcher $dispatcher) {
    	//$cache = YCore::getCache();
    	/*$redis = 
		// 为了防止WEB集群下SESSION冲撞问题，特此设置前缀区分。
		$prefix = 'sess_' . ip2long($_SERVER['SERVER_ADDR']) . '_';
		$sess = new SessionHandler($cache, null, $prefix);
		session_set_save_handler($sess);
		$session = \Yaf\Session::getInstance();
		\Yaf\Registry::set('session', $session);*/
    }
}
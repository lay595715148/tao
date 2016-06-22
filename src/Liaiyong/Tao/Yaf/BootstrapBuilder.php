<?php
namespace Liaiyong\Tao\Yaf;

use Yaf\Application;
use Yaf\Loader;

use Liaiyong\Tao\Base\ClassAutoloader;

final class BootstrapBuilder {
	public static function start($appClassName, $classPath, $rootPath, $docPath, $ignore = '') {
		echo "<pre>";
		print_r(get_declared_classes());exit;
		ClassAutoloader::register($classPath, $ignore);
		$appClassName::start($rootPath, $docPath);
	}

	private $config = array();
	private $appClassName = '';
	private $classPath = __DIR__;
	private $rootPath = __DIR__;
	private $docPath = __DIR__;
	private $ignore = '';
	private $timeZone = '';
	private $environ = 'dev';
	public function __construct($appClassName) {
		$this->appClassName = $appClassName;
	}
	public function setConfig($config) {
		$this->config = $config;
		return $this;
	}
	public function setAppClassName($appClassName) {
		$this->appClassName = $appClassName;
		return $this;
	}
	public function setClassPath($classPath) {
		$this->classPath = $classPath;
		return $this;
	}
	public function setRootPath($rootPath) {
		$this->rootPath = $rootPath;
		return $this;
	}
	public function setDocPath($docPath) {
		$this->docPath = $docPath;
		return $this;
	}
	public function setIgnore($ignore) {
		$this->ignore = $ignore;
		return $this;
	}
	public function setTimeZone($timeZone) {
		$this->timeZone = $timeZone;
		return $this;
	}
	public function setEnvironment($environ) {
		$this->environ = $environ;
		return $this;
	}
	public function build() {
		//$loader->setLibraryPath();
		$app = new Application($this->config, $this->environ);

		$loader = Loader::getInstance();
		// 导入ClassAutoloader类
		$loader->import(TAO_PATH . '/src/Liaiyong/Tao/Base/ClassAutoloader.php');
		// register new autoload
		ClassAutoloader::register($this->classPath, $this->ignore);

		$app->bootstrap();
		$app->run();
	}
}
<?php
namespace Liaiyong\Tao;

use Liaiyong\Tao\Base\ClassAutoloader;

require_once __DIR__ . '/Base/ClassAutoloader.php';

final class Bootstrap {
	public static function start($appClassName, $classPath, $rootPath, $docPath, $ignore = '') {
		ClassAutoloader::register($classPath, $ignore);
		$appClassName::start($rootPath, $docPath);
	}
}
<?php
namespace Liaiyong\Tao\Base;

use Liaiyong\Tao\Base\ClassNotFoundException;

abstract class ClassLoader {
	protected function findClass($className) {
		throw new ClassNotFoundException($className);
	}
	public function loadClass($className) {
		$clazz = $this->findLoadedClass($className);
        if(empty($clazz)) {
        	$path = $this->findClass($className);
        	if(!empty($path)) {
        		require_once($path);
        		$clazz = $className;
        	}
        }
		return $clazz;
	}
	protected final function findLoadedClass($className) {
		$loaded = class_exists($className, false);
		if(!empty($loaded)) {
			return $className;
		} else {
			return false;
		}
	}
}
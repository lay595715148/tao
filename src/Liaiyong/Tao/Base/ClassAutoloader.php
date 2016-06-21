<?php
namespace Liaiyong\Tao\Base;

use Liaiyong\Tao\Base\ClassLoader;
use Liaiyong\Tao\Base\ClassNotFoundException;
use Liaiyong\Tao\Util\Utility;

require_once __DIR__ . '/ClassLoader.php';

class ClassAutoloader extends ClassLoader {
	private static $_instance = null;
	public static function getInstance() {
		if(self::$_instance == null) {
			self::$_instance = new ClassAutoloader();
		}
		return self::$_instance;
	}
	public static function register($classPath, $ignorePrefix = '') {
		$instance = self::getInstance();
		$instance->addClassPath(dirname(dirname(dirname(__DIR__))));
		$instance->addClassPath($classPath);
		$instance->addIgnorePrefix($ignorePrefix);
		// 设置缓存文件目录
        $instance->setCacheDir(sys_get_temp_dir());
        // 加载类文件路径缓存
        $instance->loadCache();
        // 使用自定义的autoload方法
        spl_autoload_register(array($instance, 'loadClass'));
        if(strtoupper(php_sapi_name()) != 'CLI') {
        	register_shutdown_function(array($instance, 'updateCache'));
        }
	}

    private $classes = array();
    private $cachedir = __DIR__;
    private $cachefile = 'liaiyong.tao.classes.php';
    private $classPaths = array();
    private $ignores = array();
    private $dirty = false;
    private $suffixes = array('.php', '.class.php');

	private function __construct() {
		$this->classes['Liaiyong\Tao\Base\ClassLoader'] = realpath(__DIR__ . '/ClassLoader.php');
		$this->classes['Liaiyong\Tao\Base\ClassNotFoundException'] = realpath(__DIR__ . '/ClassNotFoundException.php');
		$this->classes['Liaiyong\Tao\Util\Utility'] = realpath(dirname(__DIR__) . '/Util/Utility.php');
	}
    /**
     * 增加一个类文件根目录
     * @param string $classPath 类目录，数组或以“;”号分隔的目录字符串
     * @return array
     */
    private function addClassPath($classPath) {
        if(!empty($classPath) && is_array($classPath)) {
            $paths = $this->classPaths;
            foreach ($classPath as $p) {
                if(($path = realpath($p)) && is_dir($path)) {
                    $paths[] = $path;
                }
            }
            $this->classPaths = array_unique($paths);
            return $this->classPaths;
        } else if (!empty($classPath) && is_string($classPath)) {
            $paths = explode(';', $classPath);
            return self::addClassPath($paths);
        } else {
            return false;
        }
    }
    /**
     * 增加一个类文件查找忽略前缀
     * @param string $ignore 忽略前缀，数组或以“;”号分隔的字符串
     * @return array
     */
    private function addIgnorePrefix($ignore) {
        if(!empty($ignore) && is_array($ignore)) {
            $ignores = $this->ignores;
            foreach ($ignore as $ig) {
                $ignores[] = $ig;
            }
            $this->ignores = array_unique($ignores);
            return $this->ignores;
        } else if (!empty($ignore) && is_string($ignore)) {
            $ignores = explode(';', $ignore);
            return self::addIgnorePrefix($ignores);
        } else {
            return false;
        }
    }
    /**
     * 设置加载类路径缓存目录
     * @return void
     */
    private function setCacheDir($dirpath) {
        if ($dir = realpath($dirpath)) {
            $this->cachedir = $dir;
        }
    }
    /**
     * 获取类路径缓存文件所在目录
     * @return string
     */
    public function getCacheDir() {
        return $this->cachedir;
    }
    /**
     * 设置新的类路径缓存
     * @param string $className 类名
     * @param string $filepath 类文件路径
     * @return
     */
    public function setCache($className, $filepath) {
    	$path = realpath($filepath);
    	if(!empty($path) && is_file($path)) {
	        $this->dirty = true;
	        $this->caches[$className] = realpath($filepath);
    	}
    }
    /**
     * 加载类路径缓存
     * @return
     */
    public function loadCache() {
        $cachename = realpath($this->cachedir . '/' . $this->cachefile);
        if (is_file($cachename)) {
            $this->caches = include $cachename;
            $this->caches = empty($this->caches) || !is_array($this->caches) ? array() : $this->caches;
        } else {
            $this->caches = array();
        }
        if (is_array($this->caches) && !empty($this->caches)) {
            $this->classes = array_merge($this->classes, $this->caches);
        }
    }
    /**
     * 清除类路径缓存文件
     *
     * @return void
     */
    public static function cleanCache() {
        $cachename = realpath($this->cachedir . '/' . $this->cachefile);
        $this->dirty = false;
        return is_file($cachename) && @unlink($cachename);
    }
    /**
     * 更新类路径缓存
     *
     * @return boolean
     */
    public function updateCache() {
        if (! empty($this->dirty)) {
            // 先读取，再merge，再存储
            $cachename = $this->cachedir . '/' . $this->cachefile;
            if (is_file($cachename)) {
                // 清除文件状态缓存
                clearstatcache(true, $cachename);
                $caches = include realpath($cachename);
                $caches = empty($caches) || !is_array($caches) ? array() : $caches;
                $this->caches = empty($this->caches) || !is_array($this->caches) ? array() : $this->caches;
                $this->caches = array_merge($caches, $this->caches);
            }
            // 写入
            $content = $this->array2PHPContent($this->caches);
            $handle = fopen($cachename, 'w');
            $return = @chmod($cachename, 0777);
            $result = fwrite($handle, $content);
            $return = fflush($handle);
            $return = fclose($handle);
            $this->dirty = false;
            return $result;
        } else {
            return false;
        }
    }
    private function array2PHPContent($arr) {
    	return Utility::array2PHPContent($arr);
    }

	protected function findMappedClass($className) {
		if(!empty($this->classes) && array_key_exists($className, $this->classes)) {
			return $this->classes[$className];
		}
		return false;
	}
	protected function findClass($className) {
		$path = $this->findMappedClass($className);
		if(!empty($path)) {
			return $path;
		}
		// 多个类文件目录下查找
        foreach ($this->classPaths as $p) {
            $found = $this->findClassEach($className, $p);
            if(!empty($found)) {
            	return $found;
            }
        }
        if(!class_exists($className, false)) {
            return false;
        	//throw new ClassNotFoundException("Class '$className' not found");
        }
	}
	protected function findClassEach($className, $classPath) {
		$search = $className;
		// 有忽略前缀
		if(!empty($this->ignores)) {
	        foreach ($this->ignores as $ignore) {
	        	if(strpos($className, $ignore) === 0) {
		        	$search = trim(substr($className, strlen($ignore)), "\\");
		        	break;
	        	}
	        }
		}
		if(!empty($search)) {
			$explode = explode("\\", $search);
		}
		if(!empty($explode) && count($explode) > 1) {
            $name = array_pop($explode);
            $path = $classPath . '/' . implode('/', $explode);
            // 命名空间文件夹查找
            if (is_dir($path)) {
                $tmppath = $path . '/' . $name;
                /*if($className == 'Lay\Advance\Core\App') {
                	var_dump($tmppath);exit;
                }*/
                foreach ($this->suffixes as $suffix) {
                    if (is_file($tmppath . $suffix)) {
                        $filepath = realpath($tmppath . $suffix);
                        $this->setCache($className, $filepath);
                        return $filepath;
                    }
                }
            }
		}
		// 正则匹配后进行查找
        $reg = '/([A-Z]{1,}[a-z0-9]{0,}|[a-z0-9]{1,})_{0,1}/';
        if (preg_match_all($reg, $className, $matches) > 0) {
            $tmparr = array_values($matches[1]);
            $prefix = array_shift($tmparr);
            // 直接以类名作为文件名查找
            foreach ($this->suffixes as $suffix) {
                $tmppath = $classPath . '/' . $className;
                if (is_file($tmppath . $suffix)) {
                    $filepath = realpath($tmppath . $suffix);
                    $this->setCache($className, $filepath);
                    return $filepath;
                }
            }
        }
        // 如果以上没有匹配，则使用类名递归文件夹查找，如使用小写请保持（如果第一递归文件夹使用了小写，即之后的文件夹名称保持小写）
        if (!empty($matches)) {
            $path = $lowerpath = $classPath;
            foreach ( $matches[1] as $index => $item ) {
                $path .= '/' . $item;
                $lowerpath .= '/' . strtolower($item);
                if (($isdir = is_dir($path)) || is_dir($lowerpath)) { // 顺序文件夹查找
                    $tmppath = ($isdir ? $path : $lowerpath) . '/' . $className;
                    foreach ( $this->suffixes as $i => $suffix ) {
                        if (is_file($tmppath . $suffix)) {
                            $filepath = realpath($tmppath . $suffix);
                            $this->setCache($className, $filepath);
                    		return $filepath;
                        }
                    }
                    continue;
                } else if ($index == count($matches[1]) - 1) {
                    foreach ( $this->suffixes as $i => $suffix ) {
                        if (($isfile = is_file($path . $suffix)) || is_file($lowerpath . $suffix)) {
                            $filepath = realpath(($isfile ? $path : $lowerpath) . $suffix);
                            $this->setCache($className, $filepath);
                    		return $filepath;
                        }
                    }
                    break;
                } else {
                    // 首个文件夹都已经不存在，直接退出loop
                    break;
                }
            }
        }
	}
}
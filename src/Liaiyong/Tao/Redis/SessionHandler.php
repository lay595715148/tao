<?php
namespace Liaiyong\Tao\Redis;

use SessionHandlerInterface;
use Exception;
use Redis;

/**
 * 将SESSION封装到redis中保存。
 */
class SessionHandler extends SessionHandlerInterface {
	/**
	 * Redis对象。
	 * @var Client
	 */
	protected $client;

	/**
	 * session前缀。
	 * @var string
	 */
	protected $prefix = 'sess_';

	/**
	 * session有效期。
	 * @var int
	 */
	protected $ttl;

	/**
	 * @var array
	 */
	protected $cache = array();

	/**
	 * 构造方法。
	 * @param Redis $redis Redis连接对象。
	 * @param number $ttl
	 * @param string $prefix
	 * @throws \Exception
	 */
	public function __construct(&$redis, $ttl = null, $prefix = 'sess_') {
		$this->ttl = is_int($ttl) ? $ttl : ini_get('session.gc_maxlifetime');
		$this->client = $redis;
		$this->prefix = $prefix;
	}

	/**
	 * 关闭当前session。
	 * @return boolean
	 */
	public function close() {
		$this->client->close();
		return true;
	}

	/**
	 * 
	 * @param string $session_id
	 * @return boolean
	 */
	public function destroy($session_id) {
		$this->client->del($this->prefix . $session_id);
		return true;
	}

	/**
	 * ssdb不需要gc清理过期的session。ssdb会自己清掉。
	 * @param int $maxlifetime
	 * @return boolean
	 */
	public function gc($maxlifetime) {
		return true;
	}

	/**
	 * @param string $save_path
	 * @param string $name
	 * @return boolean
	 */
	public function open($save_path, $name) {
		return true;
	}

	/**
	 * 读取session。
	 * @param string $session_id
	 * @return string
	 */
	public function read($session_id) {
		if (isset($this->cache[$session_id])) {
			return $this->cache[$session_id];
		}
		$session_data = $this->client->get($this->prefix . $session_id);
		return $this->cache[$session_id] = ($session_data === null ? '' : $session_data);
	}

	/**
	 * 写session。
	 * @param string $session_id
	 * @param string $session_data
	 * @return boolean
	 */
	public function write($session_id, $session_data) {
		if (isset($this->cache[$session_id]) && $this->cache[$session_id] === $session_data) {
			$this->client->expire($this->prefix . $session_id, $this->ttl);
		} else {
			$this->cache[$session_id] = $session_data;
			$this->client->setEx($this->prefix . $session_id, $this->ttl, $session_data);
		}
		return true;
	}
}
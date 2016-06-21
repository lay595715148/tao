<?php
namespace Liaiyong\Tao\Core;

/**
 * 当前应用运行环境
 */
public final class Environment {
	const DEVELOPMENT = 0;
	const TEST = 1;
	const PRODUCT = 2;
	//
	const DEV = 0;
	const TST = 1;
	const PRD = 2;

	private $env;
	public function __construct($env) {
		$this->env = $env;
	}
}
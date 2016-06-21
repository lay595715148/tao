<?php
namespace Liaiyong\Tao\Content;

use Liaiyong\Tao\Core\Context;

public class ContextWrapper extends Context {
	/**
	 * @var Context
	 */
    protected $base;

	/**
	 * @param Context $base
	 */
    public function __construct($base) {
        $this->base = base;
    }

    /**
     * @return Context the base context as set by the constructor or setBaseContext
     */
    public function getBaseContext() {
        return $this->base;
    }
}
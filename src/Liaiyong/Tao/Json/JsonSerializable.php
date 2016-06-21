<?php
namespace Liaiyong\Tao\Json;

if(version_compare(phpversion(), '5.4.0') >= 0) {
	interface JsonSerializable extends \JsonSerializable {
	}
} else {
	interface JsonSerializable {
	    /**
	     * PHP 5.4
	     * json serialize function
	     * 
	     * @return stdClass
	     */
	    public function jsonSerialize();
	}
}

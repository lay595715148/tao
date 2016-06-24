<?php
namespace Liaiyong\Tao\App;

use Liaiyong\Tao\Content\ContextWrapper;
use Liaiyong\Tao\App\ActionLifecycleCallbacks;

public class Controller extends ContextWrapper {
	/**
	 * @var array<ActionLifecycleCallbacks>
	 */
	private $actionLifecycleCallbacks = array();

    /**
     * @return
     */
	public function onCreate() {
    }
    /**
     * @return
     */
    public function onTerminate() {
    }

    public function registerActionLifecycleCallbacks($callback) {
    	array_push($this->actionLifecycleCallbacks, $callback);
    }
    public function unregisterActionLifecycleCallbacks($callback) {
    	$ret = array_search($callback, $this->actionLifecycleCallbacks);
    	if($ret !== false) {
    		array_splice($this->actionLifecycleCallbacks, $ret, 1);
    	}
    }

    /**
     * @return
     */
    public function dispatchActionCreated($action, $state) {
    	$callbacks = $this->collectActionLifecycleCallbacks();
    	if(!empty($callbacks)) {
	    	foreach ($callbacks as $callback) {
	    		if($callback instanceof ActionLifecycleCallbacks) {
	    			$callback->onActionCreated($action, $state);
	    		}
	    	}
    	}
    }
    /**
     * @return
     */
    public function dispatchActionStarted($action) {
    	$callbacks = $this->collectActionLifecycleCallbacks();
    	if(!empty($callbacks)) {
	    	foreach ($callbacks as $callback) {
	    		if($callback instanceof ActionLifecycleCallbacks) {
	    			$callback->onActionStarted($action);
	    		}
	    	}
    	}
    }
    /**
     * @return
     */
    public function dispatchActionStopped($action) {
    	$callbacks = $this->collectActionLifecycleCallbacks();
    	if(!empty($callbacks)) {
	    	foreach ($callbacks as $callback) {
	    		if($callback instanceof ActionLifecycleCallbacks) {
	    			$callback->onActionStopped($action);
	    		}
	    	}
    	}
    }
    /**
     * @return
     */
    public function dispatchActionDestroyed($action) {
    	$callbacks = $this->collectActionLifecycleCallbacks();
    	if(!empty($callbacks)) {
	    	foreach ($callbacks as $callback) {
	    		if($callback instanceof ActionLifecycleCallbacks) {
	    			$callback->onActionDestroyed($action);
	    		}
	    	}
    	}
    }

    /**
     * @return array
     */
    private function collectActionLifecycleCallbacks() {
    	return $this->actionLifecycleCallbacks;
    }
}
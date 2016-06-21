<?php
namespace Liaiyong\Tao\App;

use Liaiyong\Tao\App\Action;

/**
 * Action生命周期
 */
public interface ActionLifecycleCallbacks {
    /**
     * 创建Action时
     * @param Action $action
     * @param array $state
     */
    public function onActionCreated($action, $state);
    /**
     * 启动Action时
     * @param Action $action
     */
    public function onActionStarted($action);
    /**
     * 停止Action时
     * @param Action $action
     */
    public function onActionStopped($action);
    /**
     * 摧毁Action时
     * @param Action $action
     */
    public function onActionDestroyed($action);
}
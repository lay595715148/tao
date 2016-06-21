<?php
namespace Liaiyong\Tao\Core;

abstract class Component {
    /**
     * 忽略类型
     * @var int
     */
    const TYPE_IGNORE = 0;
    /**
     * 字符串类型
     * @var int
     */
    const TYPE_STRING = 1;
    /**
     * 数值类型
     * @var int
     */
    const TYPE_NUMBER = 2;
    /**
     * 整数类型
     * @var int
     */
    const TYPE_INTEGER = 3;
    /**
     * 布尔类型
     * @var int
     */
    const TYPE_BOOLEAN = 4;
    /**
     * 日期时间类型
     * @var int
     */
    const TYPE_DATETIME = 5;
    /**
     * 日期类型
     * @var int
     */
    const TYPE_DATE = 6;
    /**
     * 时间类型
     * @var int
     */
    const TYPE_TIME = 7;
    /**
     * 浮点数类型
     * @var int
     */
    const TYPE_FLOAT = 8;
    /**
     * double类型
     * @var int
     */
    const TYPE_DOUBLE = 9;
    /**
     * 数组类型
     * @var int
     */
    const TYPE_ARRAY = 10;
    /**
     * 纯数组类型
     * @var int
     */
    const TYPE_PURE_ARRAY = 11;
    /**
     * 特定日期格式
     * @var int
     */
    const TYPE_DATEFORMAT = 12;
    /**
     * 指定值范围的属性值
     * @var int
     */
    const TYPE_ENUM = 13;
    /**
     * 其他类型的属性值
     * @var int
     */
    const TYPE_FORMAT = 14;
    /**
     * stdClass
     * @var int
     */
    const TYPE_STDCLASS = 15;
    /**
     * json对象
     * @var int
     */
    const TYPE_JSON_OBJECT = 16;
    /**
     * json数组
     * @var int
     */
    const TYPE_JSON_ARRAY = 17;
    /**
     * all components' properties
     */
    protected static $properties = array();
    /**
     * 返回对象所有属性名的数组，
     * 在定义子类时，所有成员属性（不包含静态属性）必须要是protected或更高访问权限
     * @return array
     */
    protected function properties() {
        $class = get_class($this);
        if(!isset(Component::$properties[$class])) {
            Component::$properties[$class] = get_object_vars($this);
        }
        return Component::$properties[$class];
    }

    /**
     * 返回类成员属性值规则数组
     * @return array
     */
    public abstract function rules();
    /**
     * 输出为JSON字符串
     * @return string
     */
    public abstract function toJson();
    /**
     * 输出为数组
     * @return string
     */
    public abstract function toArray();
}
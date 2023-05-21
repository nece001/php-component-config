<?php

namespace Nece001\PhpComponentConfig;

use Exception;

/**
 * 组件配置抽象类
 *
 * @Author gjw
 * @DateTime 2023-05-21
 */
abstract class ComponentLogicAbstract implements ComponentLogicInterface
{
    const ENABLED = 0;
    const DISABLED = 1;

    protected $app_name;
    protected $component_model;
    protected $config_model;
    protected $setting_model;

    /**
     * 创建组件Model
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \ArrayAccess 
     */
    abstract protected function createComponentModel();

    /**
     * 创建配置Model
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \ArrayAccess 
     */
    abstract protected function createConfigModel();

    /**
     * 创建设置Model
     * 设置的作用是：给某组件设置上指定的配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \ArrayAccess 
     */
    abstract protected function createSettingModel();

    /**
     * 获取应用名
     * 应用名用于区分组件在不同应用中设置的配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return string
     */
    abstract protected function getAppName();

    /**
     * 开始事务
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return void
     */
    abstract protected function startTrans();

    /**
     * 事务提交
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return void
     */
    abstract protected function commit();

    /**
     * 事务回滚
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return void
     */
    abstract protected function rollback();

    /**
     * 执行保存组件记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param \ArrayAccess  $item
     *
     * @return \ArrayAccess 
     */
    abstract protected function componentExecuteSave($item);

    /**
     * 执行保存配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param \ArrayAccess  $item
     *
     * @return \ArrayAccess 
     */
    abstract protected function configExecuteSave($item);

    /**
     * 执行保存设置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param \ArrayAccess  $item
     *
     * @return \ArrayAccess 
     */
    abstract protected function settingExecuteSave($item);

    /**
     * 查询组件是否存在
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param string $component_code
     * @param integer $id
     *
     * @return bool
     */
    abstract protected function componentExists($component_code, $id = 0);

    /**
     * 写异常日志
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param \Throwable $e
     *
     * @return void
     */
    protected function logException($e)
    {
    }

    /**
     * 创建异常
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param string $message
     * @param mixed $code
     *
     * @return \Exception
     */
    protected function createException($message, $code = 0)
    {
        return new Exception($message, $code);
    }

    /**
     * 获取组件Model
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \ArrayAccess 
     */
    protected function getComponentModel()
    {
        if (!$this->component_model) {
            $this->component_model = $this->createComponentModel();
        }
        return $this->component_model;
    }

    /**
     * 获取配置Model
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \ArrayAccess 
     */
    protected function getConfigModel()
    {
        if (!$this->config_model) {
            $this->config_model = $this->createConfigModel();
        }
        return $this->config_model;
    }

    /**
     * 获取设置Model
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \ArrayAccess 
     */
    protected function getSettingModel()
    {
        if (!$this->setting_model) {
            $this->setting_model = $this->createSettingModel();
        }
        return $this->setting_model;
    }

    /**
     * 获取是否禁用状态
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param mixed $is_disabled
     *
     * @return integer
     */
    protected function disabledState($is_disabled)
    {
        return $is_disabled ? self::DISABLED : self::ENABLED;
    }
}

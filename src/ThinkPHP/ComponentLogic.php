<?php

namespace Nece001\PhpComponentConfig\ThinkPHP;

use Nece001\PhpComponentConfig\ComponentLogicAbstract;
use Nece001\PhpComponentConfig\ThinkPHP\Model\Component;
use Nece001\PhpComponentConfig\ThinkPHP\Model\ComponentConfig;
use Nece001\PhpComponentConfig\ThinkPHP\Model\ComponentSetting;
use Throwable;

class ComponentLogic extends ComponentLogicAbstract
{
    /**
     * 创建组件Model
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \think\model
     */
    protected function createComponentModel()
    {
        return new Component();
    }

    /**
     * 创建配置Model
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \think\model
     */
    protected function createConfigModel()
    {
        return new ComponentConfig();
    }

    /**
     * 创建设置Model
     * 设置的作用是：给某组件设置上指定的配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return \think\model
     */
    protected function createSettingModel()
    {
        return new ComponentSetting();
    }

    /**
     * 获取应用名
     * 应用名用于区分组件在不同应用中设置的配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return string
     */
    protected function getAppName()
    {
        if (!$this->app_name) {
            $this->app_name = env('APP_NAME');
        }
        return $this->app_name;
    }

    /**
     * 开始事务
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return void
     */
    protected function startTrans()
    {
        $this->getComponentModel()->db()->startTrans();
    }

    /**
     * 事务提交
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return void
     */
    protected function commit()
    {
        $this->getComponentModel()->db()->commit();
    }

    /**
     * 事务回滚
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @return void
     */
    protected function rollback()
    {
        $this->getComponentModel()->db()->rollback();
    }

    /**
     * 执行保存组件记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param \think\model $item
     *
     * @return \think\model
     */
    protected function componentExecuteSave($item)
    {
        $item->save();
        return $item;
    }

    /**
     * 执行保存配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param \think\model $item
     *
     * @return \think\model
     */
    protected function configExecuteSave($item)
    {
        $item->save();
        return $item;
    }

    /**
     * 执行保存设置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param \think\model $item
     *
     * @return \think\model
     */
    protected function settingExecuteSave($item)
    {
        $item->save();
        return $item;
    }

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
    protected function componentExists($component_code, $id = 0)
    {
        $query = $this->getComponentModel()->where('component_code', $component_code);
        if ($id) {
            $query->where('id', '<>', $id);
        }

        return $query->count() > 0;
    }

    /**
     * 根据ID获取组件
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $id
     *
     * @return \think\model
     */
    public function getComponentById($id)
    {
        return $this->getComponentModel()->find($id);
    }

    /**
     * 保存组件记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param string $title
     * @param string $component_code
     * @param integer $id
     *
     * @return \think\model
     */
    public function saveComponent($title, $component_code, $id = 0)
    {
        if ($this->componentExists($component_code, $id)) {
            throw $this->createException('component_code_exists');
        }

        if ($id) {
            $item = $this->getComponentById($id);
        } else {
            $item = $this->createComponentModel();
        }

        if ($item) {
            $item['title'] = $title;
            $item['component_code'] = $component_code;
            return $this->componentExecuteSave($item);
        }

        return null;
    }

    /**
     * 删除组件（同时删除配置和设置记录）
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param array $ids
     *
     * @return integer
     */
    public function deleteComponent($ids)
    {
        $this->startTrans();
        try {
            $this->getConfigModel()->whereIn('component_id', $ids)->delete();
            $this->getSettingModel()->whereIn('component_id', $ids)->delete();
            $count = $this->getComponentModel()->whereIn('id', $ids)->delete();
            $this->commit();
            return $count;
        } catch (Throwable $e) {
            $this->rollback();
            $this->logException($e);
            throw $this->createException('component_delete_failure');
        }
    }

    /**
     * 获取配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $id
     *
     * @return \think\model
     */
    public function getConfigById($id)
    {
        return $this->getConfigModel()->find($id);
    }

    /**
     * 保存配置
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $component_id
     * @param string $provider_code
     * @param string $provider_title
     * @param string $title
     * @param array $config
     * @param boolean $is_disabled
     * @param integer $id
     *
     * @return \think\model
     */
    public function saveConfig($component_id, $provider_code, $provider_title, $title, $config, $is_disabled = false, $id = 0)
    {
        if ($id) {
            $item = $this->getConfigById($id);
        } else {
            $item = $this->createConfigModel();
            $item['component_id'] = $component_id;
            $item['provider_code'] = $provider_code;
            $item['provider_title'] = $provider_title;
        }

        if ($item) {
            $item['title'] = $title;
            $item['config'] = $config;
            $item['is_disabled'] = $this->disabledState($is_disabled);
            return $this->configExecuteSave($item);
        } else {
            throw $this->createException('record_is_not_exists');
        }
    }

    /**
     * 删除配置（同时删除设置）
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param array $ids
     *
     * @return integer
     */
    public function deleteConfig($ids)
    {
        $this->startTrans();
        try {
            $this->getSettingModel()->whereIn('component_config_id', $ids)->delete();
            $coutn = $this->getConfigModel()->whereIn('id', $ids)->delete();
            $this->commit();
            return $coutn;
        } catch (Throwable $e) {
            $this->rollback();
            $this->logException($e);
            throw $this->createException('config_delete_failure');
        }
    }

    /**
     * 获取设置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $id
     *
     * @return \think\model
     */
    public function getSettingById($id)
    {
        return $this->getSettingModel()->find($id);
    }

    /**
     * 保存设置记录
     * 如果已存在组件对应的设置记录，则当前配置ID替换为新的配置ID
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $component_id
     * @param integer $component_config_id
     *
     * @return \think\model
     */
    public function saveSetting($component_id, $component_config_id)
    {
        $query = $this->getSettingModel()->where('app_name', $this->getAppName())->where('component_id', $component_id);
        $item = $query->find();
        if (!$item) {
            $item = $this->createSettingModel();
            $item['app_name'] = $this->getAppName();
        }

        if ($item) {
            $item['component_id'] = $component_id;
            $item['component_config_id'] = $component_config_id;

            return $this->settingExecuteSave($item);
        }
        return null;
    }

    /**
     * 删除设置
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param array $ids
     *
     * @return integer
     */
    public function deleteSetting($ids)
    {
        return $this->getConfigModel()->whereIn('id', $ids)->delete();
    }

    /**
     * 获取指定组件的配置
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param string $component_code
     *
     * @return \think\model
     */
    public function getComponentConfig($component_code)
    {
        $query = $this->getConfigModel()->alias('cf')
            ->field(array('cf.provider_code', 'cf.config'))
            ->join($this->getSettingModel()->getName() . ' s', 'cf.id=s.component_config_id')
            ->join($this->getComponentModel()->getName() . ' c', 's.component_id=c.id')
            ->where('s.app_name', $this->getAppName())
            ->where('c.component_code', $component_code);
        return $query->find();
    }
}

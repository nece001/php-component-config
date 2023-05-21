<?php

namespace Nece001\PhpComponentConfig;

interface ComponentLogicInterface{
    /**
     * 根据ID获取组件
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $id
     *
     * @return \ArrayAccess 
     */
    public function getComponentById($id);

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
     * @return \ArrayAccess 
     */
    public function saveComponent($title, $component_code, $id = 0);

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
    public function deleteComponent($ids);

    /**
     * 获取配置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $id
     *
     * @return \ArrayAccess 
     */
    public function getConfigById($id);

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
     * @return \ArrayAccess 
     */
    public function saveConfig($component_id, $provider_code, $provider_title, $title, $config, $is_disabled = false, $id = 0);

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
    public function deleteConfig($ids);

    /**
     * 获取设置记录
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param integer $id
     *
     * @return \ArrayAccess 
     */
    public function getSettingById($id);

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
     * @return \ArrayAccess 
     */
    public function saveSetting($component_id, $component_config_id);

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
    public function deleteSetting($ids);

    /**
     * 获取指定组件的配置
     *
     * @Author gjw
     * @DateTime 2023-05-21
     *
     * @param string $component_code
     *
     * @return \ArrayAccess 
     */
    public function getComponentConfig($component_code);
}
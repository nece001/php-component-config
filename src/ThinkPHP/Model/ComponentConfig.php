<?php

namespace Nece001\PhpComponentConfig\ThinkPHP\Model;

use think\Model;

/**
 * 组件配置表
 *
 * @Author gjw
 * @DateTime 2023-05-20
 */
class ComponentConfig extends Model
{
    protected $type = array(
        'config' => 'json'
    );
}

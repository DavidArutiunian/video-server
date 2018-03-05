<?php

require_once dirname(__FILE__) . '/../vendor/vadimdol/symfony1/lib/autoload/sfCoreAutoload.class.php';

try {
    sfCoreAutoload::register();
} catch (sfException $e) {
    error_log($e->getMessage());
}

class ProjectConfiguration extends sfProjectConfiguration
{
    public function setup()
    {
        $this->enablePlugins('sfPropelPlugin');
        $this->enablePlugins('isoOptimizerPlugin');
        $this->enablePlugins('isoCommonPartialPlugin');
    }
}

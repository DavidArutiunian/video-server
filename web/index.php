<?php


require_once(dirname(__FILE__) . '/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);

try {
    sfContext::createInstance($configuration)->dispatch();
} catch (sfFactoryException $e) {
    error_log($e->getMessage());
}

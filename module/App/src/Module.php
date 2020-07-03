<?php
namespace App;


use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }


    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\UserTable::class => function($container) {
                    return new Model\UserTable();
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\UserController::class => function($container){
                    return new Controller\UserController($container->get(Model\UserTable::class));
                },
            ],
        ];
    }
}
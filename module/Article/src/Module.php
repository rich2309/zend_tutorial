<?php
namespace Article;
use Zend\Db\Adapter;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
class Module implements ConfigProviderInterface
{
 const VERSION = '3.0.3-dev';
public function getConfig()
	{
	return include __DIR__ . '/../config/module.config.php' ;
	}
 public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ArticleTable::class => function($container) {
                    $tableGateway = $container->get(Model\ArticleTableGateway::class);
                    return new Model\ArticleTable($tableGateway);
                },
                Model\ArticleTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Article());
                    return new TableGateway('article', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ArticleController::class => function($container) {
                    return new Controller\ArticleController(
                        $container->get(Model\ArticleTable::class)
                    );
                },
            ],
        ];
    }

}
<?php
namespace AssetsBundle;
class Module implements
	\Zend\ModuleManager\Feature\ConfigProviderInterface,
	\Zend\ModuleManager\Feature\AutoloaderProviderInterface,
	\Zend\ModuleManager\Feature\ConsoleUsageProviderInterface{

	/**
	 * @param \Zend\EventManager\EventInterface $oEvent
	 */
	public function onBootstrap(\Zend\EventManager\EventInterface $oEvent){
		$oServiceManager = $oEvent->getApplication()->getServiceManager();
		if(
			($oRequest = $oEvent->getRequest()) instanceof \Zend\Http\Request
			&& !$oRequest->isXmlHttpRequest()
			&& $oServiceManager->get('ViewRenderer') instanceof \Zend\View\Renderer\PhpRenderer
		)$oEvent->getApplication()->getEventManager()->attach('render', array($this, 'renderAssets'), 32);
	}

	/**
	 * @param \Zend\Mvc\MvcEvent $oEvent
	 */
	public function renderAssets(\Zend\Mvc\MvcEvent $oEvent){
		$oAssetsBundleService = $oEvent->getApplication()->getServiceManager()->get('AssetsBundleService')
		->setRenderer($oEvent->getApplication()->getServiceManager()->get('ViewRenderer'));

		/* @var $oRouter \Zend\Mvc\Router\RouteMatch */
		$oRouter = $oEvent->getRouteMatch();
		if($oRouter instanceof \Zend\Mvc\Router\RouteMatch)$oAssetsBundleService->setControllerName($oRouter->getParam('controller'))->setActionName($oRouter->getParam('action'));
		$oAssetsBundleService->renderAssets();
	}

	/**
	 * @param \Zend\Console\Adapter\AdapterInterface $oConsole
	 * @return string
	 */
	public function getConsoleBanner(\Zend\Console\Adapter\AdapterInterface $oConsole){
		return 'AssetsBundle - Command line Tool';
	}

	/**
	 * @see \Zend\ModuleManager\Feature\ConsoleUsageProviderInterface::getConsoleUsage()
	 * @param \Zend\Console\Adapter\AdapterInterface $oConsole
	 * @return array
	 */
	public function getConsoleUsage(\Zend\Console\Adapter\AdapterInterface $oConsole){
		return array(
			'Rendering assets:',
			'render' => 'render all assets',
			'Empty cache:',
			'empty' => 'empty cache directory'
		);
	}

	/**
	 * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
	 * @return array
	 */
	public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__.DIRECTORY_SEPARATOR.'autoload_classmap.php'
            )
        );
    }

    /**
     * @return array
     */
    public function getConfig(){
        return include __DIR__.DIRECTORY_SEPARATOR.'config/module.config.php';
    }
}
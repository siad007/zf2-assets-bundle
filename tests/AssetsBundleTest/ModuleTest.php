<?php
namespace AssetsBundleTest;
class ModuleTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \AssetsBundle\Module
	 */
	protected $module;

	/**
	 * @var \Zend\Mvc\MvcEvent
	 */
	protected $event;

	public function setUp(){
		$this->module = new \AssetsBundle\Module();
		$aConfiguration = \AssetsBundleTest\Bootstrap::getServiceManager()->get('Config');
		$this->event = new \Zend\Mvc\MvcEvent();
		$this->event
		->setViewModel(new \Zend\View\Model\ViewModel())
		->setApplication(\AssetsBundleTest\Bootstrap::getServiceManager()->get('Application'))
		->setRouter(\Zend\Mvc\Router\Http\TreeRouteStack::factory(isset($aConfiguration['router'])?$aConfiguration['router']:array()))
		->setRouteMatch(new \Zend\Mvc\Router\RouteMatch(array('controller' => 'index','action' => 'index')));
	}

	public function testGetConsoleBanner(){
		$this->assertEquals('AssetsBundle - Command line Tool',$this->module->getConsoleBanner(\AssetsBundleTest\Bootstrap::getServiceManager()->get('console')));
	}

	public function testGetConsoleUsager(){
		$this->assertTrue(is_array($this->module->getConsoleUsage(\AssetsBundleTest\Bootstrap::getServiceManager()->get('console'))));
	}

	public function testGetAutoloaderConfig(){
        $this->assertEquals(
        	array('Zend\Loader\ClassMapAutoloader' => array(realpath(getcwd().'/../autoload_classmap.php'))),
        	$this->module->getAutoloaderConfig()
        );
    }

    public function testGetConfig(){
    	$this->assertTrue(is_array($this->module->getConfig()));
    }
}
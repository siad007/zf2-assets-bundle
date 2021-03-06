<?php
namespace AssetsBundleTest\Factory;
class ServiceFactoryTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var array
	 */
	protected $configuration;

	/**
	 * @var \AssetsBundle\Factory\ServiceFactory
	 */
	protected $serviceFactory;

	/**
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp(){
		$this->serviceFactory = new \AssetsBundle\Factory\ServiceFactory();
		$this->configuration = \AssetsBundleTest\Bootstrap::getServiceManager()->get('Config');
	}

	public function testCreateServiceWithoutBasePath(){

		$aConfiguration = $this->configuration;
		unset($aConfiguration['asset_bundle']['basePath']);

		$oServiceManager = \AssetsBundleTest\Bootstrap::getServiceManager();
		$bAllowOverride = $oServiceManager->getAllowOverride();
		if(!$bAllowOverride)$oServiceManager->setAllowOverride(true);
		$oServiceManager->setService('Config',$aConfiguration)->setAllowOverride($bAllowOverride);

		$this->serviceFactory->createService(\AssetsBundleTest\Bootstrap::getServiceManager());
	}

	public function testCreateServiceWithClassnameFilter(){
		$aConfiguration = $this->configuration;
		$aConfiguration['asset_bundle']['filters']['css'] = 'AssetsBundle\Service\Filter\CssFilter';

		$oServiceManager = \AssetsBundleTest\Bootstrap::getServiceManager();
		$bAllowOverride = $oServiceManager->getAllowOverride();
		if(!$bAllowOverride)$oServiceManager->setAllowOverride(true);
		$oServiceManager->setService('Config',$aConfiguration)->setAllowOverride($bAllowOverride);

		$this->serviceFactory->createService(\AssetsBundleTest\Bootstrap::getServiceManager());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCreateServiceWithWrongAssetTypeFilter(){
		$aConfiguration = $this->configuration;
		$aConfiguration['asset_bundle']['filters']['wrong'] = 'AssetsBundle\Service\Filter\CssFilter';

		$oServiceManager = \AssetsBundleTest\Bootstrap::getServiceManager();
		$bAllowOverride = $oServiceManager->getAllowOverride();
		if(!$bAllowOverride)$oServiceManager->setAllowOverride(true);
		$oServiceManager->setService('Config',$aConfiguration)->setAllowOverride($bAllowOverride);

		$this->serviceFactory->createService(\AssetsBundleTest\Bootstrap::getServiceManager());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCreateServiceWithWrongTypeFilter(){
		$aConfiguration = $this->configuration;
		$aConfiguration['asset_bundle']['filters']['css'] = 'Wrong';

		$oServiceManager = \AssetsBundleTest\Bootstrap::getServiceManager();
		$bAllowOverride = $oServiceManager->getAllowOverride();
		if(!$bAllowOverride)$oServiceManager->setAllowOverride(true);
		$oServiceManager->setService('Config',$aConfiguration)->setAllowOverride($bAllowOverride);

		$this->serviceFactory->createService(\AssetsBundleTest\Bootstrap::getServiceManager());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCreateServiceWithWrongAssetsPath(){

		$aConfiguration = $this->configuration;
		$aConfiguration['asset_bundle']['assetsPath'] = 'wrong';

		$oServiceManager = \AssetsBundleTest\Bootstrap::getServiceManager();
		$bAllowOverride = $oServiceManager->getAllowOverride();
		if(!$bAllowOverride)$oServiceManager->setAllowOverride(true);
		$oServiceManager->setService('Config',$aConfiguration)->setAllowOverride($bAllowOverride);

		$this->serviceFactory->createService(\AssetsBundleTest\Bootstrap::getServiceManager());
	}

	public function testCreateServiceWithoutAssetsPath(){
		$aConfiguration = $this->configuration;
		unset($aConfiguration['asset_bundle']['assetsPath']);

		$oServiceManager = \AssetsBundleTest\Bootstrap::getServiceManager();
		$bAllowOverride = $oServiceManager->getAllowOverride();
		if(!$bAllowOverride)$oServiceManager->setAllowOverride(true);
		$oServiceManager->setService('Config',$aConfiguration)->setAllowOverride($bAllowOverride);

		$this->serviceFactory->createService(\AssetsBundleTest\Bootstrap::getServiceManager());
	}

	public function tearDown(){
		$oServiceManager = \AssetsBundleTest\Bootstrap::getServiceManager();
		$bAllowOverride = $oServiceManager->getAllowOverride();
		if(!$bAllowOverride)$oServiceManager->setAllowOverride(true);
		$oServiceManager->setService('Config',$this->configuration)->setAllowOverride($bAllowOverride);
	}
}
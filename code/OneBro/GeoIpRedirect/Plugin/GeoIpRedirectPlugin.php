<?php

namespace OneBro\GeoIpRedirect\Plugin;

use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Api\StoreCookieManagerInterface;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Model\StoreManagerInterface;
use OneBro\GeoIpRedirect\Model\GeoIpRequest;

class GeoIpRedirectPlugin {

	protected $_storeManager;
	protected $storeFactory;
	protected $storeCookieManager;
	protected $geoIpRequest;

	public function __construct(
		StoreFactory $storeFactory,
		StoreCookieManagerInterface $storeCookieManager,
		GeoIpRequest $geoIpRequest,
		StoreManagerInterface $storeManager

	) {
		$this->storeFactory = $storeFactory;
		$this->storeCookieManager = $storeCookieManager;
		$this->geoIpRequest = $geoIpRequest;
		$this->_storeManager = $storeManager;

	}

	public function beforeDispatch(
		FrontControllerInterface $subject,
		RequestInterface $request
	) {

		// this request can make the website perfomrnace slow it must be stored in session 
		$countryCode = $this->geoIpRequest->getCountryCode();

		// if ($countryCode == "_choose_store_code") { // or other logic 
			
			// make sure your stoer view code match to country code 
			$store = $this->storeFactory->create();
			$store->load($countryCode, 'code');

			// here we setting store code but this would be happenign for each request need to fix based on session logics so it must call only once		
			$this->storeCookieManager->setStoreCookie($store);
			$this->_storeManager->setCurrentStore($store);

		// }

		return null;
	}
}
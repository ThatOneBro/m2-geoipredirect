<?php

namespace OneBro\GeoIpRedirect\Plugin;

use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Api\StoreCookieManagerInterface;
use OneBro\GeoIpRedirect\Model\GeoIpRequest;

class GeoIpRedirectPlugin
{
	public function __construct(
		StoreFactory $storeFactory,
		StoreCookieManagerInterface $storeCookieManager,
		GeoIpRequest $geoIpRequest
	)
	{
		$this->storeFactory = $storeFactory;
		$this->storeCookieManager = $storeCookieManager;
		$this->geoIpRequest = $geoIpRequest;
	}
	
	public function beforeDispatch(
		FrontControllerInterface $subject,
		RequestInterface $request
	) {
		$countryCode = $this->geoIpRequest->getCountryCode();
		
		$store = $this->storeFactory->create();
		
		$store->load($countryCode, 'country_code');
		
		$this->storeCookieManager->setStoreCookie($store);
		
		return null;
	}
}
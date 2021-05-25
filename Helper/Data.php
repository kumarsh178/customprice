<?php

namespace Accoona\Customprice\Helper;

use \Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   
    /**
     * @var storeManager
    */
   
    protected $_storeManager;
    
    /**
   * @var \Magento\Framework\App\Config\ScopeConfigInterface
   */
   protected $_scopeConfig;

   /**
   * Api Host
   */
   const XML_API_HOST = 'apiconfig/general/apihost';

   /**
   * @var \Magento\Framework\HTTP\Client\Curl
   */
  protected $_curl;

    public function __construct(
        Context $context,      
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\HTTP\Client\Curl $curl
    ) 
    {
        $this->_curl = $curl;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
    
    public function getApiHost(){
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $storeName = $this->_scopeConfig->getValue(self::XML_API_HOST,$storeScope);
    }
    public function getCustomPrice($params){
        $url = $this->getApiHost();
        $this->_curl->post($url, $params);
        $response = $this->_curl->getBody();
        return $response;
    }
}
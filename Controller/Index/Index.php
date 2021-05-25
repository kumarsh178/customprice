<?php

namespace Accoona\Customprice\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Index extends Action
{

    private $resultJsonFactory;
    private $_customprice;

    public function __construct(
    	JsonFactory $resultJsonFactory, 
    	Context $context,
    	\Accoona\Customprice\Helper\Data $customprice)
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_customprice = $customprice;
    }

    public function execute()
    {
        
    	$post = $this->getRequest()->getPost('pids');
        $prices = array();
        foreach ($post as $key=>$price){
            $prices[] = array("id"=>$key,"price"=>floatval($price)*5);
        }
    	$response = json_decode($this->_customprice->getCustomPrice($prices));
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['products' => $response]);
    }
}
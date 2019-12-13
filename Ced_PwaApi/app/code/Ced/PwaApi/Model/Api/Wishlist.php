<?php

namespace Ced\PwaApi\Model\Api;

use Magento\Store\Model\ScopeInterface;

class Wishlist
{
    protected $objectManager;
    protected $wishlist;
    protected $scopeConfig;
    protected $customerapi;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Ced\PwaApi\Model\Customer\Wishlist $wishlist,
        \Magento\Customer\Model\Customer $customerapi
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->objectManager = $objectInterface; 
        $this->wishlist = $wishlist;
        $this->customerapi = $customerapi;                    
    } 

    /**
    * Gets the json.
    *
    * @param \Ced\PwaApi\Api\Data\WishlistInterface $parameters parameters
    *
    * @return []
    */
    public function remove(\Ced\PwaApi\Api\Data\WishlistInterface $parameters)
    {   
        
        if ($parameters && count($parameters->getData())) {
            $data = $parameters->getData();
            
            if(!isset($data['customer_id'])){
                return array(['success' => false]);
            }
           
            $customerData=$this->customerapi->load($data['customer_id']);
          
            if(!$customerData->getId()){
                return array(['success' => false]);
            }
            
            if (isset($data['customer_id']) && $data['customer_id'])
                $data['customer']=$data['customer_id'];
            else
                $data['customer']=0;
                $deviceObject = $this->wishlist->removeItem($data);
                return array($deviceObject);
        } else {
            return array(['success' => false]);
        }

    }
}

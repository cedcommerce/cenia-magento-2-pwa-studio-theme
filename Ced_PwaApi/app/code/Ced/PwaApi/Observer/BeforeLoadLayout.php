<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_PwaApi
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\PwaApi\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
class BeforeLoadLayout  implements ObserverInterface
{
    protected $_feed;
    protected $_backendAuthSession;
    protected $_objectManager;
    protected $_licenseActivateUrl = null;
    protected $_feedHelper = null;
    const LICENSE_ACTIVATION_URL_PATH = 'system/license/validate_url';
    public function __construct(
        \Ced\PwaApi\Model\Feed $_feed,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Magento\Backend\Model\Auth\Session $backendAuthSession,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->_feed = $_feed;
        $this->_backendAuthSession = $backendAuthSession;
        $this->_objectManager = $objectInterface;
        $this->request = $request;
        $this->_feedHelper = $this->_objectManager->get('Ced\PwaApi\Helper\Feed');
    }

    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
       try {
          
            $action = $observer->getEvent()->getAction();
            $layout = $observer->getEvent()->getLayout();
            $request =  $this->_objectManager->get('Magento\Framework\App\RequestInterface');
            $controllerModule = strtolower($request->getControllerModule());
            $validateArray=array();
            
           
            if($this->request->getModuleName() != 'pwaapi'){ return $this; } 
            $helper = $this->_objectManager->create('Ced\PwaApi\Helper\Feed');
            $modules = $helper->getCedCommerceExtensions();
            foreach ($modules as $moduleName=>$releaseVersion)
            {
                $m = strtolower($moduleName); if(!preg_match('/ced/i',$m)){ return $this; }
             
                $h = $this->_objectManager->create('Ced\PwaApi\Helper\Data')->getStoreConfig(\Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.$m.'_hash'); 
         
                for($i=1;$i<=(int)$this->_objectManager->create('Ced\PwaApi\Helper\Data')->getStoreConfig(\Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.$m.'_level');$i++)
                    {  
                        $h = base64_decode($h);
                    }

                $h = json_decode($h,true);
                if(is_array($h) && isset($h['domain']) && isset($h['module_name']) && isset($h['license']) && strtolower($h['module_name']) == $m && $h['license'] == $this->_objectManager->create('Ced\PwaApi\Helper\Data')->getStoreConfig(\Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.$m))
                 {}else{

                    if(count($validateArray)==0){
                         $validateArray = $this->autoValidateModules(); 
                    }

                    if(isset($validateArray[$moduleName]) && isset($validateArray[$moduleName]['valid']) && $validateArray[$moduleName]['valid'])
                    {
                       continue;
                    }

                 $exist = false; 
                 foreach($layout->getUpdate()->getHandles() as $handle){ 
                    if($handle=='c_e_d_c_o_m_m_e_r_c_e'){ 
                        $exist = true; break; 
                    }
                 } 
                 if(!$exist){ 
                    $layout->getUpdate()->addHandle('c_e_d_c_o_m_m_e_r_c_e');
                  }
               }    
            }
            return $this;
        } catch (\Exception $e) {
            return $this;
        }
    }


    /**
     * Retrieve feed data as XML element
     *
     * @return SimpleXMLElement
     */
    private function autoValidateModules($urlParams = array())
    {
        $result = false;

        $body = '';
        $urlParams = array_merge($this->_feedHelper->getEnvironmentInformation(),$urlParams);
        
        if (is_array($urlParams) && count($urlParams) > 0) {
            $body = $this->_feedHelper->addParams('',$urlParams);
            $body = trim($body,'?');
          
        }
        try {
            $ch = curl_init();                  
            curl_setopt($ch, CURLOPT_URL,$this->getLicenseActivateUrl());   
            curl_setopt($ch, CURLOPT_POST, 1);                  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);              
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                    
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            $result = curl_exec($ch);   
            $info = curl_getinfo($ch);  
            curl_close ($ch);
            $resultArray=array();
            if(isset($info['http_code']) && $info['http_code']!=200) return false;
            $result = json_decode($result,true);
            foreach ($result as $moduleName => $response) {
                if ($response && isset($response['hash']) && isset($response['level'])) {
             
                    $json = array('success'=>0,'message'=>__('There is an Error Occurred.'),'valid'=>0);
                    $valid = $response['hash'];
                    try {
                        for($i = 1;$i<=$response['level'];$i++){
                            $valid = base64_decode($valid);
                        }
                        $valid = json_decode($valid,true);

                        if(is_array($valid) && 
                            isset($valid['domain']) && 
                            isset($valid['module_name']) && 
                            isset($valid['license']) &&
                            $valid['module_name'] == $moduleName                       
                        )
                        {
                            $path = \Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.strtolower($moduleName).'_hash';
                              $this->_feedHelper->setDefaultStoreConfig($path, $response['hash'], 0);
                            $path = \Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.strtolower($moduleName).'_level';
                             $this->_feedHelper->setDefaultStoreConfig($path, $response['level'], 0);
                            $path = \Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.strtolower($moduleName);
                            $this->_feedHelper->setDefaultStoreConfig($path, $valid['license'], 0);
                            $json['success'] = 1;
                            $json['valid'] = 1;
                            $json['message'] = __('Module Activated successfully.');
                        } else {
                            $json['success'] = 0;
                            $json['valid'] = 0;
                            $json['message'] = isset($response['error']['code']) && isset($response['error']['msg']) ? 'Error ('.$response['error']['code'].'): '.$response['error']['msg'] : __('Invalid License Key.');
                        }
                    } catch (\Exception $e) {
                        $json['success'] = 0;
                        $json['valid'] = 0;
                        $json['message'] = $e->getMessage();
                    }
                }
                $resultArray[$moduleName] = $json;
            }
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/auto_validation.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info(print_r($resultArray,true));
           
        } catch (\Exception $e) {
            return false;
        }

        return $result;
    }

    /**
     * Retrieve local license url
     *
     * @return string
     */
    private function getLicenseActivateUrl()
    {
        if (is_null($this->_licenseActivateUrl)) {
            $this->_licenseActivateUrl = 'https://'
                . $this->_feedHelper->getStoreConfig(self::LICENSE_ACTIVATION_URL_PATH);
        }
        return $this->_licenseActivateUrl;
    }
    

}

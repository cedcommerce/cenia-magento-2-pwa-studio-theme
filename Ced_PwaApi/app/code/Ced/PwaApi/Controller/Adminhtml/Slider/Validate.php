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
  * @author   	 CedCommerce Core Team <connect@cedcommerce.com >
  * @copyright   Copyright CEDCOMMERCE (http://cedcommerce.com/)
  * @license      http://cedcommerce.com/license-agreement.txt
  */
namespace Ced\PwaApi\Controller\Adminhtml\Slider;

use Magento\Framework\Message\Error;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Ced\PwaApi\Model\PwaSliderFactory;

class Validate extends \Magento\Backend\App\Action
{
    
	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;
	protected $resultJsonFactory;
	/**
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 */
	public function __construct(
			Context $context,
			PageFactory $resultPageFactory,
			\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
      PwaSliderFactory $pwaSliderFactory
	) {
		parent::__construct($context);
		$this->resultJsonFactory = $resultJsonFactory;
		$this->resultPageFactory = $resultPageFactory;
    $this->pwaSliderFactory = $pwaSliderFactory;
	}
	
    protected function _validateField($response)
    {
        $messages = [];
        $postdata = $this->getRequest()->getPostValue('slider_fieldset');
        $postdata['id'] = isset($postdata['id']) ? $postdata['id'] : "";
        if (!is_array($postdata)) {
            return;
        }
        $slider  = $this->pwaSliderFactory->create()->load($postdata['code'],'code')->getData();
       if(count($slider)>0 && $slider['id'] != $postdata['id'])
       {
       	$messages[] = __('Slider Code already exist');
       	$response->setMessages($messages);
       	$response->setError(1);
       }
       
               
            
       
    }

    /**
     * AJAX customer validation action
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $response->setError(0);

        $customer = $this->_validateField($response);
       
        $resultJson = $this->resultJsonFactory->create();
        if ($response->getError()) {
            $response->setError(true);
            $response->setMessages($response->getMessages());
        }

        $resultJson->setData($response);
        return $resultJson;
    }
}

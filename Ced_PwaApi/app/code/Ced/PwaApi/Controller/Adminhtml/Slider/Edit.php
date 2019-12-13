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
 * @package     Ced_PincodeChecker
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\PwaApi\Controller\Adminhtml\Slider;
use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{

    protected $_coreRegistry = null;


    protected $resultPageFactory;


    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Ced\PwaApi\Model\PwaSlider $pwaSlider
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->pwaSlider = $pwaSlider;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_PwaApi::pwaapi_pwaapi')
            ->addBreadcrumb(__('ManageSlider'), __('ManageSlider'))
            ->addBreadcrumb(__('Manage Slider'), __('Manage Slider'));
        return $resultPage;
    }

    public function execute()
    {
        $sliderName = "New Item";
        $id = $this->getRequest()->getParam('id');
        if($id){
            $sliderName = $this->pwaSlider->load($id)->getSliderName();
        }
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
           __($sliderName),
           __($sliderName)
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Slider'));
        $resultPage->getConfig()->getTitle()
            ->prepend( __($sliderName));

        return $resultPage;
    }
}

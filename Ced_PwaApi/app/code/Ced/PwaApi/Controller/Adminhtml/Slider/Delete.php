<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ced\PwaApi\Controller\Adminhtml\Slider;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ced\PwaApi\Model\PwaSliderFactory;

/**
 * Class MassDelete
 */
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context, 
        PwaSliderFactory $pwaSliderFactory
    )
    {
        $this->pwaSliderFactory = $pwaSliderFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $selected = $this->getRequest()->getParam('selected');
        if (!is_array($selected)) {
            $this->messageManager->addErrorMessage(__('Please select slider(s).'));
        }else {
            foreach ($selected as $key => $value) {
                $slideData = $this->pwaSliderFactory->create()->load($value);
                if($slideData->getCode() == 'homeslide'){
                    $this->messageManager->addErrorMessage(__("Homeslide is default home slider"));
                    continue;
                }
                $slideData->delete();
                $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been deleted.', count($selected)));
            }
        }

        return $this->_redirect('*/*/index');
    }
}

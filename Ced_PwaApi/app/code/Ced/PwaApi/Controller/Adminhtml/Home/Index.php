<?php

namespace Ced\PwaApi\Controller\Adminhtml\Home;

class Index extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
       
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    public function execute()
    {
      
        $resultPage = $this->resultPageFactory->create();
       
        return $resultPage;
    }
}

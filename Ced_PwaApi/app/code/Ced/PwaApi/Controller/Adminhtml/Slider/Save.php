<?php

namespace Ced\PwaApi\Controller\Adminhtml\Slider;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Ced\PwaApi\Model\ImageUploader $imageUploader,
        \Ced\PwaApi\Model\PwaSlider $pwaslider
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        $this->pwaslider = $pwaslider;
        parent::__construct($context);
    }

    public function execute()
    {
        $image = $this->_request->getParam('slider_fieldset');
       
        $filePath = [];
        if(isset($image['image'])){
            foreach($image['image'] as $tmpImg){
                if(isset($tmpImg['tmp_name'])){
                $this->imageUploader->moveFileFromTmp($tmpImg['name']);
                $filePath[] = "pwa-theme/slider/".$tmpImg['name'];
            }else{
                $filePath[] = "pwa-theme/slider/".$tmpImg['name'];
            }
            }
            if(isset($image['id'])){
                $this->pwaslider->load($image['id']);
                $this->pwaslider->setSliderName($image['slider_name']);
                $this->pwaslider->setContent(implode(',',$filePath));
                $this->pwaslider->setCode($image['code']);
                $this->pwaslider->setUrl($image['url']);
                $this->pwaslider->setType($image['type']);
                $this->pwaslider->save();
            }else{
                $this->pwaslider->setSliderName($image['slider_name']);
                $this->pwaslider->setContent(implode(',',$filePath));
                $this->pwaslider->setCode($image['code']);
                $this->pwaslider->setUrl($image['url']);
                $this->pwaslider->setType($image['type']);
                $this->pwaslider->save();
            }
            $this->messageManager->addSuccessMessage(__("Details saved Successfully."));
        }else{
            $this->messageManager->addErrorMessage(__("Please select image for Slider."));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('pwaapi/slider/index');
        return $resultRedirect;
    }

    public function _filterSliderData(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['icon'][0]['name'])) {
            $data['icon'] = $data['icon'][0]['name'];
        } else {
            $data['icon'] = null;
        }
        return $data;
    }
}
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
 * @package     Ced_CsAdvTransaction
 * @author   	 CedCommerce Core Team <connect@cedcommerce.com >
 * @copyright   Copyright CEDCOMMERCE (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */
namespace Ced\PwaApi\Ui;

class SliderFormDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * Tickets collection
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    protected $addFieldStrategies;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;
    public $_objectManager;
    protected $_request;
    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Ced\PwaApi\Model\ResourceModel\PwaSlider\CollectionFactory $collectionFactory,
    	\Magento\Framework\ObjectManagerInterface $objectManager,
    	\Magento\Framework\App\RequestInterface $request,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->_objectManager = $objectManager;
        $this->_request = $request;
        
    }

    /**
     * Get data
     *
     * @return array
     */
	
	    
	    public function getData()
	    {

	    	if (isset($this->loadedData)) {
	    		return $this->loadedData;
	    	}
	    	$itemId = $this->_request->getParam('id');

	    	if ( !empty($itemId) ) {
	    		$items = $this->collection->getItems();
                 foreach ($items as $item) {
                    $brand_imgs = [];    
                    $brandData = $item->getData();
                    $brand_imgs = explode(',',$brandData['content']);
                    unset($brandData['content']);
                    $i = 0;
                    foreach($brand_imgs as $brand_img){

                        $brandData['image'][$i]['name'] = substr($brand_img,17);
                        $brandData['image'][$i]['type'] = 'image';
                        $brandData['image'][$i]['url'] = $this->getMediaUrl().$brand_img;
                        $i++;
                    }

                   $this->loadedData[$item->getId()] =['slider_fieldset'=> $brandData]; 
                }

	    		return $this->loadedData;
	    	}

            if (isset($this->_loadedData)) {
            return $this->_loadedData;
    }
	    }

        public function getMediaUrl(){

            $media_dir = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            return $media_dir;
        }
    
}

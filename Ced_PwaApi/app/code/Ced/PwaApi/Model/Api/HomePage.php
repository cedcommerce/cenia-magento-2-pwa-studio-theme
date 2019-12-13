<?php

namespace Ced\PwaApi\Model\Api;

use Ced\PwaApi\Api\HomePageInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\DataObject;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class HomePage implements HomePageInterface
{
    /**
     * @var BestSellersCollectionFactory
     */
    protected $_bestSellersCollectionFactory;

    public $_objectManager;
    /**
     * BestSellerProducts constructor.
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Visibility $catalogProductVisibility
     * @param DateTime $dateTime
     * @param Data $helperData
     * @param HttpContext $httpContext
     * @param BestSellersCollectionFactory $bestSellersCollectionFactory
     * @param array $data
     */
    public function __construct(
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        HttpContext $httpContext,
        BestSellersCollectionFactory $bestSellersCollectionFactory,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        MailInterface $mail,
        array $data = [],
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_bestSellersCollectionFactory = $bestSellersCollectionFactory;
        $this->pricingHelper = $pricingHelper;
        $this->mail = $mail;
        $this->_objectManager=$objectManager;
        $this->_categoryFactory = $categoryFactory;
        $this->storeManager = $storeManager;
    }

    
    /**
     * Save contact form details
     *
     * @api
     * @param string $name name
     * @param string $email email
     * @param string $telephone telephone
     * @param string $comment comment
     * @return string
     */
    public function saveContactForm($name,$email,$telephone,$comment){
       
        if (trim($name) === '') {
            $data = array (
                    'data' => array (
                            'message' => 'Enter the Name and try again.',
                            'status' => false
                    ) 
            );
        }
        if (trim($comment) === '') {
            $data = array (
                    'data' => array (
                            'message' => 'Enter the comment and try again.',
                            'status' => false
                    ) 
            );
        }
        if (false === \strpos($email, '@')) {
             $data = array (
                    'data' => array (
                            'message' => 'The email address is invalid. Verify the email address and try again.',
                            'status' => false
                    ) 
            );
        }
        try {
            $post = 
            [
                    "name" => $name,
                    "email" => $email,
                    "telephone" => $telephone,
                    "comment" => $comment
            ];

            $this->sendEmail($post);
            $data = array (
                    'data' => array (
                            'message' => 'Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.',
                            'status' => true
                    ) 
            );
        } catch (LocalizedException $e) {
            $data = array (
                    'data' => array (
                            'message' => 'Something went wrong.',
                            'status' => false
                    ) 
            );
        }
        return $data;
    }

    private function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }

    /**
     * Returns categories
     *
     * @api
     * @return string
     */
    public function getNavigationDetails()
    {

        $categoryData = $this->getSecondLevelCategory(4);

        return json_encode($categoryData);
    }

    public function getSecondLevelCategory($store_id = 4)
    {

        $categoryModel = $this->_categoryFactory->create();
        $categories = $categoryModel->setStoreId($store_id)
            ->getCollection()
            ->addAttributeToFilter('level', array('in' => array(2, 3)))
            ->addAttributeToFilter('is_active', '1')
            ->addAttributeToFilter('include_in_menu', '1')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url_path')
            ->addAttributeToSelect('parent_id');

        $categoryPath = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/category/';
        if ($categories) {
            $categories_array = [];
            foreach ($categories as $category) {
                if ($category->getId() == '2')
                    continue;

                if ($category->getLevel() == '2') {
                    $categories_array[$category->getEntityId()] = [
                        'main_category_id' => $category->getEntityId(),
                        'main_category_name' => $category->getName(),
                        'main_category_url' => $category->getUrlPath() . '.html'
                    ];
                }

                if ($category->getLevel() == '3' && isset($categories_array[$category->getParentId()])) {
                    $categories_array[$category->getParentId()]['has_child'] = true;
                    $categories_array[$category->getParentId()]['sub_cats'][] = [
                        'sub_category_id' => $category->getEntityId(),
                        'sub_category_name' => $category->getName(),
                        'has_child' => ($category->hasChildren()) ? true : false,
                        'sub_category_url' => $category->getUrlPath() . '.html',
                        'sub_cats' => $this->getChildCategories($category->getEntityId())
                    ];
                }

            }

            $data['categories'] = $categories_array;
            return $data;
        } else {
            $data = array('categories' => 'You dont have any categories');
            return $data;
        }
    }

    public function getChildCategories($catId)
    {

        $categoryModel = $this->_categoryFactory->create();
        $categories = $categoryModel->setStoreId(4)
            ->getCollection()
            ->addAttributeToFilter('level', array('in' => array(4)))
            ->addAttributeToFilter('parent_id', $catId)
            ->addAttributeToFilter('is_active', '1')
            ->addAttributeToFilter('include_in_menu', '1')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url_path')
            ->addAttributeToSelect('parent_id');
        $categories_array = [];
        $i = 0;
        foreach ($categories as $category) {

            $categories_array[$i]['category_id'] = $category->getEntityId();
            $categories_array[$i]['category_name'] = $category->getName();
            $categories_array[$i]['category_url'] = $category->getUrlPath() . '.html';
            $i++;
        }

        return $categories_array;
    }
    
}
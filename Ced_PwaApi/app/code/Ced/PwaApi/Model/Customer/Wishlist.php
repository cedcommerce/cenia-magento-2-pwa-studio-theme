<?php

namespace Ced\PwaApi\Model\Customer;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Magento\Wishlist\Model\WishlistFactory;
use Magento\Framework\Exception\LocalizedException;

class Wishlist extends \Magento\Framework\Model\AbstractModel
{
    protected $getSession;
    protected $objectManager;
    protected $storeManager;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var WishlistFactory
     */

    protected $wishlistFactory;

    /**
     * @var \Magento\Wishlist\Model\ItemFactory
     */
    protected $itemfactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */

    protected $productRepository;

    protected $eventManager;

    protected $catalogHelper;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */

    protected $productFactory;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Helper\Data $catalogHelper,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Magento\Framework\EntityManager\EventManager $eventManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Wishlist\Model\ItemFactory $itemfactory,
        WishlistFactory $wishlistFactory,
        CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->catalogHelper = $catalogHelper;
        $this->pricingHelper = $pricingHelper;
        $this->productRepository = $productRepository;
        $this->itemfactory = $itemfactory;
        $this->wishlistFactory = $wishlistFactory;
        $this->customerRepository = $customerRepository;
        $this->getSession = $customerSession;
        $this->objectManager=$objectInterface;
        $this->storeManager=$storeManager;
        $this->eventManager = $eventManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

    }


    /**
    * removeItem
    *
    * @param array $data data
    *
    * @return array $data data
    */
    public function removeItem($data) 
    {
        try {
            $customer = $this->customerRepository->getById($data['customer']);
        } catch (NoSuchEntityException $e) {
            $data = array (
                'data' => array (
                    'message' => __('Invalid login or password.'),
                    'status' => 'false'
                )
            );
            return $data;
        }

        $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customer->getId(), true);
        $id = $data['itemId'];
        $item = $this->itemfactory->create()->load($id);
    
        if ($item->getWishlistId() == $wishlist->getId()) {
            try {
                $item->delete();
                $wishlist->save();
                $data = array (
                      'message' => 'The item was successfully removed',
                      'status' => 'true'
                );
                return $data;

            } catch (LocalizedException $e) {
                $data = array (
                    'message' => __('We can\'t delete the item from Wish List right now because of an error: %1.', $e->getMessage()),
                    'status' => 'false'  
                );
                return $data;

            } catch (\Exception $e) {
                $data = array (
                    'message' => __('We can\'t delete the item from the Wish List right now.'),
                    'status' => 'false'  
                );
                return $data;
            }
        } else {
            $data = array (
                'message' => 'Specified item does not exist in wishlist.',
                'status' => 'false'
            );
            return $data;
        }
    }
}

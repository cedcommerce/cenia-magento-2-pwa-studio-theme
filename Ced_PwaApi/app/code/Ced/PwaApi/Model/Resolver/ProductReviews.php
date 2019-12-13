<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ced\PwaApi\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface ;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;

/**
 * Orders data reslover
 */
class ProductReviews extends \Magento\SalesGraphQl\Model\Resolver\Orders
{
    /**
     * @var CollectionFactoryInterface
     */
    private $collectionFactory;

    /**
     * @param CollectionFactoryInterface $collectionFactory
     */
    public function __construct(
        CollectionFactoryInterface $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Review\Model\ResourceModel\Review\Product\CollectionFactory $reviewCollection,
        \Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection $ratingCollection,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
        $this->reviewCollectionFactory = $reviewCollection;
        $this->ratingCollection = $ratingCollection;
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $data = [];
        $customerId = $context->getUserId();
        $currentStoreId = $this->storeManager->getStore()->getId();
        if ($context->getUserId() == 0) {
            return false;
        }
        $reviewCollection = $this->reviewCollectionFactory->create()
                ->addAttributeToSelect('*')
                ->addStoreFilter($currentStoreId)
                ->addCustomerFilter($customerId)
                ->setDateOrder();

        foreach ($reviewCollection as $review) {
            $ratingData = $this->ratingCollection->addFieldToFilter('review_id',$review->getReviewId());
            $ratingCount = (int)$ratingData->getSize();
            $ratingSum = array_sum($ratingData->getColumnValues('percent'));
            $product = $this->productRepository->getById($review->getEntityPkValue());
            $data[] = [
                'created_at' => $review->getCreatedAt(),
                'review' => $review->getTitle(),
                'review_id' => $review->getReviewId(),
                'product_name' => $review->getName(),
                'product_img' => 'catalog/product'.$product->getData('thumbnail'),
                'rating' => (int)$ratingSum / (int)$ratingCount,
                'detail' => $review->getDetail(),
                'url_key' => $product->getUrlKey().'.html'
            ];
        }
        return ['data' => $data];
    }
}

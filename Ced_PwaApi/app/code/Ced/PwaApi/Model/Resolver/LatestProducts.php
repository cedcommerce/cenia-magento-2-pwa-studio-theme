<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ced\PwaApi\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;

/**
 * @inheritdoc
 */
class LatestProducts implements ResolverInterface
{
    /**
     * @var SendFriendHelper
     */
    private $sendFriendHelper;

    /**
     * @var SendEmail
     */
    private $sendEmail;

    /**
     * @param SendEmail $sendEmail
     * @param SendFriendHelper $sendFriendHelper
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper
    ){
        $this->_scopeConfig = $scopeConfig;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->pricingHelper = $pricingHelper;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $collection = $this->_productCollectionFactory->create()
                        ->addAttributeToSelect('*')
                        ->addAttributeToSort('entity_id','desc')
                        ->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
                        ->setPageSize(15);
        
        $products = [];$i= 0;
        foreach ($collection as $product) {
            $image = $product->getImage();

            if(!$image){
                $image = $this->_scopeConfig->getValue('catalog/placeholder/image_placeholder');
            }
            if(!$image){
                continue;
            }

            $price = $this->pricingHelper->currency($product->getData('price'), true, false); 
            $description = $product->getDescription() ? substr($product->getDescription(),0, 150) : ""; 
            $description = $description ." ...";
            $products['data'][$i]['name'] = $product->getName();
            $products['data'][$i]['price'] = $price;
            $products['data'][$i]['final_price'] = $product->getFinalPrice();
            $products['data'][$i]['sku'] = $product->getSku();
            $products['data'][$i]['image'] = $image;
            $products['data'][$i]['description'] = $description;
            $products['data'][$i]['urlkey'] = $product->getUrlKey();
            $i++;
        }
        return $products;
       
    }
}

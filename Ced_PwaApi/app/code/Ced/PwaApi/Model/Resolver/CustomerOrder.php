<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ced\PwaApi\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Orders data reslover
 */
class CustomerOrder implements ResolverInterface {
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface       $orderRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder      $searchCriteriaBuilder
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->priceCurrency = $priceCurrency;
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
        $customerId = $this->getCustomerId($args);
        $customerOrderData = $this->getCustomerOrderData($customerId);

        return $customerOrderData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getCustomerId(array $args): int {
        if (!isset($args['customer_id'])) {
            throw new GraphQlInputException(__('Customer id should be specified'));
        }

        return (int) $args['customer_id'];
    }

    /**
     * @param int $customerId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getCustomerOrderData(int $customerId): array
    {
        try {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('customer_id', $customerId, 'eq')->create();
            $orderList = $this->orderRepository->getList($searchCriteria);

            $customerOrder = [];
            foreach ($orderList as $order) {
                $order_id = $order->getId();
                $customerOrder['fetchRecords'][$order_id]['id'] = $order_id;
                $customerOrder['fetchRecords'][$order_id]['increment_id'] = $order->getIncrementId();
                $customerOrder['fetchRecords'][$order_id]['created_at'] = $order->getCreatedAt();
                $customerOrder['fetchRecords'][$order_id]['grand_total'] = $this->priceCurrency->convertAndFormat($order->getGrandTotal(), false);
                $customerOrder['fetchRecords'][$order_id]['status'] = $order->getStatus();
                $customerOrder['fetchRecords'][$order_id]['status'] = $order->getStatus();
                $customerOrder['fetchRecords'][$order_id]['currency'] = $order->getOrderCurrencyCode();
                $customerOrder['fetchRecords'][$order_id]['ship_to'] = $order->getShippingAddress()->getName();
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $customerOrder;
    }
}

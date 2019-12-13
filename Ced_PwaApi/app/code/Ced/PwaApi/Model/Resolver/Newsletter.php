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
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;

/**
 * @inheritdoc
 */
class Newsletter implements ResolverInterface
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
        CustomerRepository $customerRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Newsletter\Model\Subscriber $subscriber
    ) {
        $this->customerRepository = $customerRepository;
        $this->storeManager = $storeManager;
        $this->subscriberFactory = $subscriberFactory;
        $this->_subscriber = $subscriber;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $email = $args['email'];
        $subscription = $args['subscription'];
        $data = [];
        //print_r($email); print_r($subscription); die('dfgdg');
        if ($email == null || $email == '') {
            $data['success'] = false;
            $data['message'] = 'Something went wrong with your newsletter subscription.';
           return $data;
        } else {
            try { 
          if($subscription){
            $this->subscriberFactory->create()->subscribe($email);
            $data['success'] = true;
            $data['message'] = 'You have successfully subscribed! Thanks for subscribing to our newsletter!';
           return $data;
          }else{
            $this->subscriberFactory->create()->unsubscribe($email);
            $data['success'] = true;
            $data['message'] = 'You have successfully unsubscribed!';
            return $data;
          }
            } catch (\Exception $e) {
                $data['success'] = false;
                $data['message'] = 'Something went wrong with your newsletter subscription.';
                return $data;
            }
        }
    }
}

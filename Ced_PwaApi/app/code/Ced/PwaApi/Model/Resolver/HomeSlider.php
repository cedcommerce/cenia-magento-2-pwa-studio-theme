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
class HomeSlider implements ResolverInterface
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
        \Ced\PwaApi\Model\PwaSlider $pwaSlider
    ) {
       $this->pwaSlider = $pwaSlider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $images = $urls = [];
        $sliders = $this->pwaSlider->load('homeslide','code');
        $images = explode(',' , $sliders->getContent());
        $urls = explode(',' , $sliders->getUrl());
      
        $data = [];
        foreach ($images as $key => $value) {
            $data['allSlides'][$key]['image'] = $value;
                if($key <= sizeof($urls)){
                    if(isset($urls[$key]))
                        $data['allSlides'][$key]['url'] = $urls[$key];  

                    $data['allSlides'][$key]['url'] = "";

                }
        }
        
        return $data;
       
    }
}

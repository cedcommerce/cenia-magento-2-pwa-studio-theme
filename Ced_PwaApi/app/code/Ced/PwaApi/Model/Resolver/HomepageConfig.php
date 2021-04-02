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
class HomepageConfig implements ResolverInterface
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
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $data = [];
        $data['configData'][0]['name'] = "show_home_slider";  
        $data['configData'][0]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/show_home_slider');   
        $data['configData'][1]['name'] = "show_trending_products";
        $data['configData'][1]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/show_trending');   
        $data['configData'][2]['name'] = "show_latest_products"; 
        $data['configData'][2]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/show_latest');   
        $data['configData'][3]['name'] = "show_category_banner"; 
        $data['configData'][3]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/show_category_banner');
        $data['configData'][4]['name'] = "show_offer_banner"; 
        $data['configData'][4]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/show_offer_banner');  
        $data['configData'][5]['name'] = "show_category_icon"; 
        $data['configData'][5]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/show_category_icon');
        $data['configData'][6]['name'] = "categories_icon_block"; 
        $data['configData'][6]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/categories_icon_block'); 
        $data['configData'][7]['name'] = "categories_banner_block"; 
        $data['configData'][7]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/categories_banner_block'); 
        $data['configData'][8]['name'] = "offer_banner_block"; 
        $data['configData'][8]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/offer_banner_block'); 
        $data['configData'][9]['name'] = "ced_pwa_footer"; 
        $data['configData'][9]['value'] = $this->_scopeConfig->getValue('ced_pwa/general/footer_block'); 
        $data['configData'][10]['name'] = "email"; 
        $data['configData'][10]['value'] = $this->_scopeConfig->getValue('trans_email/ident_general/email');
        return $data;
       
    }
}

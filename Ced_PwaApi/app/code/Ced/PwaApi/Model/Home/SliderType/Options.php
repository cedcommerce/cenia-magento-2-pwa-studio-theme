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
 * @package     Ced_PwaApi
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */
namespace Ced\PwaApi\Model\Home\SliderType;

use \Magento\Store\Model\StoreRepository;

class Options extends \Magento\Framework\DataObject
    implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var Rate
     */
    protected $_storeRepository;
    protected $_storeManager;

    /**
     * @param StoreRepository      $storeRepository
     */
    public function __construct(
        StoreRepository $storeRepository,
        \Magento\Store\Model\StoreManagerInterface $storemanager
    ) {
        $this->_storeManager =$storemanager;
        $this->_storeRepository = $storeRepository;
    }

    public function toOptionArray()
    {
        return [
            ['value' => 'slider',
                'label' => __('Slider')
            ],
            [
                'value' => 'banner',
                'label' => __('Banner')
            ]
        ];


    }

}
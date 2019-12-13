<?php

namespace Ced\PwaApi\Model\Api;

class WishlistData extends \Magento\Framework\Model\AbstractExtensibleModel implements \Ced\PwaApi\Api\Data\WishlistInterface
{
    /**#@+
     * Constants
     */

    const KEY_ITEM_ID ='itemId';
    const KEY_PRODID ='prodID';
    const KEY_CUSTOMER_ID ='customer_id';
    const KEY_STORE_ID ='store_id';
    /**#@-*/
    /**
     * {@inheritdoc}
     *
     * @return $this this
     */
    public function getItemId()
    {
        return $this->getData(self::KEY_ITEM_ID);
    }

     /**
     * setType
     *
     * @param string $itemId itemId
     *
     * @return $this
     */
    public function setItemId($itemId)
    {
        return $this->setData(self::KEY_ITEM_ID, $itemId);
    }  
    /**#@-*/
    /**
     * {@inheritdoc}
     *
     * @return $this this
     */
    public function getProdID()
    {
        return $this->getData(self::KEY_PRODID);
    }

     /**
     * setType
     *
     * @param int $prodID prodID
     *
     * @return $this this
     */
    public function setProdID($prodID)
    {
        return $this->setData(self::KEY_PRODID, $prodID);
    }  
     /**#@-*/
    /**
     * {@inheritdoc}
     *
     * @return $this this
     */
    public function getCustomerId()
    {
        return $this->getData(self::KEY_CUSTOMER_ID);
    }

     /**
     * Set password
     *
     * @param string $customer_id customer_id
     *
     * @return $this this
     */
    public function setCustomerId($customer_id)
    {
        return $this->setData(self::KEY_CUSTOMER_ID, $customer_id);
    }   
         /**#@-*/
    /**
     * {@inheritdoc}
     *
     * @return $this this
     */
    public function getStoreId()
    {
        return $this->getData(self::KEY_STORE_ID);
    }

     /**
     * setStoreId
     *
     * @param string $store_id store_id
     *
     * @return $this
     */
    public function setStoreId($store_id)
    {
        return $this->setData(self::KEY_STORE_ID, $store_id);
    } 
   
}

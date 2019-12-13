<?php

namespace Ced\PwaApi\Api\Data;

interface WishlistInterface
{
    /**
    * Set setType
    *
    * @param int $item_id item_id
    *
    * @return int
    */
    public function setItemId($item_id);
    /**
    * getItemId
    *
    * @return int|null
    */
    public function getItemId();
    /**
    *setProdID
    *
    * @param int $prodid prodid
    *
    * @return int
    */
    public function setProdID($prodid);
    /**
    * Get setType
    *
    * @return int|null
    */
    public function getProdID();
	  /**
	    * Set customer_id
	    *
	    * @param int $customer_id customer_id
	    *
	    * @return int
	    */
	    public function setCustomerId($customer_id);
	    /**
	        * Get CustomerId
	        *
	        * @return int|null
	        */
    public function getCustomerId(); 
	 /**
	    * Set store_id
	    *
	    * @param int $store_id store_id
	    *
	    * @return int
	    */
    public function setStoreId($store_id);
    /**
        * Get StoreId
        *
        * @return int|null
        */
    public function getStoreId(); 
 
}

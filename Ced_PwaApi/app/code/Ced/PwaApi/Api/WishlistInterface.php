<?php

namespace Ced\PwaApi\Api;

interface WishlistInterface
{
       /**
	   * Gets the json.
	   *
	   * @param \Ced\PwaApi\Api\Data\WishlistInterface $parameters parameters
	   *
	   * @return []
	   */
       public function remove(\Ced\PwaApi\Api\Data\WishlistInterface $parameters);    
}

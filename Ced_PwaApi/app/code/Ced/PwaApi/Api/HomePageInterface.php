<?php
namespace Ced\PwaApi\Api;

interface HomePageInterface
{
    
    /**
     * Save contact form details
     *
     * @api
     * @param string $name name
     * @param string $email email
     * @param string $telephone telephone
     * @param string $comment comment
     * @return string
     */
    public function saveContactForm($name,$email,$telephone,$comment);

    /**
     * Returns categories
     *
     * @api
     * @return string
     */
    public function getNavigationDetails();

}
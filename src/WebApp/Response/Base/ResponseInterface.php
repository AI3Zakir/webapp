<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 7/1/18
 * Time: 4:54 PM
 */

namespace WebApp\Response\Base;

/**
 * Interface ResponseInterface
 * @package WebApp\Response\Base
 */
interface ResponseInterface
{
    /**
     * Process response
     *
     * @return mixed
     */
    public function process();
}
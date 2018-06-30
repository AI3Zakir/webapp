<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 4:27 AM
 */

namespace WebApp\Controller\Base;

abstract class Controller
{
    /**
     * @var array
     */
    private $request;

    /**
     * @var array
     */
    private $query;

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @param array $request
     */
    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @param array $query
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }
}
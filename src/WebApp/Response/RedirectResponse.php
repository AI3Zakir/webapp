<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 7/1/18
 * Time: 5:07 PM
 */

namespace WebApp\Response;


use WebApp\Response\Base\ResponseInterface;

/**
 * Class RedirectResponse
 * @package WebApp\Response
 */
class RedirectResponse implements ResponseInterface
{
    /**
     * @var string
     */
    private $redirectUri;

    /**
     * RedirectResponse constructor.
     * @param string $redirectUri
     */
    public function __construct(string $redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }


    /**
     * Redirect To URI
     */
    public function process(): void
    {
        header('location: ' . $this->redirectUri);
    }
}
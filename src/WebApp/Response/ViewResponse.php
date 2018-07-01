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
 * Class ViewResponse
 * @package WebApp\Response
 */
class ViewResponse implements ResponseInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $templateName;

    /**
     * ViewResponse constructor.
     * @param $templateName string
     * @param $data array
     */
    public function __construct($templateName, array $data = [])
    {
        $this->data = $data;
        $this->templateName = $templateName;
        $loader = new \Twig_Loader_Filesystem('../src/WebApp/views/');
        $this->twig = new \Twig_Environment($loader, [
            'debug' => true,
            'cache' => 'cache'
        ]);
        $this->twig->addExtension(new \Twig_Extension_Debug());
    }


    /**
     * Process response
     *
     * @return mixed
     */
    public function process()
    {
        try {
            echo $this->twig->render($this->templateName, $this->data);
        } catch (\Twig_Error_Loader $e) {
            echo $e->getMessage();
        } catch (\Twig_Error_Runtime $e) {
            echo $e->getMessage();
        } catch (\Twig_Error_Syntax $e) {
            echo $e->getMessage();
        }
    }
}
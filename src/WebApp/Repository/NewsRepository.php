<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 2:00 AM
 */

namespace WebApp\Repository;

use WebApp\Model\News;
use WebApp\Repository\Base\BaseRepository;

class NewsRepository extends BaseRepository
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * NewsRepository constructor.
     */
    public function __construct()
    {
        try {
            parent::__construct();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        try {
            $this->authorRepository = new AuthorRepository();
        } catch (\Exception $e) {
        }
    }

    public function getAll(): array
    {
        $result = parent::getAll();

        /**
         * @var News $item
         */
        foreach ($result as $item) {
            $item->setAuthor($this->authorRepository->getById($item->getAuthor()));
        }

        return $result;
    }

}
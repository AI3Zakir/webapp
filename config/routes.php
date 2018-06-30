<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 3:20 PM
 */
return [
    '/' => ['GET', 'HomeController', 'home'],
    '/news' => ['GET', 'NewsController', 'showNews'],
    '/news/add' => [
        ['GET', 'NewsController', 'addNews'],
        ['POST', 'NewsController', 'postNews']
    ],
    '/news/edit' => [
        ['GET', 'NewsController', 'editNews'],
        ['POST', 'NewsController', 'postNews']
    ],
    '/news/delete' => [
        ['GET', 'NewsController', 'deleteNews'],
        ['POST', 'NewsController', 'deleteNews']
    ],
    '/authors' => ['GET', 'AuthorController', 'showAuthors'],
    '/author/add' => [
        ['GET', 'AuthorController', 'addAuthor'],
        ['POST', 'AuthorController', 'postAuthor']
    ],
    '/author/edit' => [
        ['GET', 'AuthorController', 'editAuthor'],
        ['POST', 'AuthorController', 'postAuthor']
    ],
    '/author/delete' => [
        ['GET', 'AuthorController', 'deleteAuthor'],
        ['POST', 'AuthorController', 'deleteAuthor']
    ],

];

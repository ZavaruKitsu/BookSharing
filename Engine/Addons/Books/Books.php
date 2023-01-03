<?php


namespace Engine\Addons\Books;

use Engine\Addons\History\History;
use Engine\Helpers;
use Engine\TemplateConfig;
use R;
use RedBeanPHP\OODBBean;


/**
 * Class Books
 * @package Engine\Addons\Books
 */
class Books
{
    /**
     * @param $name
     * @param $author
     * @param $desk
     * @param $ownerId
     * @param bool $hidden
     * @return bool
     */
    public static function addBook($name, $author, $desk, $ownerId, $hidden = false)
    {
        if (self::findBook($name, $author) != null)
            return false;
        $book = R::dispense('books');
        $book->name = $name;
        $book->author = $author; // автору 0 лет (не баньте)
        $book->owner = $ownerId;
        $book->desc = Helpers::replaceNewLines($desk);
        $book->image = 'example.jpg';
        $book->state = 'great';
        $book->hidden = $hidden;

        R::store($book);

        History::addHistory($book->id, $ownerId, 'reading');

        return $book->id;
    }

    /**
     * @param $name
     * @param $author
     * @return NULL|OODBBean
     */
    public static function findBook($name, $author)
    {
        return R::findOne('books', 'name = ? AND author = ?', [$name, $author]);
    }

    /**
     * @param $status
     * @return string
     */
    public static function statusToText($status)
    {
        switch (strtolower($status)) {
            case 'queued':
                return 'В очереди';
                break;
            case 'reading':
                return 'Читает';
                break;
            case 'read':
                return 'Прочитал';
                break;
            case 'canceled':
                return 'Отменил';
                break;
        }
        return 'В очереди (???)';
    }

    /**
     * @param $id
     * @return array
     */
    public static function getOwnedById($id)
    {
        return R::findAll('books', 'owner = ?', [$id]);
    }

    /**
     * @param $bookId
     * @param $userId
     * @return bool
     */
    public static function isOwnedById($bookId, $userId)
    {
        if (R::findOne('books', 'id = ? AND owner = ?', [$bookId, $userId]) == null)
            return false;
        return true;
    }

    /**
     * @param $desc
     * @return string
     */
    public static function descShorten($desc)
    {
        $length = strlen($desc);
        if ($length < 199)
            return $desc;
        return mb_substr($desc, 0, 450, 'utf-8') . '...';
    }

    /**
     * @param $id
     * @param $param
     * @param $value
     * @return bool
     */
    public static function editBook($id, $param, $value)
    {
        $book = self::getById($id);
        if ($book == null)
            return false;
        $book[$param] = $value;
        R::store($book);
        return true;
    }

    /**
     * @param $id
     * @return OODBBean
     */
    public static function getById($id)
    {
        return R::load('books', $id);
    }

    /**
     * @param int $page
     * @param bool $isAdmin
     * @return array
     */
    public static function getByOffset($page = 1, $isAdmin = false)
    {
        if (!$isAdmin)
            return R::findAll('books', 'hidden = ? ORDER BY id DESC LIMIT ? OFFSET ?', [0, TemplateConfig::$booksPerPage, (($page - 1) * TemplateConfig::$booksPerPage)]);
        else
            return R::findAll('books', 'ORDER BY id DESC LIMIT ? OFFSET ?', [TemplateConfig::$booksPerPage, (($page - 1) * TemplateConfig::$booksPerPage)]);
    }

    /**
     * @return int
     */
    public static function countBooks($isAdmin = false)
    {
        if ($isAdmin == false)
            return R::count('books', 'hidden = ?', [0]);
        else
            return R::count('books');
    }

    /**
     * @param $id
     * @return false|float|int
     */
    public static function countBookRating($id)
    {
        $book = self::getById($id);
        if ($book == null)
            return 0;
        $history = History::getFullBookHistoryById($id);
        $pluses = 0;
        $amount = 0;
        foreach ($history as $item) {
            if ($item->rating != null) {
                $pluses += $item->rating;
                $amount++;
            }
        }
        if ($amount == 0)
            return 0;
        return round($pluses / $amount, 2);
    }

}
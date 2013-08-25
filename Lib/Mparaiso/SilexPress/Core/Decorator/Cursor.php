<?php
namespace Mparaiso\SilexPress\Core\Decorator;

use MongoCursor;

class Cursor implements \Iterator
{
    /**
     * @var MongoCursor
     */
    protected $cursor;
    /**
     * @var string
     */
    protected $className;

    function __construct(MongoCursor $mongoCursor, $className)
    {
        $this->cursor = $mongoCursor;
        $this->className = $className;
    }

    function __call($name, $arguments)
    {
        if (method_exists($this->cursor, $name))
            return call_user_func_array(array($this->cursor, $name), $arguments);
    }

    function current()
    {
        return new $this->className($this->cursor->current());
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->cursor->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->cursor->key();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->cursor->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->cursor->rewind();
    }
}


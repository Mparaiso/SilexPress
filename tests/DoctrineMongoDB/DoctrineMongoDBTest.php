<?php


use Doctrine\MongoDB\Database;

class DoctrineMongoDBTest extends \PHPUnit_Framework_TestCase
{
    protected $c;
    /**
     * @var Database
     */
    protected $db;
    protected $collection = "silexpress_test_collection";

    function setUp()
    {
        parent::setUp();
        $this->c = Bootstrap::getContainer();
    }

    function provider()
    {
        return array(
            array(
                array(
                    array("title" => "Harry Potter", "author" => "Rowlings"),
                    array("title" => "Lord of the rings", "author" => "Tolkien"),
                    array("title" => "Foundation", "author" => "Asimov"),
                    array("title" => "Dune", "author" => "Herbert"),
                )
            )
        );
    }

    /**
     * @dataProvider provider
     * @param $books
     */
    function testDatabase($books)
    {
        $this->assertNotNull($this->c['mongo.database']);
        $db = $this->c["mongo.database"];
        $this->db = $db;
        /* @var Database $db */
        $bookCollection = $db->selectCollection($this->collection);
        $this->assertInstanceOf('Doctrine\MongoDB\Collection', $bookCollection);
        $bookCollection->batchInsert($books);
        $bookCount = $bookCollection->count();
        $this->assertEquals(count($books), $bookCount);
        $bookCollection->remove($books[0]);
        $bookCount = $bookCollection->count();
        $this->assertEquals(count($books) - 1, $bookCount);
        $bookCollection->upsert(array("title" => "Harry Potter"), array("title" => "Harry Potter and the Philosopher's Stone"));
    }

    function tearDown()
    {
        parent::tearDown();
        $this->c = Bootstrap::getContainer();
        $this->db->dropCollection($this->collection);
    }


}

<?php


use Doctrine\MongoDB\Database;
use Silex\WebTestCase;
/**
 * 
 * @author mark prades
 * Doctrine ODM integration test
 */
class DoctrineMongoDBTest extends WebTestCase
{

    /**
     * 
     * @var Database
     */
    protected $db;
    protected $collection = "silexpress_test_collection";
   
    function createApplication(){
        return Bootstrap::getApp();
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
        $this->assertNotNull($this->app['mp.mongo']);
        $db = $this->app['mp.mongo'];
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
        $this->db=$this->app['mp.mongo'];
        $this->db->dropCollection($this->collection);
    }


}

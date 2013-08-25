<?php

use Mparaiso\SilexPress\Core\Decorator\Cursor;
use Mparaiso\SilexPress\Core\Model\Post;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

class PostTest extends WebTestCase
{
    function __construct()
    {

    }

    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        $app = Bootstrap::getApp();
        $app["sp.core.vars.collection.post"] = "test_posts";
        return $app;
    }

    protected $post_content = "Test";

    function testFind()
    {
        $post = new Post(array("post_content" => $this->post_content));
        $this->app["sp.core.service.post"]->persist($post);
        $result = $this->app["sp.core.service.post"]->find($post["_id"]);
        $this->assertEquals(true, $result != null);
        $this->assertEquals($this->post_content, $result["post_content"]);
        $this->assertTrue($result instanceof Post);
    }

    function testFindOnBy()
    {
        $post = new Post(array("post_content" => $this->post_content));
        $this->app["sp.core.service.post"]->persist($post);
        $result = $this->app["sp.core.service.post"]->findOneBy(array("_id" => $post["_id"]));
        $this->assertEquals(true, $result != null);
        $this->assertEquals($this->post_content, $result["post_content"]);
    }

    function testPersist()
    {
        $title = "Post Title";
        $content = "Test";
        $post = new Post(array("post_title" => $title, "post_content" => $this->post_content));
        $this->app["sp.core.service.post"]->persist($post);
        $result = $this->app["sp.core.service.post"]->find($post["_id"]);
        $this->assertTrue($result != null);
        $this->assertTrue($result instanceof Post);
    }

    /**
     */
    function testRemove()
    {
        $post = new Post(array("post_title" => "Post Title", "post_content" => $this->post_content));
        $this->app["sp.core.service.post"]->persist($post);
        $this->app["sp.core.service.post"]->remove($post);
        $result = $this->app["sp.core.service.post"]->find($post["_id"]);
        $this->assertTrue($result == null);

    }

    function testFindAll()
    {
        $posts = array();
        $posts[0] = new Post(array("post_content" => $this->post_content));
        $posts[1] = new Post(array("post_title" => "Post Title", "post_content" => $this->post_content));
        foreach ($posts as $post) {
            $this->app["sp.core.service.post"]->persist($post);
        }
        $results = $this->app["sp.core.service.post"]->findAll();
        /* @var Cursor $result */
        $this->assertEquals(2, $results->count());
    }

    function tearDown()
    {
        $posts = $this->app["sp.core.service.post"]->findAll();
        foreach ($posts as $post):
            $this->app["sp.core.service.post"]->remove($post);
        endforeach;
    }
}

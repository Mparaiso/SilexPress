<?php

use Mparaiso\SilexPress\Core\Model\Post;
use Mparaiso\SilexPress\Core\Service\Base;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

class CoreServiceProviderTest extends WebTestCase
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
        return Bootstrap::getApp();
    }

    public function testMongoDBConnection()
    {
        $this->assertTrue($this->app["sp.core.db.connection"] instanceof \MongoDB);
        $this->assertTrue($this->app["sp.core.service.post"] instanceof Base);
    }

    function testSpCoreServicePost()
    {
        $title = "Post Title";
        $content = "test";
        $post = new Post(array("post_title" => $title, "post_content" => $content));
        $this->app["sp.core.service.post"]->persist($post);
        $result = $this->app["sp.core.service.post"]->findOneBy(array("post_title" => $title));
        $this->assertTrue($result != null);
        $this->assertTrue($result instanceof Post);
    }

    function tearDown()
    {
        $posts = $this->app["sp.core.service.post"]->findBy(array("post_content" => "test"));
        foreach ($posts as $post):
            $this->app["sp.core.service.post"]->remove($post);
        endforeach;
    }
}

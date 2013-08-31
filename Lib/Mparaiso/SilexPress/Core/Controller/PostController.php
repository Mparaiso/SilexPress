<?php

namespace Mparaiso\SilexPress\Core\Controller {

    use Model\Manager\IPostManager;
    use Silex\Application;
    use Silex\ControllerProviderInterface;
    use Symfony\Component\HttpKernel\HttpKernelInterface;

    class PostController implements ControllerProviderInterface
    {


        //public function connect(Application $app)
        //{
        // créer un nouveau controller basé sur la route par défaut
        //  $postController = $app['controllers_factory'];
//      $postController->get('/feature', array($this,"getFeaturedPosts") )->bind("post.featured");
//      $postController->match("/", array($this,"index"))->bind("post.index");
//      $postController->get("/tag/{tag}", array($this,"getByTag") )->bind("post.getbytag")->convert( 'tag',function($tag){return urldecode($tag);} );
//      //get by username
//      $postController->match('/user/{username}',array($this,"getByUsername"))->bind("post.getbyusername");
        //    return $postController;
        //}

        /**
         * Get latest posts.
         * @param Application $app
         * @return mixed
         */
        public function index(Application $app)
        {
            $posts = $app['sp.core.service.post']->findByDateDesc();
            return $app["twig"]->render("silexpress/front/index.twig", array('posts' => $posts, "message" => "homepage"));
        }

        function read(Application $app, $id, $title)
        {
            $post = $app["sp.core.service.post"]->find($id);
            if ($post == null):
                return $app->redirect($app["url_generator"]->generate("post.index"));
            endif;
            return $app["twig"]->render("silexpress/front/post/get.twig", array("post" => $post));
        }

//        function getByTag(Application $app, $tag)
//        {
//            $posts = $this->postManager->getByTag($tag);
//            return $app['twig']->render("post/getbytag.twig", array("tag" => $tag, 'posts' => $posts));
//        }

//        function paginator($items, $current_page = null, $item_per_page = 5)
//        {
//            if ($current_page !== null):
//                $items = array_slice($items, ((int)$current_page - 1) * (int)$item_per_page, $item_per_page);
//            endif;
//            return $items;
//        }
//
//        function getFeaturedPosts(Application $app)
//        {
//            $posts = $this->postManager->getFirstThreePosts();
//            return $app['twig']->render('post/featured.twig', array('posts' => $posts));
//        }
//
//        /**
//         * get all posts from user
//         * @param Application app a silex application
//         * @param string username the name of the user
//         * @return string
//         */
//        public function getByUsername(Application $app, $username)
//        {
//            $user = $this->userManager->getByUsername($username); // get user
//            $userId = $user['_id']; // get user id
//            $posts = $this->postManager->getByUserId($userId); // get posts by user id
//            return $app['twig']->render('post/getbyusername.twig', array('posts' => $posts, 'username' => $user['username']));
//        }

        public function connect(Application $app)
        {
            // créer un nouveau controller basé sur la route par défaut
            $controllers = $app['controllers_factory'];
            $controllers->match("/", array($this, 'index'))->bind("post.index");
            $controllers->get("/{id}/{title}", array($this, "read"))
                ->value("title", "")
                ->bind("post.get");
            return $controllers;
        }

    }
}
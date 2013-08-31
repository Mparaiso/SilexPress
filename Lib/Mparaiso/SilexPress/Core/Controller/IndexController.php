<?php
namespace Mparaiso\SilexPress\Core\Controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;

    class IndexController implements ControllerProviderInterface
    {
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


        public function connect(Application $app)
        {
            // créer un nouveau controller basé sur la route par défaut
            $controllers = $app['controllers_factory'];
            $controllers->match("/", array($this, 'index'))->bind("post.index");
            return $controllers;
        }
    }

}
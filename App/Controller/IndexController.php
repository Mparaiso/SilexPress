<?php
namespace Controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;

    class IndexController implements ControllerProviderInterface
    {
        /**
         * @var string
         */
        public $form = "this is a form";

        public function index(Application $app)
        {
            $articles = $app['article_manager']->getArticles( /*sorting*/
                array('created_at' => -1));
            return $app["twig"]->render("index/index.twig", array('articles' => $articles, "message" => "homepage"));
        }

        public function about(Application $app)
        {
            return $app["twig"]->render("index/about.twig");
        }

        public function contact(Application $app)
        {
            return $app["twig"]->render("index/contact.twig");
        }

        public function connect(Application $app)
        {
            // créer un nouveau controller basé sur la route par défaut
            $index = $app['controllers_factory'];
            $index->match("/", array($this, 'index'))->bind("index.index");
            $index->match("/about", array($this, 'about'))->bind("index.about");
            $index->match("/contact", array($this, 'contact'))->bind("index.contact");
            return $index;
        }
    }

}
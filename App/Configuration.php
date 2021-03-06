<?php
use Model\Manager\SessionManager;
use Mparaiso\Provider\ConsoleServiceProvider;
use Mparaiso\Provider\CoreServiceProvider;
use Mparaiso\Provider\CrudServiceProvider;
use Mparaiso\Provider\GravatarServiceProvider;
use Mparaiso\Provider\MediaServiceProvider;
use Mparaiso\SilexPress\Core\Constant\Roles;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mparaiso\Provider\DoctrineMongoDBServiceProvider;

class Configuration implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app
     *            An Application instance
     */
    public function register(Application $app)
    {
       
            
            // providers
            // twig
        $app->register(new TwigServiceProvider(), array(
            "twig.path" => __DIR__ . "/view",
            /**
             * EN : adding custom form templates to the template array
             * FR : ajouter des templates personalisés au tableau de templates
             */
            "twig.form.templates" => array(
                'form_div_layout.html.twig',
                "form/form_div_layout.twig"
            ),
            'twig.options' => array(
                'cache' => __DIR__ . '/../temp/twig', /* 'strict_variables' => false */)
        ));
        // form
        $app->register(new FormServiceProvider());
        // session
        $app->register(new SessionServiceProvider(), array(
            'session.storage.handler' => $app->share(function (Application $app)
            {
                // EN : overloading defaut session storage handler
                // FR : surcharge du session.storage.handler
                return $app['session_manager'];
            })
        ));
        // console
        $app->register(new ConsoleServiceProvider());
        // trans
        $app->register(new TranslationServiceProvider(), array(
            "locale_fallback" => "en"
        ));
        // url generator
        $app->register(new UrlGeneratorServiceProvider());
        // validation
        $app->register(new ValidatorServiceProvider());
        // monolog
        $app->register(new MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__ . '/../temp/' . date("Y-m-d") . '.log',
            'monolog.name' => 'silexpress',
                /*'monolog.handler' => $app->share(
                    function (Application $app) {
                        return new MongoDBHandler($app['config.mongo'], $app['config.database'], "log");
                    }
                ),*/
            ));
        // security
        /**
         * Security
         * EN : note : all the app must be behind the firewall
         * the firewall must allow anonymous users
         * then you need to define credentials for some parts of the app behind the firewall
         * with the security.access_rules container
         */
        $app->register(new SecurityServiceProvider(), array(
            'security.firewalls' => array(
                'admin' => array(
                    'pattern' => '^/',
                    "anonymous" => true,
                    'form' => array(
                        'login_path' => "/user/login",
                        'check_path' => "/admin/user/dologin",
                        "default_target_path" => "/admin",
                        "always_use_default_target_path" => true,
                        'username_parameter' => 'login[username]',
                        'password_parameter' => 'login[password]',
                        "csrf_parameter" => "login[_token]",
                        "failure_path" => "/user/login"
                    ),
                    'logout' => array(
                        'logout_path' => "/admin/user/logout",
                        "target" => '/',
                        "invalidate_session" => true
                    // "delete_cookies" => array(
                    // "silexpress.local" => array("domain" => "silexpress.local", "path" => "/")
                    // )
                                        ),
                    'users' => function (Application $app)
                    {
                        return $app['user_manager'];
                    }
                )
            ),
            'security.access_rules' => array(
                array(
                    '^/admin',
                    'ROLE_SUBSCRIBER'
                )
            ),
            'security.role_hierarchy' => $app->share(function ($app)
            {
                return Roles::getRoles();
            })
        ));
        // cache
        $app->register(new HttpCacheServiceProvider(), array(
            'http_cache.cache_dir' => __DIR__ . '/../temp/http',
            'http_cache.esi' => null
        ));
        $app->register(new ServiceControllerServiceProvider());
        
        // CUSTOM SERVICES
        // Gravatar
        $app->register(new GravatarServiceProvider());
        $app['config.server'] = getenv('SILEXPRESS_DBSERVER') ? getenv('SILEXPRESS_DBSERVER') : "localhost";
        $app['config.database'] = getenv("SILEXPRESS_DBNAME ") ? getenv("SILEXPRESS_DBNAME") : "tests";
        $app['config.akismet_apikey'] = getenv('AKISMET_APIKEY');
        $app['config.site_title'] = "Mongo Blog";
        $app['config.default_user_role'] = "ROLE_WRITER";
        $app["config.mongo"] = $app->share(function ($app)
        {
            return new \Mongo($app['config.server']);
        });
        // session manager
        $app['session_manager'] = $app->share(function ($app)
        {
            $sessionManager = new SessionManager($app['config.mongo'], $app['config.database']);
            return $sessionManager;
        });
        // user manager
        $app['user_manager'] = $app->share(function ($app)
        {
            return new Model\Manager\UserManager($app['config.mongo'], $app['config.database'], $app);
        });
        
        // article manager
        $app['article_manager'] = $app->share(function ($app)
        {
            return new Model\Manager\ArticleManager($app['config.mongo'], $app['config.database']);
        });
        // comment manager
        $app['comment_manager'] = $app->share(function (\Silex\Application $app)
        {
            return new Model\Manager\CommentManager($app["config.mongo"], $app["config.database"]);
        });
        $app['spam_manager'] = $app->share(function (\Silex\Application $app)
        {
            // return new Model\Manager\SpamManager($app['config.mongo'], $app['config.database'], $_SERVER["HTTP_HOST"], $app['config.akismet_apikey']);
            return new Model\Manager\SpamManager($app['config.mongo'], $app['config.database'], "", $app['config.akismet_apikey']);
        });
        
        /**
         *
         * @var $app['option_manager'] Model\Manager\OptionManager *
         */
        $app['options'] = $app->share(function ($app)
        {
            return $app["sp.core.service.option"];
        });
        
        // FILTERS
        // EN : check if the user owns the resource.
        // FR : vérifie si l'utilisateur est propriétaire de la resource.
        $app['filter.mustbeowner'] = $app->protect(function (Request $request) use($app)
        {
            $user = $app['user_manager']->getUSer();
            $resource_id = $request->get('id');
            if ($app['article_manager']->belongsTo($resource_id, $user['_id']) == false) {
                $app['session']->setFlash("error", "You cant access this resource!");
                return $app->redirect($app['url_generator']->generate('index.index'));
            }
        });
        
        $app['filter.mustbeadmin'] = $app->protect(

        function (Request $request) use($app)
        {
            if (false === $app['security']->isGranted('ROLE_ADMIN')) {
                $user = $app['user_manager']->getUser();
                $app['session']->setFlash('error', 'You cant access this resouce!');
                $app['monolog']->addWarning('unauthorized access from user ' . $user->username . ' to ' . $request->getRequestURI());
                return $app->redirect($app['url_generator']->generate('index.index'));
            }
        });
        
        // using symfony reverse proxy
        // equest::trustProxyData();
        
        /**
         * allowed tags for content rendering in the view *
         */
        $app['silexblog.config.allowedTags'] = '<a>,<b>,<u>,<small>,<strong>,<li>,<ol>,<ul>,<img>,<h3>,<h4>,<h5>,<h6>,<p>';
        
        /**
         * 3rd party service configurations
         */
        $app->register(new DoctrineMongoDBServiceProvider(), array(
            "mp.mongo.server" => $app['config.server'],
            "mp.mongo.db" => $app['config.database']
        ));
        $app->register(new GravatarServiceProvider);
        $app->register(new CrudServiceProvider);
        $app->register(new CoreServiceProvider);
        $app->register(new MediaServiceProvider(), array(
            "sp . media . vars . upload_dir" => __DIR__ . " /../upload",
            "sp . media . template . layout" => $app->share(function ($app)
            {
                return $app["sp.core.template.admin.layout"];
            })
        ));
        
        if ($app["debug"] === TRUE) {
            $app->register(new WebProfilerServiceProvider(), array(
                "profiler.cache_dir" => __DIR__ . "/../temp/profiler"
            ));
        }
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {}
}
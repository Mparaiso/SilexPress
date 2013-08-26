<?php

namespace Mparaiso\SilexPress\Provider;


use Mparaiso\CodeGeneration\Controller\CRUD;
use Mparaiso\SilexPress\Core\Service\Base;
use Mparaiso\SilexPress\Core\Service\Post as PostService;
use Mparaiso\SilexPress\Core\Service\Term as TermService;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CoreServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        // vars
        $app["sp.core.vars.admin_route_prefix"] = "/admin";
        // templates
        $app["sp.core.template.path"] = __DIR__ . "/../Core/Resources/views";
        $app["sp.core.template.admin.layout"] = 'admin\admin-layout.twig'; // default layout

        // \MongoDB

        $app["sp.core.db.connection"] = $app->share(function ($app) {
            $mongo = new \MongoClient($app['config.server']);
            return $mongo->selectDB($app['config.database']);
        });
        $app["sp.core.collection.option"] = "options"; // name of the option collection
        $app["sp.core.model.option"] = 'Mparaiso\SilexPress\Core\Model\Option'; // option model class
        $app["sp.core.service.option"] = $app->share(function ($app) { //option manager
            return new Base($app["sp.core.db.connection"], $app["sp.core.collection.option"], $app["sp.core.model.option"]);
        });

        // POSTS vars

        $app["sp.core.collection.post"] = "posts"; // name of the posts collection
        $app["sp.core.model.post"] = 'Mparaiso\SilexPress\Core\Model\Post'; // post model class
        $app["sp.core.form.post"] = 'Mparaiso\SilexPress\Core\Form\Post'; // post model class
        $app["sp.core.service.post"] = $app->share(function ($app) {
            return new PostService($app["sp.core.db.connection"], $app["sp.core.collection.post"], $app["sp.core.model.post"]);
        });
        // post admin controller
        $app["sp.core.crud.post"] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["sp.core.model.post"],
                "formClass" => $app["sp.core.form.post"],
                "service" => $app["sp.core.service.post"],
                "resourceName" => "post",
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig"
            ));
        });

        // PAGES vars

        $app["sp.core.collection.page"] = "posts"; // name of the pages collection
        $app["sp.core.model.page"] = 'Mparaiso\SilexPress\Core\Model\Page'; // page model class
        $app["sp.core.form.page"] = 'Mparaiso\SilexPress\Core\Form\Page'; // page model class
        $app["sp.core.service.page"] = $app->share(function ($app) {
            $service = new PostService($app["sp.core.db.connection"], $app["sp.core.collection.page"], $app["sp.core.model.page"]);
            $service->setPosttype("page");
            return $service;
        });
        // page admin controller
        $app["sp.core.crud.page"] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["sp.core.model.page"],
                "formClass" => $app["sp.core.form.page"],
                "service" => $app["sp.core.service.page"],
                "resourceName" => "page",
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig"
            ));
        });

        /**
         *
         * Terms
         *
         */

        $app["sp.core.collection.term"] = "terms"; // name of the pages collection
        $app["sp.core.model.term"] = 'Mparaiso\SilexPress\Core\Model\Term'; // page model class
        $app["sp.core.form.term"] = 'Mparaiso\SilexPress\Core\Form\Term'; // page model class

        // Categories

        $app["sp.core.service.category"] = $app->share(function ($app) {
            $service = new TermService($app["sp.core.db.connection"], $app["sp.core.collection.term"], $app["sp.core.model.page"]);
            $service->setTaxonomy("category");
            return $service;
        });
        $app["sp.core.crud.category"] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["sp.core.model.term"],
                "formClass" => $app["sp.core.form.term"],
                "service" => $app["sp.core.service.category"],
                "resourceName" => "category",
                "collectionName" => "categories",
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig"
            ));
        });

        // Tags

        $app["sp.core.service.tag"] = $app->share(function ($app) {
            $service = new TermService($app["sp.core.db.connection"], $app["sp.core.collection.term"], $app["sp.core.model.page"]);
            $service->setTaxonomy("tag");
            return $service;
        });
        $app["sp.core.crud.tag"] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["sp.core.model.term"],
                "formClass" => $app["sp.core.form.term"],
                "service" => $app["sp.core.service.tag"],
                "resourceName" => "tag",
                "collectionName" => "tags",
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig"
            ));
        });
    }


    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public
    function boot(Application $app)
    {
        // EN : add new folders to twig
        $app['twig.loader.filesystem']->addPath($app["sp.core.template.path"]);
        // add controllers
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.post"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.page"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.category"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.tag"]);
    }
}

<?php

namespace Mparaiso\Provider;


use Mparaiso\CodeGeneration\Controller\CRUD;
use Mparaiso\SilexPress\Core\Controller\AdminController;
use Mparaiso\SilexPress\Core\Controller\IndexController;
use Mparaiso\SilexPress\Core\Controller\PostController;
use Mparaiso\SilexPress\Core\Controller\UserController;
use Mparaiso\SilexPress\Core\Form\Extension\SilexPressExtension;
use Mparaiso\SilexPress\Core\Service\Base;
use Mparaiso\SilexPress\Core\Service\Menu;
use Mparaiso\SilexPress\Core\Service\Option as OptionService;
use Mparaiso\SilexPress\Core\Service\Post as PostService;
use Mparaiso\SilexPress\Core\Service\Term as TermService;
use Mparaiso\SimpleRest\Controller\Controller as ApiController;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Form\FormBuilder;

/**
 * Class CoreServiceProvider
 * @package Mparaiso\Provider
 *
 * Silexpress core service configuration.
 */
class CoreServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        // vars
        $app["sp.core.vars.admin_route_prefix"] = "/admin";
        $app["sp.core.vars.api_route_prefix"] = "/api";
        // templates
        $app["sp.core.template.path"] = __DIR__ . "/../SilexPress/Core/Resources/views";
        $app["sp.core.template.front.layout"] = "silexpress/front/layout.html.twig";
        $app["sp.core.template.admin.layout"] = 'silexpress/admin/layout.html.twig'; // default layout

        // MongoDB
        $app["sp.core.db.connection"] = $app->share(function ($app) {
            $mongo = new \MongoClient($app['config.server']);
            return $mongo->selectDB($app['config.database']);
        });

        // Post
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
                "formTemplate" => "/silexpress/admin/crud/includes/post-form.html.twig",
                "service" => $app["sp.core.service.post"],
                "resourceName" => "post",
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig",
                "propertyList" => array("post_title")
            ));
        });
        // Page
        $app["sp.core.collection.page"] = "posts"; // name of the pages collection
        $app["sp.core.model.page"] = 'Mparaiso\SilexPress\Core\Model\Post'; // page model class
        $app["sp.core.form.page"] = 'Mparaiso\SilexPress\Core\Form\Page'; // page model class
        $app["sp.core.service.page"] = $app->share(function ($app) {
            $service = new PostService($app["sp.core.db.connection"], $app["sp.core.collection.page"], $app["sp.core.model.page"]);
            $service->setPosttype("page");
            return $service;
        });
        // page API
        $app["sp.core.api.page"] = $app->share(function ($app) {
            return new ApiController(array(
                "resource" => "page",
                "model" => $app["sp.core.model.page"],
                "service" => $app["sp.core.service.page"],
                "allow" => array("read", "index", "count")
            ));
        });
        // page admin controller
        $app["sp.core.crud.page"] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["sp.core.model.page"],
                "formClass" => $app["sp.core.form.page"],
                "formTemplate" => "/silexpress/admin/crud/includes/post-form.html.twig",
                "service" => $app["sp.core.service.page"],
                "resourceName" => "page",
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig",
                "propertyList" => array("post_title")
            ));
        });
        // Terms
        $app["sp.core.collection.term"] = "terms"; // name of the pages collection
        $app["sp.core.model.term"] = 'Mparaiso\SilexPress\Core\Model\Term'; // page model class
        $app["sp.core.form.term"] = 'Mparaiso\SilexPress\Core\Form\Term'; // page model class
        // Category
        $app["sp.core.service.category"] = $app->share(function ($app) {
            $service = new TermService($app["sp.core.db.connection"], $app["sp.core.collection.term"], $app["sp.core.model.term"]);
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
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig",
                "propertyList" => array("name")
            ));
        });
        // category API
        $app["sp.core.api.category"] = $app->share(function ($app) {
            return new ApiController(array(
                "debug" => $app["debug"],
                "resource" => "category",
                "resourcePluralize" => "categories",
                "model" => $app["sp.core.model.term"],
                "service" => $app["sp.core.service.category"],
                "allow" => array("read", "index", "count")
            ));
        });
        // Tag
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
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig",
                "propertyList" => array("name")
            ));
        });

        // Comment
        $app["sp.core.model.comment"] = 'Mparaiso\SilexPress\Core\Model\Comment';
        $app["sp.core.collection.comment"] = "comments";
        $app["sp.core.service.comment"] = $app->share(function ($app) {
            return new Base($app["sp.core.db.connection"], $app["sp.core.collection.comment"], $app["sp.core.model.comment"]);
        });
        // Menus
        $app["sp.core.model.menu"] = 'Mparaiso\SilexPress\Core\Model\Post';
        $app["sp.core.form.menu"] = 'Mparaiso\SilexPress\Core\Form\Menu'; // page model class
        $app["sp.core.collection.menu"] = "posts";
        $app["sp.core.service.menu"] = $app->share(function ($app) {
            return new Menu($app["sp.core.db.connection"], $app["sp.core.collection.menu"], $app["sp.core.model.menu"]);
        });
        $app["sp.core.api.menu"] = $app->share(function ($app) {
            return new ApiController(
                array("resource" => "menu",
                    "allow" => array("index", "read", "count"),
                    "debug" => $app["debug"], "service" => $app["sp.core.service.menu"],
                    "model" => $app["sp.core.model.menu"],
                )
            );
        });
        $app["sp.core.crud.menu"] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["sp.core.model.menu"],
                "formClass" => $app["sp.core.form.menu"],
                "service" => $app["sp.core.service.menu"],
                "formTemplate" => 'silexpress/admin/form/menu.html.twig',
                "resourceName" => "menu",
                "collectionName" => "menus",
                "templateLayout" => "silexpress/admin/crud/crud-layout.html.twig",
            ));
        });
        # Option
        $app["sp.core.collection.option"] = "options"; // name of the option collection
        $app["sp.core.form.option.general"] = 'Mparaiso\SilexPress\Core\Form\GeneralSettings'; // name of the option collection
        $app["sp.core.form.option.reading"] = 'Mparaiso\SilexPress\Core\Form\ReadingSettings'; // name of the option collection
        $app["sp.core.form.option.writing"] = 'Mparaiso\SilexPress\Core\Form\WritingSettings'; // name of the option collection
        $app["sp.core.form.option.media"] = 'Mparaiso\SilexPress\Core\Form\MediaSettings'; // name of the option collection
        $app["sp.core.form.option.permalink"] = 'Mparaiso\SilexPress\Core\Form\PermalinkSettings'; // name of the option collection
        $app["sp.core.model.option"] = 'Mparaiso\SilexPress\Core\Model\Option';
        $app["sp.core.service.option"] = $app->share(function ($app) {
            return new OptionService($app["sp.core.db.connection"], $app["sp.core.collection.option"], $app["sp.core.model.option"]);
        });
        $app["sp.core.controller.admin"] = $app->share(function ($app) {
            return new AdminController();
        });
        //CONTROLLERS
        $app["sp.core.controller.index"] = $app->share(function ($app) {
            return new IndexController();
        });
        $app["sp.core.controller.user"] = $app->share(function ($app) {
            return new UserController();
        });
    }


    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        // register new form type extension
        $app['form.extensions'] = $app->share($app->extend("form.extensions", function ($extensions, $app) {
            $extensions[] = new SilexPressExtension($app["sp.core.db.connection"]);
            return $extensions;
        }));
        // EN : add new folders to twig
        $app['twig.loader.filesystem']->addPath($app["sp.core.template.path"]);
        // add controllers
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.post"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.page"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.category"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.tag"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.crud.menu"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.controller.user"]);
        $app->mount($app["sp.core.vars.admin_route_prefix"], $app["sp.core.controller.admin"]);
        /* admin category api */
        $app->mount($app["sp.core.vars.admin_route_prefix"] . $app["sp.core.vars.api_route_prefix"], $app["sp.core.api.category"]);
        /* admin page api */
        $app->mount($app["sp.core.vars.admin_route_prefix"] . $app["sp.core.vars.api_route_prefix"], $app["sp.core.api.page"]);
        /* admin menu api */
        $app->mount($app["sp.core.vars.admin_route_prefix"] . $app["sp.core.vars.api_route_prefix"], $app["sp.core.api.menu"]);
        $app->mount("/", $app["sp.core.controller.index"]);
    }
}

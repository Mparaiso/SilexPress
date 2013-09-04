<?php

namespace Mparaiso\Provider;

use Mparaiso\SilexPress\Media\Controller\IndexController;
use Mparaiso\SilexPress\Media\Service\Attachment;
use Mparaiso\SilexPress\Media\Service\Upload;
use Silex\Application;

class MediaServiceProvider implements \Silex\ServiceProviderInterface
{

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        /**
         * EN : upload folder
         * FR : le dossier de téléchargement par défaut
         */
        $app["sp.media.vars.upload_dir"] = sys_get_temp_dir();

        // connection alias
        $app["sp.media.db.connection"] = $app->share(function ($app) {
            return $app["sp.core.db.connection"];
        });
        /**
         * Model
         */

        /**
         * Attachment Services
         */
        $app["sp.media.model.attachement"] = $app->share(function ($app) {
            return $app["sp.core.model.post"];
        });
        $app["sp.media.collection.attachement"] = 'posts';
        $app["sp.media.service.attachment"] = $app->share(function ($app) {
            $service = new Attachment($app["sp.media.db.connection"],
                $app["sp.media.collection.attachement"],
                $app["sp.media.model.attachement"]);
            return $service;
        });
        $app["sp.media.service.upload"] = $app->share(function ($app) {
            return new Upload($app["sp.media.db.connection"], $app["sp.media.vars.upload_dir"],
                $app["sp.media.service.attachment"], $app["sp.media.model.attachement"]);
        });
        // the form type instance for file upload
        $app["sp.media.form.upload"] = function ($app) {
            return new \Mparaiso\SilexPress\Media\Form\Upload;
        };
        // controllers
        $app["sp.media.controller.index"] = function ($app) {
            return new IndexController();
        };
        // template path
        $app["sp.media.template.path"] = __DIR__ . "/../SilexPress/Media/Resources/Views";
        // templates
        $app["sp.media.template.layout"] = 'silexpress\admin\media\layout.html.twig'; // default layout
        $app["sp.media.template.new"] = 'silexpress\admin\media\new.html.twig';
        $app["sp.media.template.upload"] = 'silexpress\admin\media\upload.html.twig';
        $app["sp.media.template.edit"] = 'silexpress\admin\media\edit.html.twig';
        // route prefix
        $app["sp.media.route_prefix"] = "/admin/media";

    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        // EN : add new folders to twig
        $app['twig.loader.filesystem']->addPath($app["sp.media.template.path"]);

        // mount controllers
        $app->mount($app["sp.media.route_prefix"], $app["sp.media.controller.index"]);
    }
}
<?php

namespace Mparaiso\SilexPress\Provider;

use Mparaiso\SilexPress\Admin\Media\Controller\IndexController;
use Mparaiso\SilexPress\Admin\Media\Service\Upload;
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

        $app["sp.media.db.connection"] = $app->share(function ($app) {
            return $app["sp.core.db.connection"];
        });
        /**
         * Services
         */
        $app["sp.media.service.upload"] = $app->share(function ($app) {
            return new Upload($app["sp.media.db.connection"], $app["sp.media.vars.upload_dir"]);
        });
        // the form type instance for file upload
        $app["sp.media.form.upload"] = function ($app) {
            return new \Mparaiso\SilexPress\Admin\Media\Form\Upload;
        };
        // controllers
        $app["sp.media.controller.index"] = function ($app) {
            return new IndexController();
        };
        // template path
        $app["sp.media.template.path"] = __DIR__ . "/Resources/Views";
        // templates
        $app["sp.media.template.new"] = 'silexpress\admin\media\new.html.twig';
        $app["sp.media.template.upload"] = 'silexpress\admin\media\upload.html.twig';
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
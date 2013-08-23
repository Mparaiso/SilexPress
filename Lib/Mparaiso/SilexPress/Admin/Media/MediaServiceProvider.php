<?php

namespace Mparaiso\SilexPress\Admin\Media;

use Silex\Application;

class MediaServiceProvider implements \Silex\ServiceProviderInterface{

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        // some document manager
        $app["fps.document_manager"]=null;
        $controllers = $app["sp.media.controllers"] = $app["controllers_factory"];
        // the form type for file upload
        $app["sp.media.form.upload"]= '\Mparaiso\SilexPress\Admin\Media\Form\Upload';
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
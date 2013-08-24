<?php

namespace Mparaiso\SilexPress\Admin\Media\Controller;

use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController implements \Silex\ControllerProviderInterface
{
    /**
     * Serve attachments by attachment name
     */
    function serve(Application $app, $id)
    {
        $attachment = $app["sp.media.service.upload"]->serve($id);
        if (!$attachment) {
            return new NotFoundHttpException("attachment not found");
        }
        /* @var \MongoGridFSFile $attachment */
        $response = new Response($attachment->getBytes()
            , 200, array(
                "Content-Type" => $attachment->file["type"],
                //"Cache-Control" => "s-maxage=10",
            ));

        $response->setTtl(100);
        $response->setClientTtl(10);
        return $response;
    }

    /**
     * /admin/media/upload<br>
     * list all uploaded files
     * @param Application $app
     */
    function upload(Application $app)
    {
        return $app["twig"]->render($app["sp.media.template.upload"],
            array("files" => $app["sp.media.service.upload"]->findAll()));
    }

    /**
     * /admin/media/new<br>
     * manages file upload through a form
     *
     */
    function _new(Application $app)
    {
        $form = $app["form.factory"]->create($app["sp.media.form.upload"]);
        /* @var $form Form */
        if ($app["request"]->getMethod() == "POST") {
            $form->bind($app["request"]);
            if ($form->isValid()) {
                $app["dispatcher"]->dispatch("sp.admin.media.before_upload", new GenericEvent($form), array("app" => $app));
                /* @var $file UploadedFile */
                $file = $form->get('file')->getData();
                $app["sp.media.service.upload"]->upload($file);
                $app["dispatcher"]->dispatch("sp.admin.media.after_upload", new GenericEvent($form), array("app" => $app, "file" => $file));
                $app["session"]->getFlashBag()->add("success", "File success fully uploaded!");
                return $app->redirect($app["url_generator"]->generate("sp.admin.media.upload"));
            }
        }
        return $app["twig"]->render($app['sp.media.template.new'], array(
            "form" => $form->createView(),
        ));
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app["sp.media.controllers"] = $app["controllers_factory"];
        /* @var ControllerCollection $controllers */
        $controllers->match("/new", array($this, "_new"))->bind("sp.admin.media.new");
        $controllers->match("/upload/{id}", array($this, "serve"))->bind("sp.admin.media.serve");
        $controllers->match("/upload", array($this, "upload"))->bind("sp.admin.media.upload");
        return $controllers;
    }
}

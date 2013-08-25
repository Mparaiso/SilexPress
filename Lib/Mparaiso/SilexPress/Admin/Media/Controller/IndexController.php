<?php

namespace Mparaiso\SilexPress\Admin\Media\Controller;

use Mparaiso\SilexPress\Admin\Media\Form\Attachment;
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
    function read(Application $app, $id)
    {
        $attachment = $app["sp.media.service.upload"]->serve($id);
        if (!$attachment) {
            return new NotFoundHttpException("attachment not found");
        }
        /* @var \MongoGridFSFile $attachment */
        $response = $app->stream(
            function () use ($attachment) {
                $stream = $attachment->getResource();
                while (!feof($stream)) {
                    echo fread($stream, 1024);
                    flush();
                }
            }
            , 200, array(
                "Content-Type" => $attachment->file["type"],
            )
        );

        //$response=new Response($attachment->getBytes(),200,array("Content-Type" => $attachment->file["type"]));
        $response->setTtl(5000);
        $response->setClientTtl(1000);
        return $response;
    }

    /**
     * /admin/media/upload<br>
     * list all uploaded files
     * @param Application $app
     */
    function index(Application $app)
    {
        return $app["twig"]->render($app["sp.media.template.upload"],
            array("attachments" => $app["sp.media.service.upload"]->findAll()));
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
                /* @var $file UploadedFile */
                $file = $form->get('file')->getData();
                $app["dispatcher"]->dispatch("sp.event.media.before_create", new GenericEvent($form), array("app" => $app));
                $app["sp.media.service.upload"]->upload($file);
                $app["dispatcher"]->dispatch("sp.event.media.after_create", new GenericEvent($form), array("app" => $app, "file" => $file));
                $app["session"]->getFlashBag()->add("success", "File success fully uploaded!");
                return $app->redirect($app["url_generator"]->generate("sp.admin.media.upload"));
            }
        }
        return $app["twig"]->render($app['sp.media.template.new'], array(
            "form" => $form->createView(),
        ));
    }

    function update(Application $app, $id)
    {
        $model = $app["sp.media.service.attachement"]->find($id);
        if (!$model) {
            throw new NotFoundHttpException("attachment not found");
        }
        $formType = new Attachment();
        $form = $app["form.factory"]->create($formType, $model);
        if ($app["request"]->getMethod() === "POST") {
            $form->bind($app["request"]);
            if ($form->isValid()) {
                $app["dispatcher"]->dispatch("sp.event.media.before_update", new GenericEvent($model));
                $app["sp.core.service.post"]->persist($model);
                $app["dispatcher"]->dispatch("sp.event.media.after_update", new GenericEvent($model));
                $app["session"]->getFlashBag()->add("success", "post updated");
                return $app->redirect($app["url_generator"]->generate("sp.admin.media.upload"));
            }
        }
        return $app["twig"]->render($app['sp.media.template.edit'],
            array(
                "form" => $form->createView(),
                "attachment" => $model
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
        $controllers->match("/upload/{id}/{filename}", array($this, "read"))->bind("sp.admin.media.serve");
        $controllers->match("/upload", array($this, "index"))->bind("sp.admin.media.upload");
        $controllers->match("/edit/{id}", array($this, "update"))->bind("sp.admin.media.edit");
        return $controllers;
    }
}

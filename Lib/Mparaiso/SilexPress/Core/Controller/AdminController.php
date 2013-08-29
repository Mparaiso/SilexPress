<?php

namespace Mparaiso\SilexPress\Core\Controller;

use Mparaiso\SilexPress\Core\Form\GeneralSettings;
use Mparaiso\SilexPress\Core\Model\Base as BaseModel;
use Mparaiso\SilexPress\Core\Service\Base as BaseService;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class AdminController implements ControllerProviderInterface
{
    public $route_prefix = "options";

    /**
     * EN : Generic method for updating settings.
     * FR : Option générique pour la mise à jour des options.
     * @param Application $app
     * @param Request $req
     * @param $optionPageTitle
     * @param BaseService $service
     * @param BaseModel $modelClass
     * @param AbstractType $formClass
     * @param $redirectUrl
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    function doUpdateOptions(Application $app, Request $req,
                             $optionPageTitle, $service, $modelClass,
                             $formClass, $redirectUrl)
    {
        $model = $service->findOneBy(array());
        if (!$model) $model = new $modelClass();
        $_formType = new $formClass();
        $form = $app["form.factory"]->create($_formType, $model);
        if ($req->getMethod() === "POST") {
            $form->bind($req);
            if ($form->isValid()) {
                $service->persist($model);
                $req->getSession()->getFlashBag()->add("success", "General settings successfully edited");
                return $app->redirect($redirectUrl);
            }
        }
        return $app["twig"]->render('silexpress/admin/form/options.html.twig', array(
            "subtitle" => $optionPageTitle,
            "form" => $form->createView()
        ));
    }

    /**
     * General Settings
     * @param Application $app
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    function general(Application $app, Request $req)
    {
        return $this->doUpdateOptions($app, $req,
            "General Settings",
            $app["sp.core.service.option"],
            $app["sp.core.model.option"], $app["sp.core.form.option.general"],
            $app["url_generator"]->generate("sp.admin.settings.general"));
    }

    /**
     * Reading settings
     * @param Application $app
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    function reading(Application $app, Request $req)
    {
        return $this->doUpdateOptions($app, $req, "Reading Settings", $app["sp.core.service.option"],
            $app["sp.core.model.option"], $app["sp.core.form.option.reading"], $app["url_generator"]->generate("sp.admin.settings.reading")
        );
    }

    function writing(Application $app, Request $req)
    {
        return $this->doUpdateOptions($app, $req, "Reading Settings", $app["sp.core.service.option"],
            $app["sp.core.model.option"], $app["sp.core.form.option.writing"], $app["url_generator"]->generate("sp.admin.settings.writing")
        );
    }

    /**
     * Media Settings
     * @param Application $app
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    function media(Application $app, Request $req)
    {
        return $this->doUpdateOptions($app, $req, "Media Settings", $app["sp.core.service.option"], $app["sp.core.model.option"], $app["sp.core.form.option.media"], $app["url_generator"]->generate("sp.admin.settings.reading"));
    }

    function permalink(Application $app)
    {
        return $this->doUpdateOptions($app, $app["request"], "Permalink Settings", $app["sp.core.service.option"], $app["sp.core.model.option"], $app["sp.core.form.option.permalink"], $app["url_generator"]->generate("sp.admin.settings.permalink"));
    }

    /**
     * {@inheritdoc}
     */
    function connect(Application $app)
    {
        $route_prefix = $this->route_prefix;
        $controllers = $app["controllers_factory"];
        /* @var ControllerCollection $controllers */
        $controllers->match("/$route_prefix/general", array($this, "general"))
            ->bind("sp.admin.settings.general");
        $controllers->match("/$route_prefix/reading", array($this, "reading"))
            ->bind("sp.admin.settings.reading");
        $controllers->match("/$route_prefix/media", array($this, "media"))
            ->bind("sp.admin.settings.media");
        $controllers->match("/$route_prefix/permalink", array($this, "permalink"))
            ->bind("sp.admin.settings.permalink");
        $controllers->match("/$route_prefix/writing", array($this, "writing"))
            ->bind("sp.admin.settings.writing");
        return $controllers;
    }
}

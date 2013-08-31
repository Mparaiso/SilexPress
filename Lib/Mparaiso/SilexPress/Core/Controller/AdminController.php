<?php

namespace Mparaiso\SilexPress\Core\Controller;

use Mparaiso\SilexPress\Core\Event\PostEvents;
use Mparaiso\SilexPress\Core\Form\QuickPost;
use Mparaiso\SilexPress\Core\Model\Base as BaseModel;
use Mparaiso\SilexPress\Core\Model\Post;
use Mparaiso\SilexPress\Core\Service\Base as BaseService;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class AdminController implements ControllerProviderInterface
{
    public $option_route_prefix = "options";

    /**
     * EN: show a dashboard to the authenticated user.
     * FR: montre un dashboard à l'utilisateur authentifié.
     * @param Application $app
     */
    function dashboard(Application $app)
    {
        $formType = new QuickPost();
        $model = new Post();
        $form = $app['form.factory']->create($formType, $model);
        if ($app["request"]->getMethod() === "POST") {
            $form->bind($app["request"]);
            if ($form->isValid()) {
                $app["dispatcher"]->dispatch(PostEvents::BEFORE_PERSIST, new GenericEvent($model, array("app" => $app)));
                $app["sp.core.service.post"]->persist($model);
                $app["dispatcher"]->dispatch(PostEvents::AFTER_PERSIST, new GenericEvent($model, array("app" => $app)));
                $app["session"]->getFlashBag()->add("success", "Post successfully saved!.");
                return $app->redirect($app["url_generator"]->generate("sp.admin.dashboard"));
            }
        }
        return $app["twig"]->render("silexpress/admin/dashboard.html.twig", array(
            "post_count" => $app["sp.core.service.post"]->count(),
            "page_count" => $app["sp.core.service.page"]->count(),
            "category_count" => $app["sp.core.service.category"]->count(),
            "comment_count" => $app["sp.core.service.comment"]->count(),
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

    /**
     * Writing settings
     * @param Application $app
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
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

    /**
     * Permalink settings
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    function permalink(Application $app)
    {
        return $this->doUpdateOptions($app, $app["request"], "Permalink Settings", $app["sp.core.service.option"], $app["sp.core.model.option"], $app["sp.core.form.option.permalink"], $app["url_generator"]->generate("sp.admin.settings.permalink"));
    }

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
     * {@inheritdoc}
     */
    function connect(Application $app)
    {
        $option_route_prefix = $this->option_route_prefix;
        $controllers = $app["controllers_factory"];
        /* @var ControllerCollection $controllers */
        $controllers->match("/", array($this, "dashboard"))
            ->bind("sp.admin.dashboard");
        $controllers->match("/$option_route_prefix/general", array($this, "general"))
            ->bind("sp.admin.settings.general");
        $controllers->match("/$option_route_prefix/reading", array($this, "reading"))
            ->bind("sp.admin.settings.reading");
        $controllers->match("/$option_route_prefix/media", array($this, "media"))
            ->bind("sp.admin.settings.media");
        $controllers->match("/$option_route_prefix/permalink", array($this, "permalink"))
            ->bind("sp.admin.settings.permalink");
        $controllers->match("/$option_route_prefix/writing", array($this, "writing"))
            ->bind("sp.admin.settings.writing");
        return $controllers;
    }
}

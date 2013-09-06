<?php

namespace Mparaiso\SilexPress\Core\Controller;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Gère les utilisateurs de l'application.
 */
class UserController implements ControllerProviderInterface
{


    protected $spamManager;
    protected $userManager;

    function login(Application $app, Request $request)
    {
        $loginForm = $app['form.factory']->create(new \Form\Login());
        $form_error = $app['security.last_error']($request);
        $app['monolog']->addInfo($form_error);
        if ($form_error != null):
            $loginForm->addError(new FormError($form_error));
            $app['session']->getFlashBag()->add("error", "Wrong credentials");
        endif;
        $last_username = $app['session']->get('_security.last_username');
        return $app['twig']->render('user/login.twig', array('loginForm' => $loginForm->createView(), "form_error" => $form_error, 'last_username' => $last_username));
    }

    function signUp(Application $app)
    {
        $registrationForm = $app['form.factory']->create(new \Form\Register());
        if ("POST" == $app["request"]->getMethod()) {
            $registrationForm->bind($app['request']);
            if ($registrationForm->isValid()) {
                $datas = $registrationForm->getData();
                $userManager = $app['user_manager'];
                //username must be unique
                if ($userManager->usernameExists($datas['username']) == true) {
                    $registrationForm->addError(new FormError('username already exists'));
                }
                //email must be unique
                if ($userManager->emailExists($datas['email']) == true) {
                    $registrationForm->addError(new FormError('email already exists'));
                }
                if ($registrationForm->isValid()) {
                    $user = new User();
                    $user['username'] = $datas['username'];
                    $user['firstname'] = $datas['firstname'];
                    $user['lastname'] = $datas['lastname'];
                    $user['email'] = $datas['email'];
                    $user['roles'] = array($app['config.default_user_role']); # must be an array
                    $user['password'] = self::encodePassword($user['username'], $datas['password_repeated'], $app);
                    $user['ip'] = $app['request']->getClientIp();
                    //if (false == $this->spamManager->ipIsSpammer($user['ip'])) { # protect from spammers
                    $userManager->registerUser($user);
                    //add flash success
                    $app['session']->getFlashBag()->add('success', 'Your account was successfully created, please login');
                    return $app->redirect($app['url_generator']->generate('index.index'));
                    //}
                }

            } else {
                $app['session']->getFlashBag()->add('error', 'The form contains errors');

            }
        }
        return $app['twig']->render('user/register.twig', array("form" => $registrationForm->createView()));
    }

    function logout(Application $app)
    {
        $app['session']->getFlashBag()->add('success', "You are logged out!");
        $referer = $app['request']->headers->get('referer');
        return $app->redirect($referer != null ? $referer : $app['url_generator']->generate('index.index'));
    }

    /**
     * Encode a password
     * @return string
     */
    static function encodePassword($username, $nonEncodedPassword, $app)
    {
        $user = new  AdvancedUser($username, $nonEncodedPassword);
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($nonEncodedPassword, $user->getSalt());
        return $encodedPassword;
    }

    function connect(Application $app)
    {
        $this->userManager = $app["user_manager"];
        $this->spamManager = $app["spam_manager"];
        $userAdmin = $app['controllers_factory'];
        $userAdmin->get("/admin/user/profile", array($this, "profile"))->bind("admin.user.profile");
        #@note @silex nommer une route
        $userAdmin->match('/user/login', array($this, "login"))->bind('user.login');
        $userAdmin->get('/admin/user/logout', array($this, "logout"))->bind('user.logout');
        $userAdmin->match('/user/signup', array($this, "signup"))->bind('user.signup');
        return $userAdmin;
    }

    function profile(Application $app)
    {
        $userManager = $app['user_manager'];
        $user = $userManager->getUser();
        return $app['twig']->render('user/profile.twig', array('user' => $user));
    }

    function getDashboard(Application $app)
    {
        return;
    }

}
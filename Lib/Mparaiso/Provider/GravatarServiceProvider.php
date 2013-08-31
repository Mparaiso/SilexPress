<?php

namespace Mparaiso\Provider {

    use Mparaiso\Gravatar\Gravatar;
    use Silex\Application;
    use Silex\ServiceProviderInterface;


    class GravatarServiceProvider implements ServiceProviderInterface
    {

        function register(Application $app)
        {
            $app['gravatar'] = $app->share(
                function (Application $app) {
                    return new Gravatar();
                }
            );
        }

        function boot(Application $app)
        {

        }
    }
}
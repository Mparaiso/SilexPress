<?php
namespace Model\Provider {
    use Model\Entity\User as UserEntity;
    use Model\Manager\IManager;
    use Symfony\Component\Security\Core\User\User;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\Security\Core\User\UserProviderInterface;


    /**
     * provide users to the security service
     */
    class UserProvider implements UserProviderInterface
    {

        protected $_userManager;

        function __construct(IManager $userManager)
        {
            $this->_userManager = $userManager;
        }

        /** UserProviderInterface * */

        function loadUserByUsername($username)
        {
            $_user = $this->_userManager->getCollection->findone(array("username" => $username));
            if (empty($_user)):
                throw new UsernameNotFoundException(sprintf("User %s does not exist", $username)); else:
                $user = new UserEntity($_user);
            endif;
            return new User($user['username'], $user['password'], $user['roles'], $user['enabled'], $user['userNonExpired'], $user['credentialsNonExpired'], $user['userNonLocked']);
        }

        function refreshUser(UserInterface $user)
        {
            if (!$user instanceof User) {
                throw new UnsupportedUserException(sprintf('Instance of "%s" are not supported'), get_class($user));
            }
            $user = $this->_userManager->loadUserByUsername($user->getUsername());
            return new UserEntity($user);
            // return $this->_userManager->getCollection->findone(array('username'=>$user->getUsername()));
        }

        function supportsClass($class)
        {
            return $class === 'Symfony\Component\Security\Core\User\User';
        }
    }
}
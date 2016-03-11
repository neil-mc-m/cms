<?php

namespace LightCMS;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use PDO;

class CustomUserProvider implements UserProviderInterface
{
    private $conn;
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
        $pdo = new DbManager();
        $conn = $pdo->getPdoInstance();
        $this->conn = $conn;
    }

    public function loadUserByUsername($username)
    {
        $stmt = $this->conn->prepare('SELECT * FROM user WHERE username =:username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR, 4);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        // $stmt = $this->conn->executeQuery('SELECT * FROM user WHERE userName = ?', array(strtolower($username)));
        $user = $stmt->fetch();
        var_dump($user);
        if (!$user = $stmt->fetch()) {
            #$app['monolog']->addInfo('you just connected to the database');
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return new User($user['username'], $user['password'], explode(',', $user['roles']), true, true, true, true);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}

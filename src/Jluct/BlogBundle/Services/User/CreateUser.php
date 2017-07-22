<?php
/**
 * Created by PhpStorm.
 * User: Inkognito
 * Date: 21.07.2017
 * Time: 21:59
 */

namespace Jluct\BlogBundle\Services\User;

use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManager;
use Jluct\BlogBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateUser
 * @package Jluct\BlogBundle\Services\User
 */
class CreateUser
{
    private $manager;
    private $encoder;
    
    /**
     * CreateUser constructor.
     * @param EntityManager $manager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManager $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->manager = $manager;
        $this->encoder = $passwordEncoder;
    }
    
    /**
     * Save user in DB
     *
     * @param $array
     * @return bool
     */
    public function createUser($array)
    {
        $user = new User();
        $user->setEmail($array['email']);
        $user->setFirstname($array['firstname']);
        $user->setLastname($array['lastname']);
        $user->setIsActive($array['active']);
        $user->setPassword($array['password']);

        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        if (key_exists('role', $array)) {
            $user->addRole($array['role']);
        }

        $this->manager->persist($user);

        try {
            $this->manager->flush();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }


    }
    
}
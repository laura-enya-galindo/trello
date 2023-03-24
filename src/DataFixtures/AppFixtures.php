<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail('monadresse@email.com');
            $user->setFirstName('Jeanne');
            $user->setLastName('Martin'.$i);
            $user->setRoles(['ROLE_USER']);

            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setPassword($password);

            $manager->persist($user);
        }
       
        for ($j = 0; $j < 20; $j++) {
            $status = $this->status->find(4);
            $task = new Task();
            $task->setTitle('ticket '.$j);
            $task->setContent('Le superbe contenu du ticket !');
            // $task->setCreatedAt(date('06/04/2023'));
            // $task->setCreatedAt(date('06/04/2023'));
            $task->setCreatedAt(new \DateTime());
            $task->setUpdatedAt(new \DateTime());
            // $task->setStatus(mt_rand(4, 6));

            $manager->persist($task);
        }

        $manager->flush();
    }

}

# https://symfonycasts.com/screencast/symfony4-doctrine-relations/fixture-references

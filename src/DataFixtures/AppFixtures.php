<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Competences;
use App\Entity\Formation;
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
        /*$user = new User();
        $user->setName('Gwen');
        $user->setLastName('Devriendt');
        $password = $this->hasher->hashPassword($user, 'ge4z55G5YM');
        $user->setPassword($password);
        $user->setEmail('gwenaelle.devriendt@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();

        $category = new Category();
        $category->setName('Organiser son développement professionnel');

        $manager->persist($category);
        $manager->flush();

        $formation = new Formation();
        $formation->setName('Les Charmilles');
        $formation->setDescription('Description sur les charmilles');
        $formation->setImage('image charmilles');

        $manager->persist($formation);
        $manager->flush();*/

        $skill = new Competences();
        $skill->setNom('Open Classroom');
        $skill->setDescription('Test desciption');
        $skill->setImage('/images/Oc.png');

        $manager->persist($skill);
        $manager->flush();
    }
}

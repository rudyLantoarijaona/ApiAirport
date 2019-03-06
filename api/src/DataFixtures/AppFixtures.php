<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Borrow;
use App\Entity\Borrowers;
use App\Entity\Copybook;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $author = new Author();
            $author->setLastname($faker->lastName);
            $author->setFirstname($faker->firstName);
            $author->setAge(mt_rand(18, 70));
            $manager->persist($author);
        
            $book = new Book();
            $book->setReference(mt_rand(10, 100));
            $book->setName($faker->name);
            $book->setDescription($faker->text);
            $book->setPublicationDate($faker->dateTime);
            $book->setAuthor($author);            
            $manager->persist($book);
        
            $borrowers = new Borrowers();
            $borrowers->setLastname($faker->lastName);
            $borrowers->setFirstname($faker->firstName);
            $borrowers->setPhone($faker->phoneNumber);
            $borrowers->setEmail($faker->email);
            $borrowers->setAddress($faker->address);
            $manager->persist($borrowers);

            $copyBook = new CopyBook();
            $copyBook->setCopyBookNumber(mt_rand(1, 10));            
            $copyBook->setBook($book);            
            $manager->persist($copyBook);

            $borrow = new Borrow();
            $borrow->setBorrowingDate($faker->dateTime);
            $borrow->setReturnDate($faker->dateTime);
            $borrow->setState($faker->colorName);
            $borrow->setBorrowers($borrowers);
            $borrow->setCopyBook($copyBook);
            $manager->persist($borrow);  
            
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setRoles(['ROLE_ADMIN']);            
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $manager->persist($user); 

        }
       $manager->flush();
    }
}

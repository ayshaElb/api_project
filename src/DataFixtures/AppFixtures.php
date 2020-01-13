<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($c=0; $c < 30; $c++) { 
            $customer = new Customer();
            $customer->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName)
                    ->setCompagny($faker->company)
                    ->setEmail($faker->email);
            $manager->persist($customer);
            for ($i=0; $i < mt_rand(3, 10) ; $i++) { 
                $invoice = new Invoice();
                $invoice->setAmount($faker->randomFloat(2, 250, 5000))
                        ->setSentAt($faker->dateTimeBetween('-6 months'))
                        ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                        ->setCustomer($customer);
                $manager->persist($invoice);

            }

        }

        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

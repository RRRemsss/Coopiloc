<?php

namespace App\Test\Controller;

use App\Entity\LandRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LandRegistryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/land/registry/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(LandRegistry::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LandRegistry index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'land_registry[sheet]' => 'Testing',
            'land_registry[parcel]' => 'Testing',
            'land_registry[category]' => 'Testing',
            'land_registry[rentalValue]' => 'Testing',
            'land_registry[property]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new LandRegistry();
        $fixture->setSheet('My Title');
        $fixture->setParcel('My Title');
        $fixture->setCategory('My Title');
        $fixture->setRentalValue('My Title');
        $fixture->setProperty('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LandRegistry');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new LandRegistry();
        $fixture->setSheet('Value');
        $fixture->setParcel('Value');
        $fixture->setCategory('Value');
        $fixture->setRentalValue('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'land_registry[sheet]' => 'Something New',
            'land_registry[parcel]' => 'Something New',
            'land_registry[category]' => 'Something New',
            'land_registry[rentalValue]' => 'Something New',
            'land_registry[property]' => 'Something New',
        ]);

        self::assertResponseRedirects('/land/registry/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSheet());
        self::assertSame('Something New', $fixture[0]->getParcel());
        self::assertSame('Something New', $fixture[0]->getCategory());
        self::assertSame('Something New', $fixture[0]->getRentalValue());
        self::assertSame('Something New', $fixture[0]->getProperty());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new LandRegistry();
        $fixture->setSheet('Value');
        $fixture->setParcel('Value');
        $fixture->setCategory('Value');
        $fixture->setRentalValue('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/land/registry/');
        self::assertSame(0, $this->repository->count([]));
    }
}

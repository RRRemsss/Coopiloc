<?php

namespace App\Test\Controller;

use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/address/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Address::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Address index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'address[name]' => 'Testing',
            'address[streetName]' => 'Testing',
            'address[building]' => 'Testing',
            'address[floor]' => 'Testing',
            'address[city]' => 'Testing',
            'address[postCode]' => 'Testing',
            'address[region]' => 'Testing',
            'address[country]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Address();
        $fixture->setName('My Title');
        $fixture->setStreetName('My Title');
        $fixture->setBuilding('My Title');
        $fixture->setFloor('My Title');
        $fixture->setCity('My Title');
        $fixture->setPostCode('My Title');
        $fixture->setRegion('My Title');
        $fixture->setCountry('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Address');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Address();
        $fixture->setName('Value');
        $fixture->setStreetName('Value');
        $fixture->setBuilding('Value');
        $fixture->setFloor('Value');
        $fixture->setCity('Value');
        $fixture->setPostCode('Value');
        $fixture->setRegion('Value');
        $fixture->setCountry('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'address[name]' => 'Something New',
            'address[streetName]' => 'Something New',
            'address[building]' => 'Something New',
            'address[floor]' => 'Something New',
            'address[city]' => 'Something New',
            'address[postCode]' => 'Something New',
            'address[region]' => 'Something New',
            'address[country]' => 'Something New',
        ]);

        self::assertResponseRedirects('/address/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getStreetName());
        self::assertSame('Something New', $fixture[0]->getBuilding());
        self::assertSame('Something New', $fixture[0]->getFloor());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getPostCode());
        self::assertSame('Something New', $fixture[0]->getRegion());
        self::assertSame('Something New', $fixture[0]->getCountry());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Address();
        $fixture->setName('Value');
        $fixture->setStreetName('Value');
        $fixture->setBuilding('Value');
        $fixture->setFloor('Value');
        $fixture->setCity('Value');
        $fixture->setPostCode('Value');
        $fixture->setRegion('Value');
        $fixture->setCountry('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/address/');
        self::assertSame(0, $this->repository->count([]));
    }
}

<?php

namespace App\Test\Controller;

use App\Entity\Property;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PropertyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/property/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Property::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Property index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'property[type]' => 'Testingtype',
            'property[namePlace]' => 'TestingNamePlace',
            'property[color]' => 'TestingColor',
            'property[acquisitionDate]' => 'TestingAcquisitionDate',
            'property[acquisitionPrice]' => 'TestingAcquisitionPrice',
            'property[acquisitionFee]' => 'TestingAcquisitionFee',
            'property[agencyFee]' => 'TestingAgencyFee',
            'property[propertyValue]' => 'TestingPropertyValue',
            'property[user]' => 'TestingUser',
            'property[address]' => 'TestingAddress',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    // public function testShow(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Property();
    //     $fixture->setType('My Title');
    //     $fixture->setNamePlace('My Title');
    //     $fixture->setColor('My Title');
    //     $fixture->setAcquisitionDate('My Title');
    //     $fixture->setAcquisitionPrice('My Title');
    //     $fixture->setAcquisitionFee('My Title');
    //     $fixture->setAgencyFee('My Title');
    //     $fixture->setPropertyValue('My Title');
    //     $fixture->setUser('My Title');
    //     $fixture->setAddress('My Title');

    //     $this->manager->persist($fixture);
    //     $this->manager->flush();

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Property');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Property();
        $fixture->setType('TestAppt');
        $fixture->setNamePlace('ApptTest');
        $fixture->setColor('Value');
        $fixture->setAcquisitionDate('31/05/1990');
        $fixture->setAcquisitionPrice('100000');
        $fixture->setAcquisitionFee('10000');
        $fixture->setAgencyFee('0');
        $fixture->setPropertyValue('120000');
        $fixture->setUser('Remy');
        $fixture->setAddress('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'property[type]' => 'Something New',
            'property[namePlace]' => 'Something New',
            'property[color]' => 'Something New',
            'property[acquisitionDate]' => 'Something New',
            'property[acquisitionPrice]' => 'Something New',
            'property[acquisitionFee]' => 'Something New',
            'property[agencyFee]' => 'Something New',
            'property[propertyValue]' => 'Something New',
            'property[user]' => 'Something New',
            'property[address]' => 'Something New',
        ]);

        self::assertResponseRedirects('/property/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getNamePlace());
        self::assertSame('Something New', $fixture[0]->getColor());
        self::assertSame('Something New', $fixture[0]->getAcquisitionDate());
        self::assertSame('Something New', $fixture[0]->getAcquisitionPrice());
        self::assertSame('Something New', $fixture[0]->getAcquisitionFee());
        self::assertSame('Something New', $fixture[0]->getAgencyFee());
        self::assertSame('Something New', $fixture[0]->getPropertyValue());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getAddress());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Property();
        $fixture->setType('Value');
        $fixture->setNamePlace('Value');
        $fixture->setColor('Value');
        $fixture->setAcquisitionDate('Value');
        $fixture->setAcquisitionPrice('Value');
        $fixture->setAcquisitionFee('Value');
        $fixture->setAgencyFee('Value');
        $fixture->setPropertyValue('Value');
        $fixture->setUser('Value');
        $fixture->setAddress('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/property/');
        self::assertSame(0, $this->repository->count([]));
    }
}

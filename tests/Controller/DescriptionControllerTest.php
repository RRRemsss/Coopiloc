<?php

namespace App\Test\Controller;

use App\Entity\Description;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DescriptionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/description/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Description::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Description index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'description[area]' => 'Testing',
            'description[numberOfRooms]' => 'Testing',
            'description[numberOfBedrooms]' => 'Testing',
            'description[constructionDate]' => 'Testing',
            'description[numberOfBathrooms]' => 'Testing',
            'description[propertyType]' => 'Testing',
            'description[legalRegime]' => 'Testing',
            'description[furnished]' => 'Testing',
            'description[parking]' => 'Testing',
            'description[dependency]' => 'Testing',
            'description[cellarType]' => 'Testing',
            'description[buildingLot]' => 'Testing',
            'description[thousandths]' => 'Testing',
            'description[equipment]' => 'Testing',
            'description[comment]' => 'Testing',
            'description[privateComment]' => 'Testing',
            'description[property]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Description();
        $fixture->setArea('My Title');
        $fixture->setNumberOfRooms('My Title');
        $fixture->setNumberOfBedrooms('My Title');
        $fixture->setConstructionDate('My Title');
        $fixture->setNumberOfBathrooms('My Title');
        $fixture->setPropertyType('My Title');
        $fixture->setLegalRegime('My Title');
        $fixture->setFurnished('My Title');
        $fixture->setParking('My Title');
        $fixture->setDependency('My Title');
        $fixture->setCellarType('My Title');
        $fixture->setBuildingLot('My Title');
        $fixture->setThousandths('My Title');
        $fixture->setEquipment('My Title');
        $fixture->setComment('My Title');
        $fixture->setPrivateComment('My Title');
        $fixture->setProperty('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Description');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Description();
        $fixture->setArea('Value');
        $fixture->setNumberOfRooms('Value');
        $fixture->setNumberOfBedrooms('Value');
        $fixture->setConstructionDate('Value');
        $fixture->setNumberOfBathrooms('Value');
        $fixture->setPropertyType('Value');
        $fixture->setLegalRegime('Value');
        $fixture->setFurnished('Value');
        $fixture->setParking('Value');
        $fixture->setDependency('Value');
        $fixture->setCellarType('Value');
        $fixture->setBuildingLot('Value');
        $fixture->setThousandths('Value');
        $fixture->setEquipment('Value');
        $fixture->setComment('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'description[area]' => 'Something New',
            'description[numberOfRooms]' => 'Something New',
            'description[numberOfBedrooms]' => 'Something New',
            'description[constructionDate]' => 'Something New',
            'description[numberOfBathrooms]' => 'Something New',
            'description[propertyType]' => 'Something New',
            'description[legalRegime]' => 'Something New',
            'description[furnished]' => 'Something New',
            'description[parking]' => 'Something New',
            'description[dependency]' => 'Something New',
            'description[cellarType]' => 'Something New',
            'description[buildingLot]' => 'Something New',
            'description[thousandths]' => 'Something New',
            'description[equipment]' => 'Something New',
            'description[comment]' => 'Something New',
            'description[privateComment]' => 'Something New',
            'description[property]' => 'Something New',
        ]);

        self::assertResponseRedirects('/description/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getArea());
        self::assertSame('Something New', $fixture[0]->getNumberOfRooms());
        self::assertSame('Something New', $fixture[0]->getNumberOfBedrooms());
        self::assertSame('Something New', $fixture[0]->getConstructionDate());
        self::assertSame('Something New', $fixture[0]->getNumberOfBathrooms());
        self::assertSame('Something New', $fixture[0]->getPropertyType());
        self::assertSame('Something New', $fixture[0]->getLegalRegime());
        self::assertSame('Something New', $fixture[0]->getFurnished());
        self::assertSame('Something New', $fixture[0]->getParking());
        self::assertSame('Something New', $fixture[0]->getDependency());
        self::assertSame('Something New', $fixture[0]->getCellarType());
        self::assertSame('Something New', $fixture[0]->getBuildingLot());
        self::assertSame('Something New', $fixture[0]->getThousandths());
        self::assertSame('Something New', $fixture[0]->getEquipment());
        self::assertSame('Something New', $fixture[0]->getComment());
        self::assertSame('Something New', $fixture[0]->getPrivateComment());
        self::assertSame('Something New', $fixture[0]->getProperty());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Description();
        $fixture->setArea('Value');
        $fixture->setNumberOfRooms('Value');
        $fixture->setNumberOfBedrooms('Value');
        $fixture->setConstructionDate('Value');
        $fixture->setNumberOfBathrooms('Value');
        $fixture->setPropertyType('Value');
        $fixture->setLegalRegime('Value');
        $fixture->setFurnished('Value');
        $fixture->setParking('Value');
        $fixture->setDependency('Value');
        $fixture->setCellarType('Value');
        $fixture->setBuildingLot('Value');
        $fixture->setThousandths('Value');
        $fixture->setEquipment('Value');
        $fixture->setComment('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/description/');
        self::assertSame(0, $this->repository->count([]));
    }
}

<?php

namespace App\Test\Controller;

use App\Entity\LeaseParty;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeasePartyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/lease/party/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(LeaseParty::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LeaseParty index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'lease_party[color]' => 'Testing',
            'lease_party[leasePartyType]' => 'Testing',
            'lease_party[civility]' => 'Testing',
            'lease_party[dateOfBirth]' => 'Testing',
            'lease_party[placeOfBirth]' => 'Testing',
            'lease_party[profession]' => 'Testing',
            'lease_party[monthlyIncome]' => 'Testing',
            'lease_party[rentals]' => 'Testing',
            'lease_party[identityDocuments]' => 'Testing',
            'lease_party[address]' => 'Testing',
            'lease_party[personDetail]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new LeaseParty();
        $fixture->setColor('My Title');
        $fixture->setLeasePartyType('My Title');
        $fixture->setCivility('My Title');
        $fixture->setDateOfBirth('My Title');
        $fixture->setPlaceOfBirth('My Title');
        $fixture->setProfession('My Title');
        $fixture->setMonthlyIncome('My Title');
        $fixture->setRentals('My Title');
        $fixture->setIdentityDocuments('My Title');
        $fixture->setAddress('My Title');
        $fixture->setPersonDetail('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LeaseParty');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new LeaseParty();
        $fixture->setColor('Value');
        $fixture->setLeasePartyType('Value');
        $fixture->setCivility('Value');
        $fixture->setDateOfBirth('Value');
        $fixture->setPlaceOfBirth('Value');
        $fixture->setProfession('Value');
        $fixture->setMonthlyIncome('Value');
        $fixture->setRentals('Value');
        $fixture->setIdentityDocuments('Value');
        $fixture->setAddress('Value');
        $fixture->setPersonDetail('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lease_party[color]' => 'Something New',
            'lease_party[leasePartyType]' => 'Something New',
            'lease_party[civility]' => 'Something New',
            'lease_party[dateOfBirth]' => 'Something New',
            'lease_party[placeOfBirth]' => 'Something New',
            'lease_party[profession]' => 'Something New',
            'lease_party[monthlyIncome]' => 'Something New',
            'lease_party[rentals]' => 'Something New',
            'lease_party[identityDocuments]' => 'Something New',
            'lease_party[address]' => 'Something New',
            'lease_party[personDetail]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lease/party/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getColor());
        self::assertSame('Something New', $fixture[0]->getLeasePartyType());
        self::assertSame('Something New', $fixture[0]->getCivility());
        self::assertSame('Something New', $fixture[0]->getDateOfBirth());
        self::assertSame('Something New', $fixture[0]->getPlaceOfBirth());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getMonthlyIncome());
        self::assertSame('Something New', $fixture[0]->getRentals());
        self::assertSame('Something New', $fixture[0]->getIdentityDocuments());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getPersonDetail());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new LeaseParty();
        $fixture->setColor('Value');
        $fixture->setLeasePartyType('Value');
        $fixture->setCivility('Value');
        $fixture->setDateOfBirth('Value');
        $fixture->setPlaceOfBirth('Value');
        $fixture->setProfession('Value');
        $fixture->setMonthlyIncome('Value');
        $fixture->setRentals('Value');
        $fixture->setIdentityDocuments('Value');
        $fixture->setAddress('Value');
        $fixture->setPersonDetail('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/lease/party/');
        self::assertSame(0, $this->repository->count([]));
    }
}

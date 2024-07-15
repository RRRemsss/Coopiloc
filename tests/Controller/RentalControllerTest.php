<?php

namespace App\Test\Controller;

use App\Entity\Rental;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RentalControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/rental/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Rental::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rental index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'rental[startDate]' => 'Testing',
            'rental[endDate]' => 'Testing',
            'rental[rentalType]' => 'Testing',
            'rental[grossRent]' => 'Testing',
            'rental[charge]' => 'Testing',
            'rental[deposit]' => 'Testing',
            'rental[lease]' => 'Testing',
            'rental[netRent]' => 'Testing',
            'rental[reference]' => 'Testing',
            'rental[purposeUse]' => 'Testing',
            'rental[duration]' => 'Testing',
            'rental[paymentPeriod]' => 'Testing',
            'rental[paymentMethod]' => 'Testing',
            'rental[paymentDate]' => 'Testing',
            'rental[privateComment]' => 'Testing',
            'rental[property]' => 'Testing',
            'rental[leaseParties]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Rental();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setRentalType('My Title');
        $fixture->setGrossRent('My Title');
        $fixture->setCharge('My Title');
        $fixture->setDeposit('My Title');
        $fixture->setLease('My Title');
        $fixture->setNetRent('My Title');
        $fixture->setReference('My Title');
        $fixture->setPurposeUse('My Title');
        $fixture->setDuration('My Title');
        $fixture->setPaymentPeriod('My Title');
        $fixture->setPaymentMethod('My Title');
        $fixture->setPaymentDate('My Title');
        $fixture->setPrivateComment('My Title');
        $fixture->setProperty('My Title');
        $fixture->setLeaseParties('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rental');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Rental();
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setRentalType('Value');
        $fixture->setGrossRent('Value');
        $fixture->setCharge('Value');
        $fixture->setDeposit('Value');
        $fixture->setLease('Value');
        $fixture->setNetRent('Value');
        $fixture->setReference('Value');
        $fixture->setPurposeUse('Value');
        $fixture->setDuration('Value');
        $fixture->setPaymentPeriod('Value');
        $fixture->setPaymentMethod('Value');
        $fixture->setPaymentDate('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setProperty('Value');
        $fixture->setLeaseParties('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rental[startDate]' => 'Something New',
            'rental[endDate]' => 'Something New',
            'rental[rentalType]' => 'Something New',
            'rental[grossRent]' => 'Something New',
            'rental[charge]' => 'Something New',
            'rental[deposit]' => 'Something New',
            'rental[lease]' => 'Something New',
            'rental[netRent]' => 'Something New',
            'rental[reference]' => 'Something New',
            'rental[purposeUse]' => 'Something New',
            'rental[duration]' => 'Something New',
            'rental[paymentPeriod]' => 'Something New',
            'rental[paymentMethod]' => 'Something New',
            'rental[paymentDate]' => 'Something New',
            'rental[privateComment]' => 'Something New',
            'rental[property]' => 'Something New',
            'rental[leaseParties]' => 'Something New',
        ]);

        self::assertResponseRedirects('/rental/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getRentalType());
        self::assertSame('Something New', $fixture[0]->getGrossRent());
        self::assertSame('Something New', $fixture[0]->getCharge());
        self::assertSame('Something New', $fixture[0]->getDeposit());
        self::assertSame('Something New', $fixture[0]->getLease());
        self::assertSame('Something New', $fixture[0]->getNetRent());
        self::assertSame('Something New', $fixture[0]->getReference());
        self::assertSame('Something New', $fixture[0]->getPurposeUse());
        self::assertSame('Something New', $fixture[0]->getDuration());
        self::assertSame('Something New', $fixture[0]->getPaymentPeriod());
        self::assertSame('Something New', $fixture[0]->getPaymentMethod());
        self::assertSame('Something New', $fixture[0]->getPaymentDate());
        self::assertSame('Something New', $fixture[0]->getPrivateComment());
        self::assertSame('Something New', $fixture[0]->getProperty());
        self::assertSame('Something New', $fixture[0]->getLeaseParties());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Rental();
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setRentalType('Value');
        $fixture->setGrossRent('Value');
        $fixture->setCharge('Value');
        $fixture->setDeposit('Value');
        $fixture->setLease('Value');
        $fixture->setNetRent('Value');
        $fixture->setReference('Value');
        $fixture->setPurposeUse('Value');
        $fixture->setDuration('Value');
        $fixture->setPaymentPeriod('Value');
        $fixture->setPaymentMethod('Value');
        $fixture->setPaymentDate('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setProperty('Value');
        $fixture->setLeaseParties('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/rental/');
        self::assertSame(0, $this->repository->count([]));
    }
}

<?php

namespace App\Test\Controller;

use App\Entity\IdentityLeaseParty;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IdentityLeasePartyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/identity/document/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(IdentityLeaseParty::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('IdentityLeaseParty index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'Identity_leaseParty[createdAt]' => 'Testing',
            'Identity_leaseParty[updatedAt]' => 'Testing',
            'Identity_leaseParty[identityDocumentType]' => 'Testing',
            'Identity_leaseParty[identityNumber]' => 'Testing',
            'Identity_leaseParty[expirationDate]' => 'Testing',
            'Identity_leaseParty[uploadIdentityPath]' => 'Testing',
            'Identity_leaseParty[leaseParty]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new IdentityLeaseParty();
        $fixture->setIdentityDocumentType('My Title');
        $fixture->setIdentityNumber('My Title');
        $fixture->setExpirationDate('My Title');


        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('IdentityLeaseParty');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new IdentityLeaseParty();
        $fixture->setIdentityDocumentType('Value');
        $fixture->setIdentityNumber('Value');
        $fixture->setExpirationDate('Value');


        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'Identity_leaseParty[createdAt]' => 'Something New',
            'Identity_leaseParty[updatedAt]' => 'Something New',
            'Identity_leaseParty[identityDocumentType]' => 'Something New',
            'Identity_leaseParty[identityNumber]' => 'Something New',
            'Identity_leaseParty[expirationDate]' => 'Something New',
            'Identity_leaseParty[uploadIdentityPath]' => 'Something New',
            'Identity_leaseParty[leaseParty]' => 'Something New',
        ]);

        self::assertResponseRedirects('/identity/document/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getIdentityDocumentType());
        self::assertSame('Something New', $fixture[0]->getIdentityNumber());
        self::assertSame('Something New', $fixture[0]->getExpirationDate());
        self::assertSame('Something New', $fixture[0]->getUploadIdentityPath());
        self::assertSame('Something New', $fixture[0]->getLeaseParty());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new IdentityDocument();
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setIdentityDocumentType('Value');
        $fixture->setIdentityNumber('Value');
        $fixture->setExpirationDate('Value');
        $fixture->setUploadIdentityPath('Value');
        $fixture->setLeaseParty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/identity/document/');
        self::assertSame(0, $this->repository->count([]));
    }
}

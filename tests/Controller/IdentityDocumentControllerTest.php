<?php

namespace App\Test\Controller;

use App\Entity\IdentityDocument;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IdentityDocumentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/identity/document/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(IdentityDocument::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('IdentityDocument index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'identity_document[createdAt]' => 'Testing',
            'identity_document[updatedAt]' => 'Testing',
            'identity_document[identityDocumentType]' => 'Testing',
            'identity_document[identityNumber]' => 'Testing',
            'identity_document[expirationDate]' => 'Testing',
            'identity_document[uploadIdentityPath]' => 'Testing',
            'identity_document[leaseParty]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new IdentityDocument();
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setIdentityDocumentType('My Title');
        $fixture->setIdentityNumber('My Title');
        $fixture->setExpirationDate('My Title');
        $fixture->setUploadIdentityPath('My Title');
        $fixture->setLeaseParty('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('IdentityDocument');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
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

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'identity_document[createdAt]' => 'Something New',
            'identity_document[updatedAt]' => 'Something New',
            'identity_document[identityDocumentType]' => 'Something New',
            'identity_document[identityNumber]' => 'Something New',
            'identity_document[expirationDate]' => 'Something New',
            'identity_document[uploadIdentityPath]' => 'Something New',
            'identity_document[leaseParty]' => 'Something New',
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

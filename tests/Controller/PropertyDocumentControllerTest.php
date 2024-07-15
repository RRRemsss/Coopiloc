<?php

namespace App\Test\Controller;

use App\Entity\PropertyDocument;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PropertyDocumentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/property/document/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(PropertyDocument::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PropertyDocument index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'property_document[createdAt]' => 'Testing',
            'property_document[updatedAt]' => 'Testing',
            'property_document[documentType]' => 'Testing',
            'property_document[uploadPropertyDocumentPath]' => 'Testing',
            'property_document[property]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PropertyDocument();
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDocumentType('My Title');
        $fixture->setUploadPropertyDocumentPath('My Title');
        $fixture->setProperty('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PropertyDocument');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PropertyDocument();
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDocumentType('Value');
        $fixture->setUploadPropertyDocumentPath('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'property_document[createdAt]' => 'Something New',
            'property_document[updatedAt]' => 'Something New',
            'property_document[documentType]' => 'Something New',
            'property_document[uploadPropertyDocumentPath]' => 'Something New',
            'property_document[property]' => 'Something New',
        ]);

        self::assertResponseRedirects('/property/document/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDocumentType());
        self::assertSame('Something New', $fixture[0]->getUploadPropertyDocumentPath());
        self::assertSame('Something New', $fixture[0]->getProperty());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new PropertyDocument();
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDocumentType('Value');
        $fixture->setUploadPropertyDocumentPath('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/property/document/');
        self::assertSame(0, $this->repository->count([]));
    }
}

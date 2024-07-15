<?php

namespace App\Test\Controller;

use App\Entity\RentalDocument;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RentalDocumentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/rental/document/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(RentalDocument::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RentalDocument index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'rental_document[receiptDate]' => 'Testing',
            'rental_document[noticeRentDueDate]' => 'Testing',
            'rental_document[uploadRentalDocumentPath]' => 'Testing',
            'rental_document[rental]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new RentalDocument();
        $fixture->setReceiptDate('My Title');
        $fixture->setNoticeRentDueDate('My Title');
        $fixture->setUploadRentalDocumentPath('My Title');
        $fixture->setRental('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RentalDocument');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new RentalDocument();
        $fixture->setReceiptDate('Value');
        $fixture->setNoticeRentDueDate('Value');
        $fixture->setUploadRentalDocumentPath('Value');
        $fixture->setRental('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rental_document[receiptDate]' => 'Something New',
            'rental_document[noticeRentDueDate]' => 'Something New',
            'rental_document[uploadRentalDocumentPath]' => 'Something New',
            'rental_document[rental]' => 'Something New',
        ]);

        self::assertResponseRedirects('/rental/document/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getReceiptDate());
        self::assertSame('Something New', $fixture[0]->getNoticeRentDueDate());
        self::assertSame('Something New', $fixture[0]->getUploadRentalDocumentPath());
        self::assertSame('Something New', $fixture[0]->getRental());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new RentalDocument();
        $fixture->setReceiptDate('Value');
        $fixture->setNoticeRentDueDate('Value');
        $fixture->setUploadRentalDocumentPath('Value');
        $fixture->setRental('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/rental/document/');
        self::assertSame(0, $this->repository->count([]));
    }
}

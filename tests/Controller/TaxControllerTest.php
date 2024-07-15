<?php

namespace App\Test\Controller;

use App\Entity\Tax;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaxControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/tax/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Tax::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Tax index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'tax[taxSystem]' => 'Testing',
            'tax[taxNumber]' => 'Testing',
            'tax[taxName]' => 'Testing',
            'tax[taxAmount]' => 'Testing',
            'tax[propertyTax]' => 'Testing',
            'tax[property]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tax();
        $fixture->setTaxSystem('My Title');
        $fixture->setTaxNumber('My Title');
        $fixture->setTaxName('My Title');
        $fixture->setTaxAmount('My Title');
        $fixture->setPropertyTax('My Title');
        $fixture->setProperty('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Tax');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tax();
        $fixture->setTaxSystem('Value');
        $fixture->setTaxNumber('Value');
        $fixture->setTaxName('Value');
        $fixture->setTaxAmount('Value');
        $fixture->setPropertyTax('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'tax[taxSystem]' => 'Something New',
            'tax[taxNumber]' => 'Something New',
            'tax[taxName]' => 'Something New',
            'tax[taxAmount]' => 'Something New',
            'tax[propertyTax]' => 'Something New',
            'tax[property]' => 'Something New',
        ]);

        self::assertResponseRedirects('/tax/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTaxSystem());
        self::assertSame('Something New', $fixture[0]->getTaxNumber());
        self::assertSame('Something New', $fixture[0]->getTaxName());
        self::assertSame('Something New', $fixture[0]->getTaxAmount());
        self::assertSame('Something New', $fixture[0]->getPropertyTax());
        self::assertSame('Something New', $fixture[0]->getProperty());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tax();
        $fixture->setTaxSystem('Value');
        $fixture->setTaxNumber('Value');
        $fixture->setTaxName('Value');
        $fixture->setTaxAmount('Value');
        $fixture->setPropertyTax('Value');
        $fixture->setProperty('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/tax/');
        self::assertSame(0, $this->repository->count([]));
    }
}

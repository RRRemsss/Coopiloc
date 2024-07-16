<?php

namespace App\Test\Controller;

use App\Entity\PersonDetail;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonDetailControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/person/detail/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(PersonDetail::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PersonDetail index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'person_detail[lastname]' => 'Testing',
            'person_detail[firstname]' => 'Testing',
            'person_detail[phoneNumber]' => 'Testing',
            'person_detail[mail]' => 'Testing',
            'person_detail[leaseParty]' => 'Testing',
            'person_detail[user]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PersonDetail();
        $fixture->setLastname('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setPhoneNumber('My Title');
        $fixture->setMail('My Title');
        $fixture->setLeaseParty('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PersonDetail');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PersonDetail();
        $fixture->setLastname('Value');
        $fixture->setFirstname('Value');
        $fixture->setPhoneNumber('Value');
        $fixture->setMail('Value');
        $fixture->setLeaseParty('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'person_detail[lastname]' => 'Something New',
            'person_detail[firstname]' => 'Something New',
            'person_detail[phoneNumber]' => 'Something New',
            'person_detail[mail]' => 'Something New',
            'person_detail[leaseParty]' => 'Something New',
            'person_detail[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/person/detail/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getPhoneNumber());
        self::assertSame('Something New', $fixture[0]->getMail());
        self::assertSame('Something New', $fixture[0]->getLeaseParty());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new PersonDetail();
        $fixture->setLastname('Value');
        $fixture->setFirstname('Value');
        $fixture->setPhoneNumber('Value');
        $fixture->setMail('Value');
        $fixture->setLeaseParty('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/person/detail/');
        self::assertSame(0, $this->repository->count([]));
    }
}

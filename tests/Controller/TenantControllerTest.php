<?php

namespace App\Test\Controller;

use App\Entity\Tenant;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TenantControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/tenant/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Tenant::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Tenant index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'tenant[color]' => 'Testing',
            'tenant[civility]' => 'Testing',
            'tenant[dateOfBirth]' => 'Testing',
            'tenant[placeOfBirth]' => 'Testing',
            'tenant[nationality]' => 'Testing',
            'tenant[profession]' => 'Testing',
            'tenant[monthlyIncome]' => 'Testing',
            'tenant[hasGuarantor]' => 'Testing',
            'tenant[privateComment]' => 'Testing',
            'tenant[tenants]' => 'Testing',
            'tenant[identityDocument]' => 'Testing',
            'tenant[personDetail]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tenant();
        $fixture->setColor('My Title');
        $fixture->setCivility('My Title');
        $fixture->setDateOfBirth('My Title');
        $fixture->setPlaceOfBirth('My Title');
        $fixture->setNationality('My Title');
        $fixture->setProfession('My Title');
        $fixture->setMonthlyIncome('My Title');
        $fixture->setHasGuarantor('My Title');
        $fixture->setPrivateComment('My Title');
        $fixture->setTenants('My Title');
        $fixture->setIdentityDocument('My Title');
        $fixture->setPersonDetail('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Tenant');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tenant();
        $fixture->setColor('Value');
        $fixture->setCivility('Value');
        $fixture->setDateOfBirth('Value');
        $fixture->setPlaceOfBirth('Value');
        $fixture->setNationality('Value');
        $fixture->setProfession('Value');
        $fixture->setMonthlyIncome('Value');
        $fixture->setHasGuarantor('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setTenants('Value');
        $fixture->setIdentityDocument('Value');
        $fixture->setPersonDetail('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'tenant[color]' => 'Something New',
            'tenant[civility]' => 'Something New',
            'tenant[dateOfBirth]' => 'Something New',
            'tenant[placeOfBirth]' => 'Something New',
            'tenant[nationality]' => 'Something New',
            'tenant[profession]' => 'Something New',
            'tenant[monthlyIncome]' => 'Something New',
            'tenant[hasGuarantor]' => 'Something New',
            'tenant[privateComment]' => 'Something New',
            'tenant[tenants]' => 'Something New',
            'tenant[identityDocument]' => 'Something New',
            'tenant[personDetail]' => 'Something New',
        ]);

        self::assertResponseRedirects('/tenant/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getColor());
        self::assertSame('Something New', $fixture[0]->getCivility());
        self::assertSame('Something New', $fixture[0]->getDateOfBirth());
        self::assertSame('Something New', $fixture[0]->getPlaceOfBirth());
        self::assertSame('Something New', $fixture[0]->getNationality());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getMonthlyIncome());
        self::assertSame('Something New', $fixture[0]->getHasGuarantor());
        self::assertSame('Something New', $fixture[0]->getPrivateComment());
        self::assertSame('Something New', $fixture[0]->getTenants());
        self::assertSame('Something New', $fixture[0]->getIdentityDocument());
        self::assertSame('Something New', $fixture[0]->getPersonDetail());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tenant();
        $fixture->setColor('Value');
        $fixture->setCivility('Value');
        $fixture->setDateOfBirth('Value');
        $fixture->setPlaceOfBirth('Value');
        $fixture->setNationality('Value');
        $fixture->setProfession('Value');
        $fixture->setMonthlyIncome('Value');
        $fixture->setHasGuarantor('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setTenants('Value');
        $fixture->setIdentityDocument('Value');
        $fixture->setPersonDetail('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/tenant/');
        self::assertSame(0, $this->repository->count([]));
    }
}

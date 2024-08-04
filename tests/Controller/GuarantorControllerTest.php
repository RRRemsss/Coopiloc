<?php

namespace App\Test\Controller;

use App\Entity\Guarantor;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GuarantorControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/guarantor/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Guarantor::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Guarantor index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'guarantor[color]' => 'Testing',
            'guarantor[guarantorType]' => 'Testing',
            'guarantor[civility]' => 'Testing',
            'guarantor[dateOfBirth]' => 'Testing',
            'guarantor[placeOfBirth]' => 'Testing',
            'guarantor[nationality]' => 'Testing',
            'guarantor[profession]' => 'Testing',
            'guarantor[monthlyIncome]' => 'Testing',
            'guarantor[privateComment]' => 'Testing',
            'guarantor[guarantorCompanyName]' => 'Testing',
            'guarantor[tenant]' => 'Testing',
            'guarantor[address]' => 'Testing',
            'guarantor[personDetail]' => 'Testing',
            'guarantor[identityDocument]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Guarantor();
        $fixture->setColor('My Title');
        $fixture->setGuarantorType('My Title');
        $fixture->setCivility('My Title');
        $fixture->setDateOfBirth('My Title');
        $fixture->setPlaceOfBirth('My Title');
        $fixture->setNationality('My Title');
        $fixture->setProfession('My Title');
        $fixture->setMonthlyIncome('My Title');
        $fixture->setPrivateComment('My Title');
        $fixture->setGuarantorCompanyName('My Title');
        $fixture->setTenant('My Title');
        $fixture->setAddress('My Title');
        $fixture->setPersonDetail('My Title');
        $fixture->setIdentityDocument('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Guarantor');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Guarantor();
        $fixture->setColor('Value');
        $fixture->setGuarantorType('Value');
        $fixture->setCivility('Value');
        $fixture->setDateOfBirth('Value');
        $fixture->setPlaceOfBirth('Value');
        $fixture->setNationality('Value');
        $fixture->setProfession('Value');
        $fixture->setMonthlyIncome('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setGuarantorCompanyName('Value');
        $fixture->setTenant('Value');
        $fixture->setAddress('Value');
        $fixture->setPersonDetail('Value');
        $fixture->setIdentityDocument('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'guarantor[color]' => 'Something New',
            'guarantor[guarantorType]' => 'Something New',
            'guarantor[civility]' => 'Something New',
            'guarantor[dateOfBirth]' => 'Something New',
            'guarantor[placeOfBirth]' => 'Something New',
            'guarantor[nationality]' => 'Something New',
            'guarantor[profession]' => 'Something New',
            'guarantor[monthlyIncome]' => 'Something New',
            'guarantor[privateComment]' => 'Something New',
            'guarantor[guarantorCompanyName]' => 'Something New',
            'guarantor[tenant]' => 'Something New',
            'guarantor[address]' => 'Something New',
            'guarantor[personDetail]' => 'Something New',
            'guarantor[identityDocument]' => 'Something New',
        ]);

        self::assertResponseRedirects('/guarantor/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getColor());
        self::assertSame('Something New', $fixture[0]->getGuarantorType());
        self::assertSame('Something New', $fixture[0]->getCivility());
        self::assertSame('Something New', $fixture[0]->getDateOfBirth());
        self::assertSame('Something New', $fixture[0]->getPlaceOfBirth());
        self::assertSame('Something New', $fixture[0]->getNationality());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getMonthlyIncome());
        self::assertSame('Something New', $fixture[0]->getPrivateComment());
        self::assertSame('Something New', $fixture[0]->getGuarantorCompanyName());
        self::assertSame('Something New', $fixture[0]->getTenant());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getPersonDetail());
        self::assertSame('Something New', $fixture[0]->getIdentityDocument());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Guarantor();
        $fixture->setColor('Value');
        $fixture->setGuarantorType('Value');
        $fixture->setCivility('Value');
        $fixture->setDateOfBirth('Value');
        $fixture->setPlaceOfBirth('Value');
        $fixture->setNationality('Value');
        $fixture->setProfession('Value');
        $fixture->setMonthlyIncome('Value');
        $fixture->setPrivateComment('Value');
        $fixture->setGuarantorCompanyName('Value');
        $fixture->setTenant('Value');
        $fixture->setAddress('Value');
        $fixture->setPersonDetail('Value');
        $fixture->setIdentityDocument('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/guarantor/');
        self::assertSame(0, $this->repository->count([]));
    }
}

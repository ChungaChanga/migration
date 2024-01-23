<?php

namespace App\Test\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CustomerRepository $repository;
    private string $path = '/customer/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Customer::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Customer index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'customer[sourceId]' => 'Testing',
            'customer[transferStatus]' => 'Testing',
            'customer[destId]' => 'Testing',
            'customer[transferData]' => 'Testing',
        ]);

        self::assertResponseRedirects('/customer/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Customer();
        $fixture->setSourceId('My Title');
        $fixture->setTransferStatus('My Title');
        $fixture->setDestId('My Title');
        $fixture->setTransferData('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Customers');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Customer();
        $fixture->setSourceId('My Title');
        $fixture->setTransferStatus('My Title');
        $fixture->setDestId('My Title');
        $fixture->setTransferData('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'customer[sourceId]' => 'Something New',
            'customer[transferStatus]' => 'Something New',
            'customer[destId]' => 'Something New',
            'customer[transferData]' => 'Something New',
        ]);

        self::assertResponseRedirects('/customer/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSourceId());
        self::assertSame('Something New', $fixture[0]->getTransferStatus());
        self::assertSame('Something New', $fixture[0]->getDestId());
        self::assertSame('Something New', $fixture[0]->getTransferData());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Customer();
        $fixture->setSourceId('My Title');
        $fixture->setTransferStatus('My Title');
        $fixture->setDestId('My Title');
        $fixture->setTransferData('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/customer/');
    }
}

<?php

namespace App\Test\Controller;

use App\Entity\Lecon;
use App\Repository\LeconRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeconControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LeconRepository $repository;
    private string $path = '/lecon/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Lecon::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lecon index');

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
            'lecon[date]' => 'Testing',
            'lecon[heure]' => 'Testing',
            'lecon[reglee]' => 'Testing',
            'lecon[iduser]' => 'Testing',
            'lecon[ideleve]' => 'Testing',
            'lecon[immatriculation]' => 'Testing',
        ]);

        self::assertResponseRedirects('/lecon/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lecon();
        $fixture->setDate('My Title');
        $fixture->setHeure('My Title');
        $fixture->setReglee('My Title');
        $fixture->setiduser('My Title');
        $fixture->setIdeleve('My Title');
        $fixture->setImmatriculation('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lecon');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lecon();
        $fixture->setDate('My Title');
        $fixture->setHeure('My Title');
        $fixture->setReglee('My Title');
        $fixture->setiduser('My Title');
        $fixture->setIdeleve('My Title');
        $fixture->setImmatriculation('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lecon[date]' => 'Something New',
            'lecon[heure]' => 'Something New',
            'lecon[reglee]' => 'Something New',
            'lecon[iduser]' => 'Something New',
            'lecon[ideleve]' => 'Something New',
            'lecon[immatriculation]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lecon/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getHeure());
        self::assertSame('Something New', $fixture[0]->getReglee());
        self::assertSame('Something New', $fixture[0]->getiduser());
        self::assertSame('Something New', $fixture[0]->getIdeleve());
        self::assertSame('Something New', $fixture[0]->getImmatriculation());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Lecon();
        $fixture->setDate('My Title');
        $fixture->setHeure('My Title');
        $fixture->setReglee('My Title');
        $fixture->setiduser('My Title');
        $fixture->setIdeleve('My Title');
        $fixture->setImmatriculation('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/lecon/');
    }
}

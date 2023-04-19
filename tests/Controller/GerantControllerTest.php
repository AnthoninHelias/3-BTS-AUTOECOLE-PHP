<?php

namespace App\Test\Controller;

use App\Entity\Gerant;
use App\Repository\GerantRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GerantControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private GerantRepository $repository;
    private string $path = '/gerant/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Gerant::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gerant index');

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
            'gerant[nomutilisateur]' => 'Testing',
            'gerant[motdepasse]' => 'Testing',
            'gerant[nom]' => 'Testing',
            'gerant[prenom]' => 'Testing',
            'gerant[sexe]' => 'Testing',
            'gerant[datedenaissance]' => 'Testing',
            'gerant[adresse]' => 'Testing',
            'gerant[codepostal]' => 'Testing',
            'gerant[ville]' => 'Testing',
            'gerant[telephone]' => 'Testing',
        ]);

        self::assertResponseRedirects('/gerant/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gerant();
        $fixture->setNomutilisateur('My Title');
        $fixture->setMotdepasse('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setDatedenaissance('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setTelephone('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gerant');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gerant();
        $fixture->setNomutilisateur('My Title');
        $fixture->setMotdepasse('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setDatedenaissance('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setTelephone('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'gerant[nomutilisateur]' => 'Something New',
            'gerant[motdepasse]' => 'Something New',
            'gerant[nom]' => 'Something New',
            'gerant[prenom]' => 'Something New',
            'gerant[sexe]' => 'Something New',
            'gerant[datedenaissance]' => 'Something New',
            'gerant[adresse]' => 'Something New',
            'gerant[codepostal]' => 'Something New',
            'gerant[ville]' => 'Something New',
            'gerant[telephone]' => 'Something New',
        ]);

        self::assertResponseRedirects('/gerant/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomutilisateur());
        self::assertSame('Something New', $fixture[0]->getMotdepasse());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getDatedenaissance());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCodepostal());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getTelephone());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Gerant();
        $fixture->setNomutilisateur('My Title');
        $fixture->setMotdepasse('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setDatedenaissance('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setTelephone('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/gerant/');
    }
}

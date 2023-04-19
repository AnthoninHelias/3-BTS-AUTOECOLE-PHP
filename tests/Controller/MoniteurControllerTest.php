<?php

namespace App\Test\Controller;

use App\Entity\Moniteur;
use App\Repository\MoniteurRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoniteurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MoniteurRepository $repository;
    private string $path = '/moniteur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Moniteur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Moniteur index');

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
            'moniteur[nomutilisateur]' => 'Testing',
            'moniteur[motdepasse]' => 'Testing',
            'moniteur[nom]' => 'Testing',
            'moniteur[prenom]' => 'Testing',
            'moniteur[sexe]' => 'Testing',
            'moniteur[datedenaissance]' => 'Testing',
            'moniteur[adresse]' => 'Testing',
            'moniteur[codepostal]' => 'Testing',
            'moniteur[ville]' => 'Testing',
            'moniteur[telephone]' => 'Testing',
        ]);

        self::assertResponseRedirects('/moniteur/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Moniteur();
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
        self::assertPageTitleContains('Moniteur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Moniteur();
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
            'moniteur[nomutilisateur]' => 'Something New',
            'moniteur[motdepasse]' => 'Something New',
            'moniteur[nom]' => 'Something New',
            'moniteur[prenom]' => 'Something New',
            'moniteur[sexe]' => 'Something New',
            'moniteur[datedenaissance]' => 'Something New',
            'moniteur[adresse]' => 'Something New',
            'moniteur[codepostal]' => 'Something New',
            'moniteur[ville]' => 'Something New',
            'moniteur[telephone]' => 'Something New',
        ]);

        self::assertResponseRedirects('/moniteur/');

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

        $fixture = new Moniteur();
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
        self::assertResponseRedirects('/moniteur/');
    }
}

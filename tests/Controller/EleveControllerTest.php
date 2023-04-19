<?php

namespace App\Test\Controller;

use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EleveControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EleveRepository $repository;
    private string $path = '/eleve/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Eleve::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Eleve index');

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
            'eleve[nom]' => 'Testing',
            'eleve[prenom]' => 'Testing',
            'eleve[sexe]' => 'Testing',
            'eleve[datedenaissance]' => 'Testing',
            'eleve[adresse]' => 'Testing',
            'eleve[codepostal]' => 'Testing',
            'eleve[ville]' => 'Testing',
            'eleve[telephone]' => 'Testing',
            'eleve[nomutilisateur]' => 'Testing',
            'eleve[motdepasse]' => 'Testing',
        ]);

        self::assertResponseRedirects('/eleve/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleve();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setDatedenaissance('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setNomutilisateur('My Title');
        $fixture->setMotdepasse('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Eleve');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleve();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setDatedenaissance('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setNomutilisateur('My Title');
        $fixture->setMotdepasse('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'eleve[nom]' => 'Something New',
            'eleve[prenom]' => 'Something New',
            'eleve[sexe]' => 'Something New',
            'eleve[datedenaissance]' => 'Something New',
            'eleve[adresse]' => 'Something New',
            'eleve[codepostal]' => 'Something New',
            'eleve[ville]' => 'Something New',
            'eleve[telephone]' => 'Something New',
            'eleve[nomutilisateur]' => 'Something New',
            'eleve[motdepasse]' => 'Something New',
        ]);

        self::assertResponseRedirects('/eleve/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getDatedenaissance());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCodepostal());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getNomutilisateur());
        self::assertSame('Something New', $fixture[0]->getMotdepasse());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Eleve();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setDatedenaissance('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setNomutilisateur('My Title');
        $fixture->setMotdepasse('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/eleve/');
    }
}

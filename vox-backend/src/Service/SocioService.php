<?php 

namespace App\Service;

use App\Entity\Socio;
use App\Repository\SocioRepository;
use Doctrine\ORM\EntityManagerInterface;

class SocioService
{
    private $entityManager;
    private $socioRepository;

    public function __construct(EntityManagerInterface $entityManager, SocioRepository $socioRepository)
    {
        $this->entityManager = $entityManager;
        $this->socioRepository = $socioRepository;
    }

    public function cadastrarSocio(Socio $socio): Socio
    {
        $this->entityManager->persist($socio);
        $this->entityManager->flush();

        return $socio;
    }

    public function listarSocios(): array
    {
        $socios = $this->socioRepository->findAll();
        return $socios;
    }

    public function buscarSocioPorId(int $id):?Socio
    {
        $socio = $this->socioRepository->find($id);
        return $socio;
    }
    public function atualizarSocio(Socio $socio): Socio
    {
        $this->entityManager->persist($socio);
        $this->entityManager->flush();
        
        return $socio;
    }

    public function deletarSocio($id): void
    {
        $this->entityManager->remove($id);
    }
}

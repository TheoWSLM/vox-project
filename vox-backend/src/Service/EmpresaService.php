<?php 

namespace App\Service;

use App\Entity\Empresa;
use App\Repository\EmpresaRepository;
use Doctrine\ORM\EntityManagerInterface;

class EmpresaService
{
    private $entityManager;
    private $empresaRepository;

    public function __construct(EntityManagerInterface $entityManager, EmpresaRepository $empresaRepository)
    {
        $this->entityManager = $entityManager;
        $this->empresaRepository = $empresaRepository;
    }

    public function cadastrarEmpresa(Empresa $empresa): Empresa
    {
        $this->entityManager->persist($empresa);
        $this->entityManager->flush();

        return $empresa;
    }

    public function listarEmpresas(): array
    {
        $empresas = $this->empresaRepository->findAll();
        return $empresas;
    }

    public function buscarEmpresaPorId(int $id):?Empresa
    {
        $empresa = $this->empresaRepository->find($id);
        return $empresa;
    }
    public function atualizarEmpresa(Empresa $empresa): Empresa
    {
        $this->entityManager->persist($empresa);
        $this->entityManager->flush();
        
        return $empresa;
    }

    public function deletarEmpresa(Empresa $empresa): void
    {
        $this->entityManager->remove($empresa);
        $this->entityManager->flush();
    }
}

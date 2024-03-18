<?php

namespace App\Repository;

use App\Entity\Empresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Socio;

class SocioEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Socio::class);
    }

    public function addSocioEmpresa(Socio $socio, Empresa $empresa)
    {
        $socio->addEmpresa($empresa);
        $this->_em->persist($socio);
        $this->_em->flush();
    }

}
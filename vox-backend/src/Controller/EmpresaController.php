<?php
namespace App\Controller;

use App\Entity\Empresa;
use App\Service\EmpresaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/empresas", name="empresa_api")
 */
class EmpresaController extends AbstractController
{
    private $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    /**
     * @Route("/cadastrar", methods={"POST"})
     */
    public function cadastrar(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $empresa = new Empresa();
        $empresa->setCnpj($data['cnpj']);
        $empresa->setNomeFantasia($data['nomeFantasia']);
        $empresa->setNomeFormal($data['nomeFormal']);


        $empresaCadastrado = $this->empresaService->cadastrarEmpresa($empresa);

        return $this->json(['empresa' => $empresaCadastrado]);
    }

     /**
     * @Route("/listar", methods={"GET"})
     */
    public function listar(): JsonResponse
    {
        $empresas = $this->empresaService->listarEmpresas();
        return $this->json(['empresas' => $empresas]);
    }
    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function buscarPorId($id): JsonResponse
    {
        $empresa = $this->empresaService->buscarEmpresaPorId($id);
        return $this->json(['empresa' => $empresa]);
    }
    /**
     * @Route("/editar/{id}", methods={"PUT"})
     */
    public function atualizar($id, Request $request, EmpresaService $empresaService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $empresa = $empresaService->buscarEmpresaPorId($id); 
    
        if (!$empresa) {
            return $this->json(['error' => 'Sócio não encontrado'], 404);
        }
    
        $empresa->setCnpj($data['cnpj'] ?? $empresa->getCnpj()); 
        $empresa->setNomeFantasia($data['nomeFantasia'] ?? $empresa->getNomeFantasia());
        $empresa->setNomeFormal($data['nomeFormal'] ?? $empresa->getNomeFormal()); 
    
        $empresaService->atualizarEmpresa($empresa); 
    
        return $this->json(['empresa' => $empresa]);
    }

   /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(int $id, EmpresaService $empresaService): JsonResponse
    {
        $empresa = $empresaService->buscarEmpresaPorId($id);

        if (!$empresa) {
            return $this->json(['error' => 'Empresa não encontrada'], 404);
        }

        $empresaService->deletarEmpresa($empresa);

        return $this->json(['message' => 'Empresa excluída com sucesso']);
    }

}

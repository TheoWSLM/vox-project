<?php
namespace App\Controller;

use App\Entity\Socio;
use App\Service\SocioService;
use App\Service\EmpresaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/api/socios", name="socio_api")
 */
class SocioController extends AbstractController
{
    private $socioService;
    private $empresaService;

    public function __construct(SocioService $socioService, EmpresaService $empresaService)
    {
        $this->socioService = $socioService;
        $this->empresaService = $empresaService;
    }

    /**
     * @Route("/cadastrar", methods={"POST"})
     */
    public function cadastrar(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $socio = new Socio();
        $socio->setNome($data['nome']);
        $socio->setEmail($data['email']);
        $socio->setPassWord($data['passWord']);


        $socioCadastrado = $this->socioService->cadastrarSocio($socio);

        return $this->json(['socio' => $socioCadastrado]);
    }

     /**
     * @Route("/listar", methods={"GET"})
     */
    public function listar(): JsonResponse
    {
        $socios = $this->socioService->listarSocios();
        return $this->json(['socios' => $socios]);
    }
    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function buscarPorId($id): JsonResponse
    {
        $socio = $this->socioService->buscarSocioPorId($id);
        return $this->json(['socio' => $socio]);
    }
    /**
     * @Route("/editar/{id}", methods={"PUT"})
     */
    public function atualizar($id, Request $request, SocioService $socioService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $socio = $socioService->buscarSocioPorId($id); 
    
        if (!$socio) {
            return $this->json(['error' => 'Sócio não encontrado'], 404);
        }
    
        $socio->setNome($data['nome'] ?? $socio->getNome()); 
        $socio->setEmail($data['email'] ?? $socio->getEmail());
        $socio->setPassWord($data['passWord'] ?? $socio->getPassWord()); 
    
        $socioService->atualizarSocio($socio);
    
        return $this->json(['socio' => $socio]);
    }

   /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(int $id, SocioService $socioService): JsonResponse
    {
        $socio = $socioService->buscarSocioPorId($id);

        if (!$socio) {
            return $this->json(['error' => 'Sócio não encontrado'], 404);
        }

        $socioService->deletarSocio($socio);

        return $this->json(['message' => 'Sócio excluído com sucesso']);
    }
/**
 * @Route("/empresa/{socioId}/{empresaId}", methods={"POST"})
 */
public function adicionarEmpresa(int $socioId, int $empresaId, SocioService $socioService, EmpresaService $empresaService): JsonResponse
{
    $socio = $socioService->buscarSocioPorId($socioId);
    $empresa = $empresaService->buscarEmpresaPorId($empresaId);

    if (!$socio) {
        return $this->json(['error' => 'Sócio não encontrado'], 404);
    }

    if (!$empresa) {
        return $this->json(['error' => 'Empresa não encontrada'], 404);
    }

    $socio->addEmpresa($empresa);

    $socioService->atualizarSocio($socio);
    
    return $this->json(['socio' => $socio]);
}
}
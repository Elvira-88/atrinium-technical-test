<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/companies", name="api_companies_")
 */

class ApiCompaniesController extends AbstractController
{
    /**
     * @Route(
     *      "", 
     *      name="cget",
     *      methods={"GET"}
     * )
     */
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->json($companyRepository->findAll());
    }

    /**
     * @Route(
     *      "", 
     *      name="post",
     *      methods={"POST"}
     * )
     */
    public function add(): Response
    {
        return $this->json([
            'method' => 'POST',
            'description' => 'Crea un recurso empresa.',
        ]);
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="put",
     *      methods={"PUT"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function update(int $id): Response
    {
        return $this->json([
            'method' => 'PUT',
            'description' => 'Modifica un recurso empresa.',
        ]);
    }

      /**
     * @Route(
     *      "/{id}",
     *      name="delete",
     *      methods={"DELETE"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function remove(int $id): Response
    {
        return $this->json([
            'method' => 'DELETE',
            'description' => 'Elimina un recurso empresa.',
        ]);
    }
}

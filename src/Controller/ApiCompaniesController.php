<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Repository\SectorRepository;
use App\Service\CompanyNormalize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function index(Request $request, CompanyRepository $companyRepository, CompanyNormalize $companyNormalize): Response
    {
        if ($request->query->has('term')) {
            $result = $companyRepository->findByTerm($request->query->get('term'));

            $data = [];

            foreach($result as $company) {
                $data[] = $companyNormalize->companyNormalize($company);   
            }

            return $this->json($data);
        }

        $result = $companyRepository->findAll();

        $data = [];

        foreach($result as $company) {
            $data[] = $companyNormalize->companyNormalize($company);   
        }

        return $this->json($data);

    }

    /**
     * @Route(
     *      "/{id}",
     *      name="get",
     *      methods={"GET"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function show(
        int $id, 
        CompanyRepository $companyRepository,
        CompanyNormalize $companyNormalize
        ): Response
    
    {
        $data = $companyRepository->find($id);

        return $this->json($companyNormalize->companyNormalize($data));
    }

    /**
     * @Route(
     *      "", 
     *      name="post",
     *      methods={"POST"}
     * )
     */
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        SectorRepository $sectorRepository,
        CompanyNormalize $companyNormalize
    ): Response {

        $data = $request->request;

        $sector = $sectorRepository->find($data->get('sector_id'));

        $company = new Company();

        $company->setName($data->get('name'));
        $company->setEmail($data->get('email'));
        $company->setPhone($data->get('phone'));
        $company->setSector($sector);

        $errors = $validator->validate($company);

        if (count($errors) > 0) {
            $dataErrors = [];

            foreach ($errors as $error) {
                $dataErrors[] = $error->getMessage();
            }

            return $this->json([
                'status' => 'error',
                'data' => [
                    'errors' => $dataErrors
                    ]
                ],
                Response::HTTP_BAD_REQUEST);            
        }

        $entityManager->persist($company);

        $entityManager->flush();

        return $this->json(
            $companyNormalize->companyNormalize($company),
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_companies_get',
                    [
                        'id' => $company->getId()
                    ]
                )
            ]
        );
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
    public function update(
        Company $company,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $data=$request->request;
        $company->setName($data->get('name'));
        $company->setEmail($data->get('email'));
        $company->setPhone($data->get('phone'));

        $entityManager->persist($company);
        $entityManager->flush();

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
    public function remove(
        Company $company,
        EntityManagerInterface $entityManager
        ): Response
    {
        //remove() prepara el sistema pero NO ejecuta la acción
        $entityManager->remove($company);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}

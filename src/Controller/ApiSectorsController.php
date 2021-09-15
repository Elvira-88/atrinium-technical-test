<?php

namespace App\Controller;

use App\Repository\SectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSectorsController extends AbstractController
{
    /**
     * @Route("/api/sectors", name="api_sectors")
     */
    public function index(Request $request, SectorRepository $sectorRepository): Response
    {
        if ($request->query->has('term')) {
            $sectors = $sectorRepository->findByTerm($request->query->get('term'));

            return $this->render('api_sectors/index.html.twig', [
                'sectors' => 'ApiSectorsController',
            ]);
        }

        $sectors = $sectorRepository->findAll();

        return $this->render('api_sectors/index.html.twig', [
            'sectors' => $sectors
        ]);
    }
}




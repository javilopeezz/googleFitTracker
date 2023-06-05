<?php

namespace App\Controller\Api;

use App\Entity\Datos;
use App\Repository\DatosRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api', name: 'api_')]
class apiController extends AbstractController
{
    #[Route(path: '/datos', name: 'GetAllDatos', methods: ['GET'])]
    public function getAllDatos(DatosRepository $datosRepository): JsonResponse
    {
        $datos = $datosRepository->findAll();
        $data = [];

        if (!empty($datos)) {
            foreach ($datos as $dato) {
                $data[] = [
                    'id' => $dato->getId(),
                    'emailUsuario' => $dato->getEmailUsuario(),
                    'pasos' => $dato->getPasos(),
                    'distancia' => $dato->getDistancia(),
                    'peso' => $dato->getPeso(),
                    'caloriasQuemadas' => $dato->getCaloriasQuemadas(),
                    'fecha' => $dato->getFecha(),
                ];
            }

            return new JsonResponse([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            return new JsonResponse([
                'success' => true,
                'data' => 'No hay datos para mostrar',
            ]);
        }
    }

    #[Route(path: '/datos/comprueba-existe', name: 'CompruebaExiste', methods: ['POST'])]
    public function compruebaExiste(Request $request, DatosRepository $datosRepository): JsonResponse
    {
        $datos = new Datos();

        $datos->setEmailUsuario($request->request->get('emailUsuario'));
        $datos->setPasos($request->request->get('pasos'));
        $datos->setPeso($request->request->get('peso'));
        $datos->setDistancia($request->request->get('distancia'));
        $datos->setCaloriasQuemadas($request->request->get('caloriasQuemadas'));
        $datos->setFecha(date_create($request->request->get('fecha')));

        $datosComprobado = $datosRepository->findLastEmailFecha($datos);
        if ($datosComprobado == null) {
            return new JsonResponse([
                'success' => true,
                'data' => false,
            ]);
        }else{
            return new JsonResponse([
                'success' => true,
                'data' => true,
            ]);
        }
        
    }

    #[Route(path: '/datos', name: 'UpdateDatos', methods: ['PUT'])]
    public function updateDatos(Request $request, ManagerRegistry $doctrine, DatosRepository $datosRepository): JsonResponse
    {
        $datos = new Datos();

        $datos->setEmailUsuario($request->request->get('emailUsuario'));
        $datos->setPasos($request->request->get('pasos'));
        $datos->setPeso($request->request->get('peso'));
        $datos->setDistancia($request->request->get('distancia'));
        $datos->setCaloriasQuemadas($request->request->get('caloriasQuemadas'));
        $datos->setFecha(date_create($request->request->get('fecha')));

        $datosActualizar = $datosRepository->findLastEmailFecha($datos);

        $datosActualizar->setPasos($datos->getPasos());
        $datosActualizar->setPeso($datos->getPeso());
        $datosActualizar->setDistancia($datos->getDistancia());
        $datosActualizar->setCaloriasQuemadas($datos->getCaloriasQuemadas());

        $entityManager = $doctrine->getManager();
        $entityManager->persist($datosActualizar);
        $entityManager->flush();

        $response = new JsonResponse();

        $response->setContent(json_encode(array(
            'success' => true,
            'mensaje' => 'Datos actualizados correctamente.'
        )));

        $response->setStatusCode('202');
        return $response;
    }

    #[Route(path: '/datos', name: 'InsertDatos', methods: ['POST'])]
    public function insertDatos(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $datos = new Datos();

        $datos->setEmailUsuario($request->request->get('emailUsuario'));
        $datos->setPasos($request->request->get('pasos'));
        $datos->setPeso($request->request->get('peso'));
        $datos->setDistancia($request->request->get('distancia'));
        $datos->setCaloriasQuemadas($request->request->get('caloriasQuemadas'));
        $datos->setFecha(date_create($request->request->get('fecha')));

        $entityManager = $doctrine->getManager();
        $entityManager->persist($datos);
        $entityManager->flush();

        $response = new JsonResponse();

        $response->setContent(json_encode(array(
            'success' => true,
            'mensaje' => 'Datos insertados correctamente.'
        )));

        $response->setStatusCode('202');
        return $response;
    }
}

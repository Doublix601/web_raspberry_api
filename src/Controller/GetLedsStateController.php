<?php


namespace App\Controller;

use App\Repository\DevicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GetLedsStateController extends AbstractController
{
    /**
     * @Route("/device/{name}", name="get_device_by_id", methods={"GET"})
     */
    public function GetDeviceById(DevicesRepository $devicesRepository, $name)
    {
        return $this->json($devicesRepository->findOneBy(array('name' => $name)),200,[]);
    }
}

<?php


namespace App\Controller;

use App\Entity\Devices;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\DevicesRepository;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register_device", methods={"POST"})
     */
    public function register(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, DevicesRepository $devicesRepository, ManagerRegistry $doctrine){
        $jsonRecu = $request->getContent();

        try{
            $devices = $serializer->deserialize($jsonRecu, Devices::class, 'json');
            $errors = $validator->validate($devices);

            if(count($errors) > 0){
                return $this->json($errors, 400);
            }

            $devicesArray = array($devices);
            $name = $devicesArray[0]->name;
            $ip = $devicesArray[0]->ip;

            $ExistDevice = $this->json($devicesRepository->findBy(array('name' => $name)));

            if ($ExistDevice->data == '[]'){
                $devices->setName(strtoupper($devices->name));
                $valueName = substr($devices->name,2,1);
                $valueName = decbin($valueName);

                switch ($valueName){
                    case '01':
                        $devices->setLed1(0);
                        $devices->setLed2(0);
                        $devices->setLed3(0);
                        $devices->setLed4(1);
                        break;
                    case '10':
                        $devices->setLed1(0);
                        $devices->setLed2(0);
                        $devices->setLed3(1);
                        $devices->setLed4(0);
                        break;
                    case '11':
                        $devices->setLed1(0);
                        $devices->setLed2(0);
                        $devices->setLed3(1);
                        $devices->setLed4(1);
                        break;
                    case '100':
                        $devices->setLed1(0);
                        $devices->setLed2(1);
                        $devices->setLed3(0);
                        $devices->setLed4(0);
                        break;
                    case '101':
                        $devices->setLed1(0);
                        $devices->setLed2(1);
                        $devices->setLed3(0);
                        $devices->setLed4(1);
                        break;
                    case '110':
                        $devices->setLed1(0);
                        $devices->setLed2(1);
                        $devices->setLed3(1);
                        $devices->setLed4(0);
                        break;
                    case '111':
                        $devices->setLed1(0);
                        $devices->setLed2(1);
                        $devices->setLed3(1);
                        $devices->setLed4(1);
                        break;
                    case '1000':
                        $devices->setLed1(1);
                        $devices->setLed2(0);
                        $devices->setLed3(0);
                        $devices->setLed4(0);
                        break;
                    case '1001':
                        $devices->setLed1(1);
                        $devices->setLed2(0);
                        $devices->setLed3(0);
                        $devices->setLed4(1);
                        break;
                }

                $em->persist($devices);
                $em->flush();

                return $this->json($devices, 201, []);
            }
            else{
                $entityManager = $doctrine->getManager();
                $product = $entityManager->getRepository(Devices::class)->findBy(array('name' => $name));

                if (!$product) {
                    throw $this->createNotFoundException(
                        'Pas de produit trouvé pour name = '.$name
                    );
                }

                $product[0]->setIp($ip);
                //$em->persist($devices);
                $em->flush();
            }

            return $this->json($devices, 201, []);

        }catch (NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

    }
}

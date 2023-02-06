<?php


namespace App\Service;


use App\Entity\Status;

class StatusManagerService
{

    public function calculStatusEdit($statusDemande,  $entityManager){

        $status = [];
        switch ($statusDemande){
            case 1:
                $status = [
                    "In progress" => $entityManager->getRepository(Status::class)->findOneBy(['id'=>2]),
                    "Closed" => $entityManager->getRepository(Status::class)->findOneBy(['id'=>3])
                ];
                break;

            case 2:
                $status = [
                    "Closed" => $entityManager->getRepository(Status::class)->findOneBy(['id'=>3])
                ];
                break;

            case 3:
                $status = [
                    "Closed" => $entityManager->getRepository(Status::class)->findOneBy(['id'=>3])
                ];
                break;

        }
        return $status;
    }
}
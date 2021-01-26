<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;

class ClientService
{
    /**
     * ClientService constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(
        private ClientRepository $clientRepository
    ) {}

    /**
     * @return Client[]
     */
    public function getAll(): array
    {
        return $this->clientRepository->findAll();
    }
}

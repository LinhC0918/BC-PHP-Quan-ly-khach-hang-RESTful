<?php

namespace App\Http\Services\Impl;

use App\Http\Repositories\CustomerRepository;
use App\Http\Services\CustomerService;

class CustomerServiceImpl implements CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll()
    {
        $customers = $this->customerRepository->getAll();
        return $customers;
    }

    public function findById($id)
    {
        $customers = $this->customerRepository->findById($id);
        $statusCode = 200;
        if (!$customers) {
            $statusCode = 404;
        }
        $data = [
            'statusCode' => $statusCode,
            'customers' => $customers
        ];

        return $data;
    }

    public function create($request)
    {
        $customers = $this->customerRepository->create($request);
        $statusCode = 201;
        if (!$customers) {
            $statusCode = 500;
        }
        $data = [
            'statusCode' => $statusCode,
            'customer' => $customers
        ];
        return $data;
    }

    public function update($request, $id)
    {
        $oldCustomer = $this->customerRepository->findById($id);
        if (!$oldCustomer) {
            $newCustomer = null;
            $statusCode = 404;
        } else {
            $newCustomer = $this->customerRepository->update($request, $oldCustomer);
            $statusCode = 200;
        }
        $data = [
            'statusCode' => $statusCode,
            'customers' => $newCustomer
        ];
        return $data;
    }

    public function destroy($id)
    {
        $customers = $this->customerRepository->findById($id);
        $statusCode = 404;
        $message = 'User not found';

        if ($customers) {
            $this->customerRepository->destroy($customers);
            $statusCode = 200;
            $message = 'Delete Success!';
        }

        $data = [
            'statusCode' => $statusCode,
            'message' => $message
        ];

        return $data;
    }
}
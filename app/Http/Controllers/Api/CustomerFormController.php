<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CustomerFormInterface;
use App\Http\Requests\Customer\ContactUsRequest;
use App\Http\Requests\Customer\HarmfulComplaintRequest;

class CustomerFormController extends Controller
{
    private $customer_form_repo;

    public function __construct(CustomerFormInterface $customer_form_repo)
    {
        $this->customer_form_repo = $customer_form_repo;
    }

    /**
     * Store Customer Contact Us Information
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeContactUs(ContactUsRequest $request)
    {   
        return $this->customer_form_repo->storeContactUs($request);
    }

    /**
     * Store Customer Harmful Digital Communication Complaint
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeHarmfulComplaint(HarmfulComplaintRequest $request)
    {   
        return $this->customer_form_repo->storeHarmfulComplaint($request);
    }
}

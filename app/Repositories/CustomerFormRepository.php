<?php

namespace App\Repositories;

use Mail;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CustomerFormInterface;
use App\Models\CustomerForm;

/**
 * Class CustomerFormRepository.
 *
 * @package namespace App\Repositories;
 */
class CustomerFormRepository extends BaseRepository implements CustomerFormInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CustomerForm::class;
    }

    /**
     * Store Customer Contact Us Information
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeContactUs($request)
    {
        $validated = (object) $request->validated();
        $customer_form = new CustomerForm;
        $form_fields = [
            'first_name',
            'last_name',
            'email_address',
            'subject',
            'business_name',
            'message'
        ];

        foreach ($form_fields as $field) {
            if (property_exists($validated, $field)) $customer_form->$field = $validated->$field;
        }

        $customer_form->extra_data = '[]';
        $customer_form->form_type = CustomerForm::CONTACT_US;
        $customer_form->recorded_date = date('Y-m-d H:i:s');

        if (!$customer_form->save()) {
            return $this->response(false, 'Cannot save Customer Information', 400);
        }

        $subject = 'PreviewMe - Thank you for getting in touch';
        $to = $validated->email_address;
        Mail::send('email.contact-us', ['first_name' => $validated->first_name], 
            function ($message) use ($subject, $to) {
                $message->subject($subject);
                $message->from(getenv('MANDRILL_ADDRESS', 'PreviewMe'));
                $message->to($to);
            });

        return $this->response(true, 'Customer Information was successfully saved!', 200);
    }

    /**
     * Store Customer Harmful Digital Communication Complaint
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeHarmfulComplaint($request)
    {
        $validated = (object) $request->validated();
        $customer_form = new CustomerForm;
        $form_fields = [
            'first_name',
            'last_name',
            'email_address'
        ];

        foreach ($form_fields as $field) {
            if (property_exists($validated, $field)) $customer_form->$field = $validated->$field;
        }
        
        $extra_data = $this->processExtraData($validated);
        $customer_form->extra_data = (count($extra_data) > 0) ? json_encode($extra_data) : '[]';
        
        $customer_form->form_type = CustomerForm::HARMFUL_COMPLAINT;
        $customer_form->recorded_date = date('Y-m-d H:i:s');

        if (!$customer_form->save()) {
            return $this->response(false, 'Cannot save Customer Harmful Complaint', 400);
        }

        return $this->response(true, 'Customer Harmful Complaint was successfully saved!', 200);
    }

    /**
     * Process Customer Extra Data
     *
     * @param [object] $validated
     * @return Array
     */
    private function processExtraData($validated)
    {
        $extra_data = [];
        $form_fields = [
            'phone_number',
            'address',
            'breach_details',
            'communication_type',
            'link_to_abusive_content',
            'user_consent'
        ];

        foreach ($form_fields as $field) {
            if ($validated->$field) {
                array_push($extra_data, [$field => $validated->$field]);
            }
        }

        return $extra_data;
    }

    /**
     * Return Formatted JSON Response
     *
     * @param [Boolean] $success
     * @param [String] $message
     * @param [Integer] $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($success, $message, $status)
    {
        return response()->json(['success' => $success, 'message' => $message], $status);
    }

}

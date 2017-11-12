<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Request extends FormRequest
{
    
    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {           
        return $validator->errors()->toArray() ;  
    } 
    
    protected function failedValidation(Validator $validator)
    {
        //throw new ResourceException('Invalid Inputs', $validator->getMessageBag());
        throw new HttpResponseException(response()->json($validator->errors(), 422));
        //422 Unprocessable Entity (WebDAV; RFC 4918)
        // The request was well-formed but was unable to be followed due to semantic errors.[16]
    }
    
    /**
    * vuejs - vue routes need the responce to be in the 200 status range
    *  
    * @param mixed $errors
    * @return {\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response}
    */  
    public function response(array $errors)
    {
                               
         
        //  203 Non-Authoritative Information (since HTTP/1.1)
        // The server is a transforming proxy (e.g. a Web accelerator) 
        // that received a 200 OK from its origin, 
        // but is returning a modified version of the origin's response
        //
        return \Response::json(['messages: '=>$errors],203);
        
       // return \Response::json($errors,300); 
       // return   $errors;
    }     
}

/*
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ResourceException('Invalid Inputs', $validator->getMessageBag());
    }
}
*/
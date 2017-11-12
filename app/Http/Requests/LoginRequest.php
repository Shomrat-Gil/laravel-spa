<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){      
        //$companyGuid = session('company')->guid;              
        $rules = []; 
        switch($this->method()){
            case 'GET':
            
            break;
            case 'DELETE':
            
            break;
            case 'POST':  
                /*    
                 switch($this->get('name')){
                     case "email":
                         $rules = ["value"=>"email"];                         
                     break;
                     case "blocked":
                         $rules = ["value"=>"boolean"];                         
                     break;
                     case "title":
                         $rules = ["value"=>"required|string|min:1|max:250"];                         
                     break;
                     case "type":
                         $rules = ["value"=>"numeric|min:1"];                         
                     break;   
                     case "description":
                         $rules = ["value"=>"string|min:1|max:250"];                         
                     break;   
                     case "lot_size":
                         $rules = ["value"=>"numeric|min:1"];                         
                     break;    
                     case "bedrooms":
                         $bedrooms = config('platform.environment._bedrooms');
                         $bedrooms = implode(',',array_keys($bedrooms));
                         $rules = ["value"=>"numeric|in:{$bedrooms}"];                         
                     break;    
                     case "bathrooms":
                         $rules = ["value"=>"numeric|min:1"];                         
                     break;    
                 }
                 */
            break;
            case 'PUT':
            case 'PATCH':   
                $rules = [
                    //
                    'email'=>'required|email|exists:users,email',  
                    'password'=>'required|string|min:1', 
                ];
            break;
            default:
            break;
        }
 
         
       //$rules = $this->customRulesPassword($rules);   
       return $rules;
    }
            
// end class
}
 
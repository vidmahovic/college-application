<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use App\Validators\AdminValidator;
use Dingo\Api\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Transformers\FacultyTransformer;

class AdminController extends ApiController
{
    protected $validator;

    public function __construct(Request $request, AdminValidator $validator)
    {
        $this->validator = $validator;
        parent::__construct($request);
    }

    public function faculties(){
        $faculties = Faculty::all();
        return $this->response->collection($faculties, new FacultyTransformer) ;
    }

    public function create(){
        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        if($this->request->input('role_id') == 4){
            return $this->response->errorBadRequest("Cannot create user!");
        }

        if($this->request->input('role_id') != 2 && $this->request->input('faculty_id') != null){
            return $this->response->errorBadRequest("Only referent can be connected to a faculty!");
        }

        $user = User::create([
            'email' => $this->request->input('email'),
            'username' => $this->request->input('username'),
            'name' => $this->request->input('name'),
            'role_id' => $this->request->input('role_id'),
            'faculty_id' => $this->request->input('faculty_id')
        ]);
        $user->password = bcrypt($this->request->input('password'));
        $user->activated_at = Carbon::now();
        $user->save();

        return $this->response->created();
    }
}

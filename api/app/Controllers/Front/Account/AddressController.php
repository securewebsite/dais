<?php

namespace App\Controllers\Front\Account;
 
use App\Models\AttributeGroup;
use App\Controllers\Controller;
use Illuminate\Http\Request;
 
 
class AddressController extends Controller {
 
    public function index() {
    	return Address::all();
    }
}

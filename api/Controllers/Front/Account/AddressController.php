<?php

namespace Api\Controllers\Front\Account;
 
use Api\Models\AttributeGroup;
use Api\Controllers\Controller;
use Illuminate\Http\Request;
 
 
class AddressController extends Controller {
 
    public function index() {
    	return Address::all();
    }
}

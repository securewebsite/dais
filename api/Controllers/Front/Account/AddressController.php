<?php

namespace Api\Controllers\Front\Account;
 
use Api\Models\Address;
use Api\Controllers\Controller;
use Illuminate\Http\Request;
 
 
class AddressController extends Controller {
 
    public function index() {
    	return Address::all();
    }

    public function createAddress(Request $request) {
        return Address::create($request->all());
    }
}

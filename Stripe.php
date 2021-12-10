<?php
namespace App\Controllers;
class stripe extends BaseController{
	public function index(){
		$session = session();
		helper('form');
		
		return view('index',['errors'=> $session->errors]);
	}
	public function success(){
		$session = session();
		try {
	        if ($session->is_access_allowed === true){
	            $_SESSION['is_access_allowed'] = 'false';
	            \Stripe\Stripe::setApiKey('sk_test_token');
	            $sessionStripe = \Stripe\Checkout\Session::retrieve($this->request->getGet('session_id'));
	            if ($sessionStripe->payment_status === 'paid'){
	                $db = \Config\Database::connect();
	                $db->query('INSERT INTO payments (name,currency,email,amount,id) VALUES (?,?,?,?,?)',
	                	[$session->name,$sessionStripe->currency,$sessionStripe->customer_details->email,$sessionStripe->amount_total,$sessionStripe->id]);
	                switch ($sessionStripe->currency){
	                	case 'inr':
	                		$sign = '₹';
	                		break;
	                	case 'gbp':
	                		$sign = '£';
	                		break;
	                	default:
	                		$sign = '$';
	                }

				   $email = \Config\Services::email();

				   $email->setFrom('example@domain.com', 'Name');
				   $email->setTo($sessionStripe->customer_details->email);
				   
				   $email->setSubject('subject');
				   $email->setMessage(view('success'));

				   if (!$email->send()) 
				       log_message('error',$email->printDebugger(['headers']));


	                return view('success',['sign'=>$sign,'products'=>$session->products,'price'=>$sessionStripe->amount_total]);
	            }
	        }else
		    	echo 'Try Again...';
		        
		}catch(Exception $e){
	        echo 'Unauthorized Access.';
		}
	}
	public function payout(){
		$session = session();
		$validation = \Config\Services::validation();
		header('Content-Type: application/json');

		if (!empty($this->request->getMethod() == 'post')){
		 	$rules = [
		 		'terms'=> 'required',
                'name' => 'required|trim|alpha_space',
                'amount' => 'trim|is_natural_no_zero',
                'products' => 'trim|required|alpha_space',
            ];
			if ($this->validate($rules)){
				$_SESSION['name'] =  $this->request->getPost('name');
				$_SESSION['products'] =  $this->request->getPost('products');
				$_SESSION['is_access_allowed'] = true;
				\Stripe\Stripe::setApiKey('sk_test_token');
			
			    $checkout_session = \Stripe\Checkout\Session::create([
			        'line_items' => [[
			            'price_data' => [
			              'currency' => $this->request->getPost('currency'),
			              'product_data' => [ 'name' => $this->request->getPost('products')],
			              'unit_amount' => $this->request->getPost('amount')."00",
			            ],
			            'quantity' => 1,
			          ]],
			          'mode' => 'payment',
			          "billing_address_collection"=>"required",
			          'success_url' => base_url()."/success?session_id={CHECKOUT_SESSION_ID}",
			        'cancel_url' => base_url().'/cancel',
			    ]);
			    header("HTTP/1.1 303 See Other");
			    return redirect()->to($checkout_session->url);
			}else{
				$_SESSION['errors'] = $validation->listErrors();
				$session->markAsFlashdata('errors');
				return redirect()->to(base_url());
			}
      	}
	}
}
<?php
namespace App\Http\Controllers\API;

use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;


// created models
use App\Models\Customer_signup;
use App\Models\Broker_signup;
use App\Models\Manufacture_signup;
use App\Models\Cus_ForgotPassoword;
use App\Models\Bro_ForgotPassword;
use App\Models\Categories;
use App\Models\Customer_orders;
use App\Models\MasterItems;
use App\Models\Color_code;
use App\Models\Details_json;



use ZipArchive;
use DB;

class Customer extends Controller
{
    public $successStatus = 200;
    /**
         * login api
         *
         * @return \Illuminate\Http\Response
         */

    /**
         * Register api
         *
         * @return \Illuminate\Http\Response
         */

   public function testingyah(Request $request)
   {
      echo 'hi';
   }

   public function categories()
   {
      return Categories::all();
   }



    public function tokenvalidation(Request $request)
    {
        $finduser = Customer_signup::where('email', $request->email)->first();
        if ($finduser) {
            // echo "There is data";

            if ($finduser->token_id == null) {
                $token = openssl_random_pseudo_bytes(256);

                //Convert the binary data into hexadecimal representation.
                $token = bin2hex($token);

                //Print it out for example purposes.


                DB::table('customer_signup')->where('id', $finduser->id)->update(['token_id' => $token ]);


                $finduser1 = Customer_signup::where('email', $finduser->email)->first();

                return response()->json(['message'=> 'Token Assigned', 'access_token' => $finduser1->token_id
                                                 ], 200);
            } else {
                return response()->json(['message'=> 'Token Allready Assigned', 'access_token' => $finduser->token_id
                                                 ], 200);
            }
        } else {
            // echo "There is data";
            return response()->json(['message'=> 'No user found'
                                               ], 200);
        }
    }

    // updated
    public function CustomerSignup(Request $request)
    {
        $finduser = Customer_signup::where('email', $request->email)->first();
        $findbroker = Broker_signup::where('Broker_ID', $request->broker)->first();

        $findmanufacture = Broker_signup::where([
           ['Broker_ID', $request->broker],
           ['manufacture', $request->manufacture]
           ])->first();

        if ($finduser) {
            // echo "There is data";
            return response()->json(['message'=> 'User All Ready Registered'
                                                ], 200);
        } elseif (!$findbroker) {
            // broker does not exist
            return response()->json(['message'=> 'Broker does not exist'
                                              ], 200);
        } elseif (!$findmanufacture) {
            // manufacture does not exist
            return response()->json(['message'=> 'Manufacture does not exist'
                                              ], 200);
        } else {
            $token = openssl_random_pseudo_bytes(256);

            //Convert the binary data into hexadecimal representation.
            $token = bin2hex($token);

            $findmanufacturedetails= Manufacture_signup::where('manufacture_id',$request->manufacture)->first();

            $customer_signup = [
                'Name' => $request->Name,
                'Designation' => $request->Designation,
                'Compnay' => $request->Compnay,
                'GSTIN' => $request->GSTIN,
                'Address' => $request->Address,
                'City' => $request->City,
                'Mobile' => $request->Mobile,
                'Password' => $request->Password,
                'Otherphone' => $request->Otherphone,
                'broker' => $findbroker->Broker_ID,
                'manufacture' => $findmanufacturedetails->manufacture_id,
                'email' => $request->email,
                'landmark' => $request->landmark,
                'token_id' => $token,
                'delivery_charge' => $findbroker->delivery_charge,
                'order_type' => $findmanufacturedetails->order_type,
            ];

            // $cat = Categories::all();
            //  $items = Product_items::all();

            $Customer_signup = new Customer_signup($customer_signup);
            $Customer_signup->save();

            // only essential details
            $findcustomer = Customer_signup::where('email', $request->email)->first(['id','Name','email','Compnay','broker','manufacture','token_id']);
            // $getsupdetails = SupervisorSignup::where('vendor_id', $findcustomer->Vendorid)->first();

            // $master_items = Master_Items::where('sup_id', $getsupdetails->id)->first();
            //
            // if ($master_items) {
            //     $array = json_decode($master_items->items, true);
            //     $items = collect($array);
            // }

            return response()->json([
              'message'=> 'New Customer Register.',
              'User' => $findcustomer,
              // 'manufacture' => $findmanufacturedetails,
              // 'Categories' => $cat,
              // 'items' => $items,
              'access_token' => $findcustomer->token_id ], 200);
        }
    }


    /**
         * details api
         *
         * @return \Illuminate\Http\Response
         */

    // updated
    public function CustomerOrder(Request $request)
    {
        if ($request->header('Authorization')) {
            // $getcusName = '';
            $findcustomer = Customer_signup::where('email', $request->email)->first();

                if(!empty($findcustomer)) {
                    if ($findcustomer->token_id == $request->header('Authorization')) {
                                  // if ($findcustomerid) {
                                  //     $getcusName = $findcustomerid->Name;
                                  //
                                  //     $getsupdetails = SupervisorSignup::where('vendor_id', $findcustomerid->Vendorid)->first();
                                  //
                                  //     if ($getsupdetails) {
                                  //         $getsupid = $getsupdetails->vendor_id ;
                                  //         $supnubid = $getsupdetails->id ;
                                  //     }
                                  // }
                                  //   echo $getsupid;
                                  //   echo mb_convert_encoding($request->order_details, 'UTF-8', 'UTF-8');

                                 // if(empty($request->delivery_charge))
                                 // {
                                 //   $delivery_charge = 0;
                                 // }
                                 // else {
                                 //   $delivery_charge = $request->delivery_charge;
                                 // }

                                  $order_det = [
                                        'customer_id' => $findcustomer->id,
                                        'customer_name' => $findcustomer->Name,
                                        'manufacture_id' => $findcustomer->manufacture,
                                        'broker_id' => $findcustomer->broker,
                                        'order_details' => $request->order_details,
                                        'baletype' => $request->baletype,
                                        'measuretype' => $request->measuretype,
                                        'quantity' => $request->quantity,
                                        // 'order_total' => $request->order_total,
                                        'order_status' => $request->order_status,
                                        // 'delivery_charge' => $delivery_charge,
                                        // 'invoice_data' => $request->invoice_data,
                                        'invoice_path' => $request->invoice_path,
                                        'order_type' => $request->order_type,
                                        // 'created_at' => $request->created_at,
                                  ];

                                  $CustomerOrder = new Customer_orders($order_det);
                                  $CustomerOrder->save();

                      //             if ($request->get_noti != 'no') {
                      //                 $getName = '';
                      //
                      //                 $findcustomerid = Customer_signup::where('id', $request->customer_id)->first();
                      //
                      //                 if ($findcustomerid) {
                      //                     $getName = $findcustomerid->Name;
                      //                 }
                      //
                      //                 $content = array(
                      // //     "en" => 'English Message'
                      //      "en" => 'Order No : '. $CustomerOrder->id
                      //      );
                      //
                      //
                      //                 $heading = array(
                      //      "en" => $getName.' Order Created'
                      //      );
                      //
                      //                 $fields = array(
                      //      'app_id' => "c38b5793-5650-4402-a324-64574c111299",
                      //      'filters' => array(array("field" => "tag", "key" => "sup_id", "relation" => "=", "value" => $supnubid )),
                      //      'data' => array("foo" => "bar"),
                      //      'contents' => $content,
                      //      'headings' => $heading,
                      //      'large_icon'=>'https://cdn.plutusmart.com/vendor/companylogo/wholesalegrocery.png'
                      //      );
                      //
                      //
                      //                 $fields = json_encode($fields);
                      //                 //    print("\nJSON sent:\n");
                      //                 //    print($fields);
                      //
                      //                 $ch = curl_init();
                      //                 curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                      //                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                      //                         'Authorization: Basic MjAwNWZhZGEtYzM5MC00YmRhLWE3ZDQtMjMzZjBlYTk4NDg3'));
                      //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      //                 curl_setopt($ch, CURLOPT_HEADER, false);
                      //                 curl_setopt($ch, CURLOPT_POST, true);
                      //                 curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                      //                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                      //
                      //                 $response = curl_exec($ch);
                      //                 curl_close($ch);
                      //
                      //                 $return["allresponses"] = $response;
                      //                 $return = json_encode($return);
                      //             }


                                  $order = Customer_orders::where('id', $CustomerOrder->id)->first();

                                  return response()->json([
                                    'message'=> 'New Order Placed',
                                    'data' => $order], 200);
                    }
                    else {
                        return response()->json(['message'=> 'Bad token' ], 200);
                    }
                }
                else{
                    return response()->json(['message'=> 'Email not exist' ], 200);
                }
        }
        else {
            return response()->json(['message'=> 'Unauthorized request' ], 200);
        }
    }

    // updated
    public function Cuslogin(Request $request)
    {

        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        $user = Customer_signup::where('email', $request->email)->where('Password', $request->password)->first(['id','Name','email','Compnay','broker','manufacture','address','city','landmark','token_id']);

        //  echo $user;

        if (!empty($user)) {

       /*
       $user = User::select('company_user.id','company_user.company_id','company_user.username','company_user.email','company_user.country','company_user.city','company_user.company_user_photo_url','company_user.district','company_user.service','company.company_name','company.company_photo_url','company.company_display_pic','treatment_quota','token_id')
               ->leftJoin('company', function($join) {
                 $join->on('company_user.company_id', '=', 'company.company_id');
               })
               ->find($user->id);

      */

            // $cat = Categories::all();
            //  $items = Product_items::all();

            $getbrokerdetails = Broker_signup::where('Broker_id', $user->broker)->first();
            $getmanufacturedetails = Manufacture_signup::where('Manufacture_id', $user->manufacture)->first();

            // $master_items = Master_Items::where('sup_id', $getsupdetails->id)->first();

            // if ($master_items) {
            //     $array = json_decode($master_items->items, true);
            //     $items = collect($array);
            // }


            if ($user->token_id == null) {
                $token = openssl_random_pseudo_bytes(256);
                //Convert the binary data into hexadecimal representation.
                $token = bin2hex($token);

                 DB::table('c_customer')->where('id', $user->id)->update(['token_id' => $token ]);

                 //Print it out for example purposes.
                 // $user = Customer_signup::where('email', $request->email)->where('Password', $request->password)->first(['id','Name','email','Compnay','Vendorid','address','city','landmark','token_id']);

            }


            return response()->json([
              'access_token' =>  $user->token_id,
              'User' => $user,
              // 'Categories' => $cat,
              // 'items' => $items,
              'message'=>" Successfully"
              ], 200);
            } else {
                return response()->json(['data'=>'',
                                      'message'=>"No user Found"], 404);
        }
    }

	public function ViewOrder(Request $request)
    {
        if ($request->header('Authorization')) {
            $findcustomer = Customer_signup::where('email', $request->email)->first();
                if(!empty($findcustomer)) {
                    if ($findcustomer->token_id == $request->header('Authorization')) {
						$order = Customer_orders::where('customer_id', $findcustomer->id)->
						// where('id', $request->orderId)->
						orderBy('id', 'desc')->get();
						if (!empty($order)) {
		                    return response()->json(['message'=> 'All Orders','Orders' => $order], 200);
					    }
						else {
						   return response()->json(['message'=> 'No Orders'], 200);
						}
                    }
                    else {
                        return response()->json(['message'=> 'Bad token' ], 200);
                    }
                }
                else{
                    return response()->json(['message'=> 'Email not exist' ], 200);
                }
        }
        else {
            return response()->json(['message'=> 'Unauthorized request' ], 200);
        }
    }

    // updated
    public function cusForgotpassword(Request $request)
    {
        $finduser = Customer_signup::where('email', $request->email)->first();

        if ($finduser) {

            // echo "There is data";

            $findemail = Cus_ForgotPassoword::where('email', $request->email)->first();

            if (!$findemail) {
                $pass = [
                 'email' => $request->email,
             ];

                $Cus_ForgotPassoword = new Cus_ForgotPassoword($pass);
                $Cus_ForgotPassoword->save();

                //   Cus_ForgotPassoword

                return response()->json(['message'=> 'Forgot password Requrest sent'
                                  ], 200);
            } else {
                return response()->json(['message'=> 'All ready Forgot password Requrest sent'
                                  ], 200);
            }
        } else {
            return response()->json(['message'=> 'User Not registred'
                                ], 200);
        }
    }

    // updated
    public function broForgotpassword(Request $request)
    {
        $finduser = Broker_signup::where('email', $request->email)->first();

        if ($finduser) {

            // echo "There is data";

            $findemail = Bro_ForgotPassword::where('email', $request->email)->first();

            if (!$findemail) {
                $pass = [
                 'email' => $request->email,
             ];

                $Bro_ForgotPassword = new Bro_ForgotPassword($pass);
                $Bro_ForgotPassword->save();

                //   Cus_ForgotPassoword

                return response()->json(['message'=> 'Forgot password Requrest sent'
                                  ], 200);
            } else {
                return response()->json(['message'=> 'All ready Forgot password Requrest sent'
                                  ], 200);
            }
        } else {
            return response()->json(['message'=> 'User Not registred'
                                ], 200);
        }
    }


    public function Homecall(Request $request)
    {
        if ($request->header('Authorization')) {
            $findcustomer1 = Customer_signup::where('email', $request->email)->first();

              if(!empty($findcustomer1)){
                  if ($findcustomer1->token_id == $request->header('Authorization')) {

                      $date = date('Y-m-d H:i:s');

                      DB::table('c_customer')->where('id', $findcustomer1->id)->update([
                        // 'OS' => $request->OS,
                        // 'App' => $request->App ,
                        'last_open' => $date ]);

                      $cat = Categories::all();
                      $color = Color_code::all();

                      $findcustomer = Customer_signup::select('Name', 'email', 'Mobile', 'broker', 'manufacture', 'lump', 'than', 'TL', 'order_type')->where('email', $request->email)->first();

                      $master_items = MasterItems::select('items')->where('manufacture_id', $findcustomer->manufacture)->where('order_type', $findcustomer->order_type)->first();

                      // $FlashMessages = FlashMessages::select('Message')->where('Type', 'Home')->where('city', $findcustomer->city)->first();

                      // $AdsCompanyList = AdsCompanyList::where('city', $findcustomer->city)->get();

                      if ($master_items) {
                          $array = json_decode($master_items->items, true);
                          $items = collect($array);
                      }

                      // $Fmessage = '';

                      // if ($FlashMessages) {
                      //     $Fmessage =   $FlashMessages->Message;
                      // } else {
                      //     $Fmessage = "NoFlash";
                      // }
                      //
                      // $AdsAvalible = '';
                      //
                      // if ($AdsCompanyList) {
                      //     $AdsAvalible =   $AdsCompanyList;
                      // } else {
                      //     $AdsAvalible = "NoAds";
                      // }
                      //
                      $assetpath = 'http://52.15.119.201/uploads/' ;
                      //
                      // $orderexport = '1' ;

                      return response()->json([
                        'message'=> 'User details',
                        'assetpath' => $assetpath ,
                        // 'VendorName' => $getsupdetails->vendor_id ,
                        // 'ManufactureDetails' => $getmanufacturedetails,
                        'User' => $findcustomer ,
                        'Categories' => $cat,
                        'items' => $items ,
						'color' => $color,
                        // 'Flash'  => $Fmessage ,
                        // 'Adscomp' => $AdsAvalible ,
                        // 'orderexport' => $orderexport
                      ], 200);

                  } else {
                      return response()->json(['message'=> 'Bad token' ], 200);
                  }
              } else {
                  return response()->json(['message'=> 'email not registered' ], 200);
              }
        } else {
            return response()->json(['message'=> 'Unauthorized request' ], 200);
        }
    }


    // updated
    public function DefaultMeasureType(Request $request)
    {
        if ($request->header('Authorization')) {

            $findcustomer1 = Customer_signup::where('email', $request->email)->first();

                      if(!empty($findcustomer1)) {

                                    if ($findcustomer1->token_id == $request->header('Authorization')) {
                                        $date = date('Y-m-d H:i:s');
                                        // updating the database
										$findcustomerupdate = Customer_signup::where('email', $request->email)->first();
                                        return response()->json([
                                          'message'=> 'Updated customer details',
                                          'lump' => $findcustomerupdate->lump ,
                                          'than' => $findcustomerupdate->than ,
                                          'TL' => $findcustomerupdate->TL ,
                                          'updated_at' => $findcustomerupdate->updated_at ,
                                           ], 200);
                                    }
                                    else {
                                        return response()->json(['message'=> 'Bad token' ], 200);
                                    }
                      }
                      else {
                          return response()->json(['message'=> 'Email not exist' ], 200);
                      }
        }
        else {
            return response()->json(['message'=> 'Unauthorized request' ], 200);
        }
    }


	// public function DetailsJSON(Request $request)
	// {
    //  $input = $request->all();
	//  // DB::table('details_json')->where('id', '1')->update([ ]);
	//  // $previous = Details_json::select('details')->where('id', '1')->first();
    //  // $record = Details_json::create(["details" => json_encode($input)]);
	//  // $previous = Details_json::all();
	//  //
	//  //
    //  //  response()->json([
	//  //   'message'=> 'Updated customer details',
	//  //   'previous' => $previous ,
	// 	// ], 200);
	// 	Details_json::find(1)->update(['details' => json_encode($input) ]);
	//
	// }

	public function DetailsJSON(Request $request)
    {
		$input = $request->all();
		// fetch previous data
		$previous = Details_json::select('details')->where('id', '1')->first();;

		if($previous){
			$previous = json_decode($previous->details, true);
			array_unshift($previous, $input);
			DB::table('details_json')->where('id', '1')->update(['details' => json_encode($previous)] );
		}
		else {
			$previous = Details_json::create(["details" => json_encode($input) ]);
		}
	    return response()->json([
	      	'message'=> 'New Order Placed',
	       	'data' => $previous], 200);

    }



}

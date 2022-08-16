<?php
namespace App\Http\Services;

use App\Models\TourGuide;
use App\Models\Tourguide_verfication;
use App\Models\Tripagent;
use App\Models\Tripagent_verfication;
use App\Models\User_verfication;
use App\Models\User;
use Carbon\Carbon;
use Request;
use Illuminate\Support\Facades\Auth;

use Twilio\Rest\Client;

class SMSServices
{

    public function setVerficationCode($data)
    {
        $today=Carbon::now();
        $otpcode=mt_rand(1000,9999);
        $data['otpcode']=$otpcode;
        User_verfication::where(['user_id'=>$data['user_id']])->delete();
        // return User_verfication::create($data);
        return User_verfication::create([
            'user_id'=>$data['user_id'],
            'otpcode'=>$data['otpcode'],
            'expired_at'=>$today->addMinutes(05),
        ]);

		//هيبقي جيلك من $data>>user_id,oto_code
    }

    public function checkOtpCode($code,$user_id)
    {
        // if(Auth::guard()->check())
        // {
            $verificationdata=User_verfication::where('user_id',$user_id)->first();
           if($verificationdata->otpcode==$code)
           {
                 $expiredate=$verificationdata->expired_at;
                 $datenow=Carbon::now();
                if($expiredate>$datenow)
                {
                    User::where('id',$user_id)->update([
                        'verified_at'=>now(),
                    ]);
                    return true;
                }
                else
                {
                    return false;

                }
               
                   
           }
           else
           {
               return false;
           }
        // }
        
    }

   public function removeOtpCode($code)
    {
        User_verfication::where('otpcode',$code)->delete();
        
    }

    public function getSMSVerifyMessageByAppName($code)
    {
        $message1="Your Verifivation Code for your account ";
        return $message1.$code;
    }

    public function reset_password($code)
    {
        $verificationdata=User_verfication::where('otpcode',$code)->first();
           if($verificationdata)
           {
              
               return true;
           }
           else
           {
               return false;
           }
        }
        
        public function sendSms($phone,$message)
        {
           
            try{
                       $sid= getenv("TWILIO_SID");
                       $token= getenv("TWILIO_TOKEN");
                       $twilio_from= getenv("TWILIO_FROM");

                    //    $reciveNumber=$phone;
                     // dd($phone);

                       $client = new Client($sid, $token);
                    //    $validation_request = $client->validationRequests
                    //    ->create($phone, // phoneNumber
                    //             ["friendlyName" => "My Home Phone Number"]
                    //    );

                       $client->messages->create($phone, // to
                                         [
                                             "body" => $message,
                                             "from" => $twilio_from
                                         ]
                                );
                     if($client)
                     {
                         return true;
                     }
            }
            catch(\Exception $ex)
            {
              return false;
            }
        }
        

        //Tripagent sms

        public function setTripagent_VerficationCode($data)
        {
            $today=Carbon::now();
            $otpcode=mt_rand(1000,9999);
            $data['otpcode']=$otpcode;
            Tripagent_verfication::where(['user_id'=>$data['user_id']])->delete();
            // return User_verfication::create($data);
            return Tripagent_verfication::create([
                'user_id'=>$data['user_id'],
                'otpcode'=>$data['otpcode'],
                'expired_at'=>$today->addMinutes(05),
            ]);
    
            //هيبقي جيلك من $data>>user_id,oto_code
        }
    
        public function checkOtpCode_Trpagent($code,$user_id)
        {
            // if(Auth::guard()->check())
            // {
                $verificationdata=Tripagent_verfication::where('user_id',$user_id)->first();
               if($verificationdata->otpcode==$code)
               {
                     $expiredate=$verificationdata->expired_at;
                     $datenow=Carbon::now();
                    if($expiredate>$datenow)
                    {
                        Tripagent::where('id',$user_id)->update([
                            'verified_at'=>now(),
                        ]);
                        return true;
                    }
                    else
                    {
                        return false;
    
                    }
                   
                       
               }
               else
               {
                   return false;
               }
            // }
            
        }
    
       public function removeOtpCode_Tripagent($code)
        {
            Tripagent_verfication::where('otpcode',$code)->delete();
            
        }
    
      
    
        public function resetpassword_Tripagent($code)
        {
            $verificationdata=Tripagent_verfication::where('otpcode',$code)->first();
               if($verificationdata)
               {
                  
                   return true;
               }
               else
               {
                   return false;
               }
            }
             //Tripagent sms

             
       //tourguide

        public function setTurguide_VerficationCode($data)
        {
            $today=Carbon::now();
            $otpcode=mt_rand(1000,9999);
            $data['otpcode']=$otpcode;
            Tourguide_verfication::where(['user_id'=>$data['user_id']])->delete();
            // return User_verfication::create($data);
            return Tourguide_verfication::create([
                'user_id'=>$data['user_id'],
                'otpcode'=>$data['otpcode'],
                'expired_at'=>$today->addMinutes(05),
            ]);
    
            //هيبقي جيلك من $data>>user_id,oto_code
        }
    
        public function checkOtpCode_Tourguide($code,$user_id)
        {
            // if(Auth::guard()->check())
            // {
                $verificationdata=Tourguide_verfication::where('user_id',$user_id)->first();
               if($verificationdata->otpcode==$code)
               {
                     $expiredate=$verificationdata->expired_at;
                     $datenow=Carbon::now();
                    if($expiredate>$datenow)
                    {
                        TourGuide::where('id',$user_id)->update([
                            'verified_at'=>now(),
                        ]);
                        return true;
                    }
                    else
                    {
                        return false;
    
                    }
                   
                       
               }
               else
               {
                   return false;
               }
            // }
            
        }
    
       public function removeOtpCodeTourguide($code)
        {
            Tourguide_verfication::where('otpcode',$code)->delete();
            
        }
    
      
    
        public function resetpassword_Tourguide($code)
        {
            $verificationdata=Tourguide_verfication::where('otpcode',$code)->first();
               if($verificationdata)
               {
                  
                   return true;
               }
               else
               {
                   return false;
               }
            }    
 
       //turguide
      


    }

  

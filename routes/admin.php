<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeTypeController;


use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\AdsListController;
use App\Http\Controllers\Admin\AdsPopupController;
use App\Http\Controllers\Admin\AdsSlideShowController;
use App\Http\Controllers\Admin\AdsSocialMediaController;
use App\Http\Controllers\Admin\AgencyTypeController;
use App\Http\Controllers\admin\CarTypeController;
use App\Http\Controllers\Admin\CommonQuestions;
use App\Http\Controllers\admin\ConsultationTypeController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\admin\MethodCommunicationController;
use App\Http\Controllers\admin\OtherServiceController;
use App\Http\Controllers\Admin\TermConditionController;
use App\Http\Controllers\admin\TimeCommunicationController;
use App\Http\Controllers\Admin\UsagePolicyController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DropDownlistsController;
use App\Http\Controllers\Admin\EvaluationController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PopupSliderPhotoController;
use App\Http\Controllers\Admin\RetrunPloicyController;
use App\Http\Controllers\Admin\TourguideController;
use App\Http\Controllers\Admin\TripAgentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Models\SocialMediaTypes;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


use App\Http\Controllers\Admin\ScoialMediaTypesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth:admin' ]
    ], function(){
         
       
        Route::get('/admin/dashboard', function () {
            return view('dashboard.admin.dashboard');
        })->name('dashboard.admin');
        
    //Servicess Root
    Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){
        Route::get('showservices',[ServiceController::class,'index'])->name('showservices');
        Route::post('/addservice',[ServiceController::class,'store'])->name('addservice');
        Route::get('editservice/{id}',[ServiceController::class,'edit'])->name('editservice');
        Route::post('/update_service',[ServiceController::class,'update'])->name('updateservice');
        Route::post('/delete_service/{id}',[ServiceController::class,'destroy'])->name('deleteservice');

        #service attribute
        Route::get('showservice_attribute',[ServiceController::class,'showserviceattribute'])->name('showservice_attribute');
        Route::post('/storeserviceattribute',[ServiceController::class,'storeserviceattribute'])->name('storeserviceattribute');
        Route::post('Filter_Servicess', 'ServiceController@Filter_Servicess')->name('Filter_Servicess');
        Route::post('/Delete_attrbuteService', 'ServiceController@Delete_attrbuteService')->name('Delete_attrbuteService');
        Route::post('/delete_allattributeservice', 'ServiceController@delete_allattributeservice')->name('delete_allattributeservice');
        Route::post('/updateservice_attribute', 'ServiceController@updateservice_attribute')->name('updateservice_attribute');

      

        
        
        // Route::get('getattribute_type/{id}',[ServiceController::class,'getattribute_type'])->name('get_attributetype');
    });


     //attrbiutes Root
     Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){
        Route::get('showattributes',[AttributeController::class,'index'])->name('showattributes');
        Route::post('addattribute',[AttributeController::class,'store'])->name('addattribute');
        Route::get('editattribute/{id}',[AttributeController::class,'edit'])->name('editattribute');
        Route::post('/delete_attribute/{id}',[AttributeController::class,'destroy'])->name('deleteattribute');
        Route::post('/updateattribute',[AttributeController::class,'update'])->name('updateattribute');

        
    });

    //attrbiutestype Root
    Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){
        Route::get('showattributes_types',[AttributeTypeController::class,'index'])->name('showattributes_types');
        Route::post('addattribute_type',[AttributeTypeController::class,'store'])->name('addattribute_type');
        Route::post('/delete_attribtype/{id}',[AttributeTypeController::class,'destroy'])->name('delete_attribtype');
        Route::get('editattributetype/{id}',[AttributeTypeController::class,'edit'])->name('editattributetype');
        Route::post('/updateattribute_type',[AttributeTypeController::class,'update'])->name('updateattribute_type');

        
          #ads attributes
          Route::get('showads_attribute',[AdsController::class,'adsattribute'])->name('ads_attribute');
          Route::post('/addaadsttribute',[AdsController::class,'add_adsattribute'])->name('add_adsattribute');
          Route::get('edit_adsattrib/{id}',[AdsController::class,'edit_adsattrib'])->name('edit_adsattrib');
          Route::post('/update_adsattr', 'AdsController@update_adsattr')->name('update_adsattr');
          Route::post('/delete_adsattr/{id}',[AdsController::class,'destroy'])->name('delete_adsattr');

        
          


        
      //contact us
      Route::get('/contactus_message',[ContactUsController::class,'index'])->name('contactus');
      Route::get('/showmessage/{id}',[ContactUsController::class,'showmessage'])->name('showmessage');

      
      Route::get('/aboutus',[AboutUsController::class,'index'])->name('aboutus');
      Route::post('/addaboutus',[AboutUsController::class,'store'])->name('addaboutus');
      Route::post('/delete_aboutus/{id}',[AboutUsController::class,'delete'])->name('deleteaboutus');
      Route::get('/editaboutus/{id}',[AboutUsController::class,'edit'])->name('editaboutus');
      Route::post('/update_aboutus',[AboutUsController::class,'update'])->name('update_aboutus');

    //CommonQuestions
    Route::get('/ShowCommonQuestions',[CommonQuestions::class,'index'])->name('ShowCommonQuestions');
    Route::post('/addquestion',[CommonQuestions::class,'store'])->name('addquestion');
    Route::post('/delete_question/{id}',[CommonQuestions::class,'destroy'])->name('delete_question');
    Route::get('/editquestion/{id}',[CommonQuestions::class,'edit'])->name('editquestion');
    Route::post('/updatequestion',[CommonQuestions::class,'update'])->name('updatequestion');

    //helps
    Route::get('/Showhelps',[HelpController::class,'index'])->name('Showhelps');
    Route::get('/ShowhelpRequests',[HelpController::class,'helpRequests'])->name('ShowhelpRequests');
    Route::get('/view_attachment/{filename}',[HelpController::class,'view_attachment'])->name('view_attachment');
    Route::get('/viewtripagent_attachment/{filename}',[HelpController::class,'viewtripagent_attachment'])->name('viewtripagent_attachment');
    Route::get('/viewtourguide_attachment/{filename}',[HelpController::class,'viewtourguide_attachment'])->name('viewtourguide_attachment');

    Route::get('/requesthelpdetails/{id}',[HelpController::class,'showrequestdetials'])->name('requesthelpdetails');
    Route::post('/updaterequesthelp_details',[HelpController::class,'updaterequesthelp_details'])->name('updaterequesthelp_details');

    
     //Reurn_Policy
     Route::get('/retrunpolicy',[RetrunPloicyController::class,'index'])->name('retrunpolicy');
     Route::post('/addpolicy',[RetrunPloicyController::class,'store'])->name('addpolicy');
     Route::post('/delete_policy/{id}',[RetrunPloicyController::class,'destroy'])->name('delete_policy');
     Route::get('/editpolicy/{id}',[RetrunPloicyController::class,'edit'])->name('editpolicy');
     Route::post('/updatepolicy',[RetrunPloicyController::class,'update'])->name('updatepolicy');
 
     
    
    Route::post('/addhelp',[HelpController::class,'store'])->name('addhelp');
    Route::get('/edithelp/{id}',[HelpController::class,'edit'])->name('edithelp');
    Route::post('/update_help',[HelpController::class,'update'])->name('update_help');
    Route::post('/delete_help/{id}',[HelpController::class,'destroy'])->name('delete_help');

    
    
    //adminprofile
    Route::get('/showprofile',[AdminController::class,'index'])->name('showprofile');

    
    //TermsAndConditions
    Route::get('/terms_conditions',[TermConditionController::class,'index'])->name('terms_conditions');
    Route::post('/add_termsconditions',[TermConditionController::class,'store'])->name('add_termsconditions');
    

    //add_UsagePolicy
    Route::get('/usagepolicy',[UsagePolicyController::class,'index'])->name('usagepolicy');
    Route::post('/add_UsagePolicy',[UsagePolicyController::class,'store'])->name('add_UsagePolicy');
    
    //Ads_SlideShow

    Route::get('/Ads_SlideShow',[AdsSlideShowController::class,'index'])->name('Ads_SlideShow');
    Route::post('/add_ads',[AdsSlideShowController::class,'store'])->name('add_ads');
    Route::post('/delete_AdsSlideShow/{id}',[AdsSlideShowController::class,'delete'])->name('delete_AdsSlideShow');
    Route::get('/edit_adsslide/{id}',[AdsSlideShowController::class,'edit'])->name('edit_adsslide'); 
    Route::post('/update_ads',[AdsSlideShowController::class,'update'])->name('update_ads');
    
    //car_type
    Route::get('/show_cartype',[CarTypeController::class,'index'])->name('show_cartype');
    Route::post('/addcartype',[CarTypeController::class,'store'])->name('addcartype');
    Route::get('/edit_cartype/{id}',[CarTypeController::class,'edit'])->name('edit_cartype'); 

    Route::post('/update_cartype',[CarTypeController::class,'update'])->name('update_cartype');
    Route::post('/delete_cartype/{id}',[CarTypeController::class,'destroy'])->name('delete_cartype');

    //methodcommunicate
    Route::get('/showmethodcommunicate',[MethodCommunicationController::class,'index'])->name('showmethodcommunicate');
    Route::post('/add_methodcommunicate',[MethodCommunicationController::class,'store'])->name('add_methodcommunicate');
    Route::get('/edit_MethodCommunicate/{id}',[MethodCommunicationController::class,'edit'])->name('edit_MethodCommunicate'); 

    Route::post('/update_methodcommunicate',[MethodCommunicationController::class,'update'])->name('update_methodcommunicate');
    Route::post('/delete_methodcommunicate/{id}',[MethodCommunicationController::class,'destroy'])->name('delete_methodcommunicate');

     //timecommunicate
     Route::get('/showtimecommunicate',[TimeCommunicationController::class,'index'])->name('showtimecommunicate');
     Route::post('/add_timecommunicate',[TimeCommunicationController::class,'store'])->name('add_timecommunicate');
     Route::get('/edit_timeCommunicate/{id}',[TimeCommunicationController::class,'edit'])->name('edit_timeCommunicate'); 
 
     Route::post('/update_timecommunicate',[TimeCommunicationController::class,'update'])->name('update_timecommunicate');
     Route::post('/delete_timecommunicate/{id}',[TimeCommunicationController::class,'destroy'])->name('delete_timecommunicate');
 
    //consultationtype
    Route::get('/showconsultation_type',[ConsultationTypeController::class,'index'])->name('showconsultation_type');
    Route::post('/add_consultationtype',[ConsultationTypeController::class,'store'])->name('add_consultationtype');
    Route::get('/edit_consultationtype/{id}',[ConsultationTypeController::class,'edit'])->name('edit_consultationtype'); 

    Route::post('/update_consultationtype',[ConsultationTypeController::class,'update'])->name('update_consultationtype');
    Route::post('/delete_consultationtype/{id}',[ConsultationTypeController::class,'destroy'])->name('delete_consultationtype');

//otherSerivces
Route::get('/show_otherservies',[OtherServiceController::class,'index'])->name('show_otherservies');
Route::post('/add_otherservies',[OtherServiceController::class,'store'])->name('add_otherservies');
Route::get('/edit_otherservies/{id}',[OtherServiceController::class,'edit'])->name('edit_otherservies'); 

Route::post('/update_otherservies',[OtherServiceController::class,'update'])->name('update_otherservies');
Route::post('/delete_otherservies/{id}',[OtherServiceController::class,'destroy'])->name('delete_otherservies');

//CurrencyController
Route::get('/currency',[CurrencyController::class,'index'])->name('currency');
Route::get('/edit_currency/{id}',[CurrencyController::class,'edit'])->name('edit_currency');
Route::post('/delete_currency/{id}',[CurrencyController::class,'destroy'])->name('delete_currency');
Route::post('/addcurrency',[CurrencyController::class,'store'])->name('addcurrency');
Route::post('/update_currency',[CurrencyController::class,'update'])->name('update_currency');

//pakages
Route::get('/ads',[AdsController::class,'index'])->name('packages');
Route::post('/add_ads',[AdsController::class,'store'])->name('add_ads');
Route::post('/delete_ads/{id}',[AdsController::class,'destroy'])->name('delete_ads');
Route::get('/edit_ads/{id}',[AdsController::class,'edit'])->name('edit_ads');
Route::post('/update_ads',[AdsController::class,'update'])->name('update_ads');


Route::get('/scoialmedia_types',[ScoialMediaTypesController::class,'index'])->name('scoialmedia_types');
Route::post('/addsocialmedia_type',[ScoialMediaTypesController::class,'store'])->name('addsocialmedia_type');
Route::post('/delete_socialtype/{id}',[ScoialMediaTypesController::class,'destroy'])->name('delete_socialtype');
Route::get('/edit_social/{id}',[ScoialMediaTypesController::class,'edit'])->name('edit_social');
Route::post('/update_socialmediatype',[ScoialMediaTypesController::class,'update'])->name('update_socialmediatype');


//show_DropDownListList
Route::get('/show_DropDownListList',[DropDownlistsController::class,'index'])->name('show_DropDownListList');
Route::post('/addDropDownLists',[DropDownlistsController::class,'store'])->name('addDropDownLists');
Route::get('/editDropDwonlist/{id}',[DropDownlistsController::class,'edit'])->name('editDropDwonlist');
Route::post('/update_DropDownList',[DropDownlistsController::class,'update'])->name('update_DropDownList');
Route::post('/delete_DropDownList/{id}',[DropDownlistsController::class,'destroy'])->name('delete_DropDownList');


//show_ِAgenctType
Route::get('/AgencyTypeList',[AgencyTypeController::class,'index'])->name('AgencyTypeList');
 Route::post('/addAgencyType',[AgencyTypeController::class,'store'])->name('addAgencyType');
Route::get('/editagency/{id}',[AgencyTypeController::class,'edit'])->name('editagency');
 Route::post('/update_agency',[AgencyTypeController::class,'update'])->name('update_agency');
 Route::post('/delete_AgenctType/{id}',[AgencyTypeController::class,'destroy'])->name('delete_AgenctType');

 

//show_country
Route::get('/Country_List',[CountryController::class,'index'])->name('Country_List');
 Route::post('/addCountry',[CountryController::class,'store'])->name('addCountry');
Route::get('/editCountry/{id}',[CountryController::class,'edit'])->name('editCountry');
 Route::post('/update_country',[CountryController::class,'update'])->name('update_country');
 Route::post('/delete_country/{id}',[CountryController::class,'destroy'])->name('delete_country');



//tripagent in admin
Route::get('/tripagents',[TripAgentController::class,'index'])->name('tripagents');
Route::get('/edit_trpagentstatus/{id}',[TripAgentController::class,'edit'])->name('edit_trpagentstatus');
Route::post('/updatetripagent_status',[TripAgentController::class,'update'])->name('updatetripagent_status');

//tourguide
Route::get('/tourguides',[TourguideController::class,'index'])->name('tourguides');
Route::get('/edit_tourguide/{id}',[TourguideController::class,'edit'])->name('edit_tourguide');
Route::post('/updatetourguide_status',[TourguideController::class,'update'])->name('updatetourguide_status');


Route::get('/show_DropDownListListelements',[DropDownlistsController::class,'showdropdownlist_elements'])->name('show_DropDownListListelements');
Route::post('/storedropdownlist_elements',[DropDownlistsController::class,'store_elements'])->name('storedropdownlist_elements');
Route::post('/Delete_dropdownlistelement',[DropDownlistsController::class,'delete_dropdownelement'])->name('Delete_dropdownlistelement');
Route::post('/delete_allelements',[DropDownlistsController::class,'delete_allelements'])->name('delete_allelements');
Route::post('/updates_attributeelement',[DropDownlistsController::class,'updates_attributeelement'])->name('updates_attributeelement');


  //ads_socialmedia
    Route::get('ads_socialmedia',[AdsSocialMediaController::class,'index'])->name('ads_socialmedia');
    Route::get('/view_adsattachment/{filename}',[AdsSocialMediaController::class,'view_adsattachment'])->name('view_adsattachment');
    Route::post('/updaterequest_details',[AdsSocialMediaController::class,'update'])->name('updaterequest_details');
    Route::get('showrequestad_details/{id}',[AdsSocialMediaController::class,'showrequestad_details'])->name('showrequestad_details');

    //Popup_ads
     Route::get('Popup_ads',[AdsPopupController::class,'index'])->name('Popup_ads');
     Route::get('/view_popattachment/{filename}',[AdsPopupController::class,'view_popattachment'])->name('view_popattachment');
     Route::get('showrequestad_popdetails/{id}',[AdsPopupController::class,'showrequestad_details'])->name('showrequestad_popdetails');
     Route::post('/updaterequest_popdetails',[AdsPopupController::class,'update'])->name('updaterequest_popdetails');

     
     
     //Evaluations
     Route::get('Tripagents_Evaluation',[EvaluationController::class,'Tripagents_Evaluation'])->name('Tripagents_Evaluation');
     Route::get('Tourguides_Evaluation',[EvaluationController::class,'Tourguides_Evaluation'])->name('Tourguides_Evaluation');

     //popphotoslider
     Route::get('photoslider',[PopupSliderPhotoController::class,'index'])->name('photoslider');
     Route::post('/add_photo',[PopupSliderPhotoController::class,'store'])->name('add_photo');

     Route::get('/editpopupslider/{id}',[PopupSliderPhotoController::class,'edit'])->name('editpopupslider');
     Route::get('/view_popattachment/{filename}',[PopupSliderPhotoController::class,'view_popattachment'])->name('view_popattachment');
     Route::post('/delete_popslider/{id}',[PopupSliderPhotoController::class,'delete'])->name('delete_popslider');
     Route::post('/update_popslider',[PopupSliderPhotoController::class,'update'])->name('update_popslider');

     
     Route::get('/show_adsList',[AdsListController::class,'index'])->name('show_adsList');
     Route::post('/storeads_list',[AdsListController::class,'store'])->name('storeads_list');
     Route::get('/edit_adslist/{id}',[AdsListController::class,'edit'])->name('edit_adslist');
     Route::post('/updated_adslist',[AdsListController::class,'update'])->name('updated_adslist');

     

    });

    
    });





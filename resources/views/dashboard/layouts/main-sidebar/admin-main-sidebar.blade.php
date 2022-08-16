<div class="scrollbar side-menu-bg" style="overflow: scroll">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Dashboard-->
                    <li>
                        <a href="{{ url('/admin/dashboard') }}">
                            <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                    <!-- menu title -->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Wejhatak_App')}} </li>
   <!-- services-->
   <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Grades-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('main_trans.Services')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Grades-menu" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('showservices')}}">{{trans('main_trans.Services_list')}}</a></li>
                            <li><a href="{{route('showservice_attribute')}}">{{trans('serviceattribute_trans.service_attribute')}}</a></li>

                            
                        </ul>
                    </li>
     <!-- ads-->
               <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Packages-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">@lang('ads_trans.Ads_List')</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Packages-menu" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('packages')}}">{{trans('ads_trans.Ads_List')}}</a></li>
                            <li><a href="{{route('ads_socialmedia')}}">{{trans('ads_trans.Ads_SocialMedia')}}</a></li>
                            <li><a href="{{route('Popup_ads')}}">{{trans('ads_trans.Popup_ads')}}</a></li>
                            <li><a href="{{route('show_adsList')}}">{{trans('ads_trans.ads_list')}}</a></li>
                            <hr>
                            <li><a href="{{route('photoslider')}}">{{trans('ads_trans.photoslider')}}</a></li>

                            
                        </ul>
                    </li>

            <!-- AgencyType-->
            <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Agency-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('AgencyType_trans.AgencyType')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Agency-menu" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('AgencyTypeList')}}">{{trans('AgencyType_trans.AgencyTypeList')}}</a></li>
                            <hr>
                            <li><a href="{{route('Country_List')}}">{{trans('Country_trans.CountryList')}}</a></li>

                            
                        </ul>
                    </li>
              <!-- attributes-->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#attrbute-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('attribute_trans.attrubites')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="attrbute-menu" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('showattributes_types')}}">{{trans('attributetype_trans.attrubite_type')}}</a></li>
                            <li><a href="{{route('showattributes')}}">{{trans('attribute_trans.attrubiteslist_services')}}</a></li>
                           <hr>
                           <li><a href="{{route('show_DropDownListList')}}">{{trans('DropDownLists_trans.DropDownLists_List')}}</a></li>
                           <li><a href="{{route('show_DropDownListListelements')}}">{{trans('DropDownLists_trans.Dropdownlist_elements')}}</a></li>

                           <hr>

                            <li>
                              <a href="{{route('ads_attribute')}}">
                                {{trans('ads_trans.AdsAttributes_List')}}
                              </a>
                            </li>
                          
                        </ul>
                       
                    </li>
                 
                 
                      <!-- ShoHelps -->
                      <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#ShoHelps-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('main_trans.Helps')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="ShoHelps-menu" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('ShowhelpRequests')}}">{{trans('helps_trans.Requests_Help')}}</a></li>
                            <hr>
                            <li><a href="{{route('Showhelps')}}">{{trans('helps_trans.Helps_Types')}}</a></li>

                        </ul>
                    </li>



                   
                  
                     <!-- OtherService -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#OtherServices-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('otherservice_trans.OtherServices')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="OtherServices-menu" class="collapse" data-parent="#sidebarnav">
                            <!-- <li><a href="{{route('show_otherservies')}}">{{trans('otherservice_trans.OtherServices list')}}</a></li> -->
                            <li><a href="{{route('showconsultation_type')}}">{{trans('consulationtype_trans.Consultion_Types list')}}</a></li>
                            <!-- <li><a href="{{route('showmethodcommunicate')}}">{{trans('MethodCommunicate_trans.method communicate list')}}</a></li> -->
                            <!-- <li><a href="{{route('showtimecommunicate')}}">{{trans('TimeCommunicate_trans.time communicate list')}}</a></li> -->
                            <!-- <li><a href="{{route('show_cartype')}}">{{trans('cartypes_trans.car_typeslist')}}</a></li> -->

                        </ul>
                    </li>

                   
                    
                     <!-- Terms and Condition -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#ShoTerms-menu">
                            <div class="pull-left"><i class="fa-solid fa-gears"></i><span
                                    class="right-nav-text">{{trans('main_trans.Settings')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="ShoTerms-menu" class="collapse" data-parent="#sidebarnav">
                           <li><a href="{{route('retrunpolicy')}}">{{trans('returnploicy_trans.ReturnPloicy')}}</a></li>
                            <hr>
                            <!-- <li><a href="{{route('terms_conditions')}}">{{trans('Terms_trans.TermsAndConditions')}}</a></li>
                            <hr>
                            <li><a href="{{route('usagepolicy')}}">{{trans('main_trans.UsagePolicy')}}</a></li>
                           <hr> -->
                            <li><a href="{{route('ShowCommonQuestions')}}">{{trans('CommonQuestions_trans.CommonQuestions')}}</a></li>
                           <hr>
                            <li><a href="{{route('aboutus')}}">{{trans('Aboutus_trans.aboutus')}}</a></li>
                           <hr>
                            <li><a href="{{route('contactus')}}">{{trans('main_trans.Contactus')}}</a></li>
                            <hr>
                            <li><a href="{{route('currency')}}">{{trans('main_trans.Currencies')}}</a></li>

                        </ul>
                    </li>


                      <!-- Ads SlideShow -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#activies-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('main_trans.Activate accounts')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="activies-menu" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('tripagents')}}">{{trans('tripagent_trans.Activate Tripagent')}}</a></li>
                            <li><a href="{{route('tourguides')}}">{{trans('tripagent_trans.Activate Tourguide')}}</a></li>

                        </ul>
                    </li>
    <!-- Star Evalutions -->  
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#activies-menu34">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('Evalutions_trans.Evaluations')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="activies-menu34" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('Tripagents_Evaluation')}}">{{trans('Evalutions_trans.Tripagents_Evaluation')}}</a></li>
                            <li><a href="{{route('Tourguides_Evaluation')}}">{{trans('Evalutions_trans.Tourguide_Evaluation')}}</a></li>

                        </ul>
                    </li>
    <!-- Star Evalutions -->  

                      <!-- Ads SlideShow -->
                      <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#AdsSlideShow-menu">
                            <div class="pull-left"><i class="fas fa-building"></i><span
                                    class="right-nav-text">{{trans('main_trans.AdsSlideShow')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="AdsSlideShow-menu" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{route('scoialmedia_types')}}">{{trans('Ads_trans.scoialmedia_types')}}</a></li>
                            <li><a href="{{route('Ads_SlideShow')}}">{{trans('AdsSlideShow_trans.Ads_list')}}</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
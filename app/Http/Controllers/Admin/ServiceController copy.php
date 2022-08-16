<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Serivce;
use App\Models\Attribute;
use App\Models\AttributeType;
use App\Models\ServiceAttruibute;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $data['services']=Serivce::orderby('id','desc')->get();
        return view('dashboard.admin.services.index')->with($data);
    }

    public function store(Request $request)
    {
      
      $validator = Validator::make($request->all(),
        [
             'service_ar'=>'required|unique:serivces,name->ar',
             'service_en'=>'required|unique:serivces,name->en',
             'service_ar.required'=>trans('validation.required'),
             'service_en.required'=>trans('validation.required')         
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $service=Serivce::create([
              'name' => ['en' => $request->service_en, 'ar' => $request->service_ar],
              'desc'=>$request->desc,
            ]);
            if(!is_null($service)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
              //return redirect()->route('showservices');
            }
  
          }
    }

    public function edit($id)
    {
      $service=Serivce::findorfail($id);
      if($service)
      {
        return response()->json($service);
      }
    }


    public function update(Request $request)
    {
      // return response($request);
      $validator=Validator::make($request->all(),[
        // 'service_ar'=>'required|unique:serivces,name,'.$request->service_id,
        'service_ar'=>'required|unique:serivces,name->ar,'.$request->service_id,
        'service_en'=>'required|unique:serivces,name->en,'.$request->service_id,
        'service_ar.required'=>trans('validation.required'),
        'service_en.required'=>trans('validation.required')  
    ]);
    if ($validator->fails())
    {
    return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    else{
      $services=Serivce::where('id',$request->service_id)->update([
        'name' => ['en' => $request->service_en,'ar' => $request->service_ar],
        'desc'=>$request->desc,
      ]);

    //   $Grades->update([
    //     $Grades->Name=['ar'=>$request->Name,'en'=>$request->Name_en],
    //     $Grades->Notes=$request->Notes,
    // ]);
      if(!is_null($services))
      {
        toastr()->success(trans('messages_trans.success'));
        return response()->json(['success'=>'Added new records.']);
      }
    }
      
    }

    public function destroy($id)
    {
        $service=Serivce::where('id',$id)->delete();
        if(!is_null($service))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

    public function showserviceattribute()
    {
      $data['services']=Serivce::orderby('id','desc')->get();
      // $data['attributes']=Attribute::orderby('id','desc')->get();
      $data['attributes']=Attribute::select('attributes.id','attributes.name','attribute_types.name as attributetype_name')
      ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
      ->get(); 
      $data['service_attributes']=ServiceAttruibute::get();
      return view('dashboard.admin.service_attribute.index')->with($data);
    }

    public function storeserviceattribute(Request $request)
    {
          
     $List_ServiceAttrbites=$request->List_ServiceAttrbites;
     $val=$request->validate([
      'List_ServiceAttrbites.*.service_id'=>'required',
      'List_ServiceAttrbites.*.attributes_id'=>'required',
      'List_ServiceAttrbites.*.attribute_order'=>'required',
      'List_ServiceAttrbites.*.service_id.required'=>trans('validation.required'),
      'List_ServiceAttrbites.*.attributes_id.required'=>trans('validation.required'),
      'List_ServiceAttrbites.*.attribute_order.required'=>trans('validation.required')

    ]);

try{ 
  
  foreach($List_ServiceAttrbites as $List_ServiceAttrbite)
  {
   
    if (DB::table('service_Attribute')->where('service_id', $List_ServiceAttrbite['service_id'])->where('attribute_id',$List_ServiceAttrbite['attributes_id'])->exists())
    {
    return redirect()->back()->withErrors(trans('My_Classes_trans.exis333ts'));
    }
    if (DB::table('service_Attribute')->where('service_id', $List_ServiceAttrbite['service_id'])->where('order',$List_ServiceAttrbite['attribute_order'])->exists())
    {
    return redirect()->back()->withErrors(trans('My_Classes_trans.existsdd'));
    }
    DB::table('service_Attribute')->insert([
         'service_id'=>$List_ServiceAttrbite['service_id'],
         'attribute_id'=>$List_ServiceAttrbite['attributes_id'],
         'order'=>$List_ServiceAttrbite['attribute_order'],

    ]);
  
  }
  toastr()->success(trans('messages_trans.success'));
  return redirect()->route('showservice_attribute');
}
catch (\Exception $e){
  return redirect()->back()->withErrors(['error' => $e->getMessage()]);
}
     
    }


    public function Filter_Servicess(Request $request)
    {
    // return $request;
    if ($request->service_id=='*')
    {
      return redirect()->route('showservice_attribute');
    }
    else{
      $data['services'] = Serivce::all();
      $data['attributes']=Attribute::select('attributes.id','attributes.name','attribute_types.name as attributetype_name')
      ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
      ->get(); 
      
       $data['Search'] = ServiceAttruibute::select('*')->where('service_id','=',$request->service_id)->get();
     return view('dashboard.admin.service_attribute.index')->with($data);
 
    }
   
    }

    public function Delete_attrbuteService(Request $request)
    {
      $attrbute_servie=ServiceAttruibute::where('id',$request->id)->delete();
      if($attrbute_servie)
      {
        toastr()->error(trans('serviceattribute_trans.delete row success'));
        return redirect()->route('showservice_attribute');

      }
    }

    public function delete_allattributeservice(Request $request)
    {
      // return $request;
      $delete_all_id = explode(",", $request->delete_all_id);
      // dd($delete_all_id);
      ServiceAttruibute::whereIn('id', $delete_all_id)->Delete();
      toastr()->error(trans('serviceattribute_trans.delete row success'));
      return redirect()->route('showservice_attribute');
    }

    public function updateservice_attribute(Request $request)
    {
                
     $val=$request->validate([
      // 'service_id'=>'required|unique:service_Attribute,service_id,'.$request->attribute_serviceid,
      // 'attributes_id'=>'required|unique:service_Attribute,attribute_id,'.$request->attribute_serviceid,
      'attribute_order'=>'required',
      'service_id.required'=>trans('validation.required'),
      'attributes_id.required'=>trans('validation.required'),
      // 'attribute_order.required'=>trans('validation.required')
    ]);

try{ 
  
    $orderid=ServiceAttruibute::where('id',$request->attribute_serviceid)->select('order')->first();
  if($orderid->order==$request->attribute_order)
  {
    return redirect()->route('showservice_attribute');

  }
   
    elseif (DB::table('service_Attribute')->where('service_id', $request->service_id)->where('order',$request->attribute_order)->exists())
    {
    return redirect()->back()->withErrors(trans('My_Classes_trans.existsdd'));
    }
    ServiceAttruibute::where('id',$request->attribute_serviceid)->update([
      // 'service_id'=>$request->service_id,
      // 'attribute_id'=>$request->attributes_id,
      'order'=>$request->attribute_order,
    ]);
  
  
  
  toastr()->success(trans('messages_trans.success'));
  return redirect()->route('showservice_attribute');
}
catch (\Exception $e){
  return redirect()->back()->withErrors(['error' => $e->getMessage()]);
}
    }
  
}
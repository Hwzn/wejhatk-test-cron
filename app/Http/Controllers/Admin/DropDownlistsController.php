<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SelectType;
use App\Models\SelectTypeEelements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

class DropDownlistsController extends Controller
{
    public function index()
    {
        $data['SelectTypes']=SelectType::orderby('id','desc')->get();
        return view('dashboard.admin.DropDownLists.index')->with($data);
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),
       [
            'name'=>'required',
            'name.required'=>trans('validation.required')         
       ]);

       if ($validator->fails())
       {
       return response()->json(['error'=>$validator->errors()->all()]);

       }

       else {
           $SelectType=SelectType::create([
             'name'=>$request->name,
           ]);
           if(!is_null($SelectType)) {
             toastr()->success(trans('messages_trans.success'));
             return response()->json(['success'=>'Added new records.']);
           }
 
         }
    }

    public function edit($id)
    {
       $SelectType=SelectType::findorfail($id);
       if($SelectType)
       {
         return response()->json($SelectType);
       }
    }

    public function update(Request $request)
    {
        // return response($request);
      $validator=Validator::make($request->all(),[
             'name'=>'required|unique:select_types,name,'.$request->select_typeid,
             'name.required'=>trans('validation.required'),
    ]);
    if ($validator->fails())
    {
    return response()->json(['error'=>$validator->errors()->all()]);
    }
    else{
      $data=SelectType::where('id',$request->select_typeid)->update([
        'name' => $request->name,
      ]);

    
      if(!is_null($data))
      {
        toastr()->success(trans('messages_trans.success'));
        return response()->json(['success'=>'Added new records.']);
      }
    }
      
    }

    public function destroy($id)
   {
       $data=SelectType::where('id',$id)->delete();
       if(!is_null($data))
     {
       toastr()->error(trans('SelectTypes_trans.Message_Delete'));
       return response()->json(['success'=>'deleted  success.']);
     }
   }

   public function showdropdownlist_elements()
   {
     $data['dropdownlists']=SelectTypeEelements::orderby('id','desc')->get();
     $data['dropdownList_menus']=SelectType::orderby('id','desc')->get();

     return view('dashboard.admin.DropDownLists.DropdwnListElements.index')->with($data);
    }

    public function store_elements(Request $request)
    {
     // return $request;
      $List_ServiceAttrbiteselemnt=$request->List_ServiceAttrbiteselemnt;
      $val=$request->validate([
       'List_ServiceAttrbiteselemnt.*.dropdown_id'=>'required',
       'List_ServiceAttrbiteselemnt.*.attribute_values_ar'=>'required',
       'List_ServiceAttrbiteselemnt.*.attribute_values_en'=>'required',

       'List_ServiceAttrbiteselemnt.*.dropdown_id.required'=>trans('validation.required'),
       'List_ServiceAttrbiteselemnt.*.attribute_values_ar.required'=>trans('validation.required'),
       'List_ServiceAttrbiteselemnt.*.attribute_values_en.required'=>trans('validation.required')

      ]);
 
 try{ 
   
   foreach($List_ServiceAttrbiteselemnt as $List_ServiceAttrbiteselemnt)
   {
    
    //  if (DB::table('selecttype_elements')->where('selecttype_id', $List_ServiceAttrbiteselemnt['dropdown_id'])->where('name',$List_ServiceAttrbiteselemnt['attribute_values_ar'])
    //  ->orwhere('name',$List_ServiceAttrbiteselemnt['attribute_values_en'])->exists())
    //  {
    //  return redirect()->back()->withErrors(trans('My_Classes_trans.exis333ts'));
    //  }
     DB::table('selecttype_elements')->insert([
          'selecttype_id'=>$List_ServiceAttrbiteselemnt['dropdown_id'],
          'name'=>json_encode(["en"=>$List_ServiceAttrbiteselemnt['attribute_values_en'],"ar"=>$List_ServiceAttrbiteselemnt['attribute_values_ar']]),
     ]);
   
   }
   toastr()->success(trans('messages_trans.success'));
   return redirect()->route('show_DropDownListListelements');
 }
 catch (\Exception $e){
   return redirect()->back()->withErrors(['error' => $e->getMessage()]);
 }
      
    }
    public function delete_dropdownelement(Request $request)
    {

      $attrbute_servie=SelectTypeEelements::where('id',$request->id)->delete();
      if($attrbute_servie)
      {
        toastr()->error(trans('serviceattribute_trans.delete row success'));
        return redirect()->route('show_DropDownListListelements');
      }
    }

    public function delete_allelements(Request $request)
    {
      // return $request;
      $delete_all_id = explode(",", $request->delete_all_id);
      // dd($delete_all_id);
      SelectTypeEelements::whereIn('id', $delete_all_id)->Delete();
      toastr()->error(trans('serviceattribute_trans.delete row success'));
      return redirect()->route('show_DropDownListListelements');
    }

    public function updates_attributeelement(Request $request)
    {
      $val=$request->validate([
        'attribute_dropdown_en'=>'required',
        'attribute_dropdown_ar'=>'required',

        'dropdownlist_id.required'=>trans('validation.required'),
        'attribute_dropdown.required'=>trans('validation.required'),
        // 'attribute_order.required'=>trans('validation.required')
      ]);
  
  try{ 
    
    //   $orderid=SelectTypeEelements::where('id',$request->attribute_serviceid)->select('order')->first();
    // if($orderid->order==$request->attribute_order)
    // {
    //   return redirect()->route('showservice_attribute');
  
    // }
     
     
      SelectTypeEelements::where('id',$request->dropdownlist_id)->update([
        'name'=>json_encode(["en"=>$request->attribute_dropdown_en,"ar"=>$request->attribute_dropdown_ar]),
      ]);
    
    
    
    toastr()->success(trans('messages_trans.success'));
    return redirect()->route('show_DropDownListListelements');
  }
  catch (\Exception $e){
    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
  }
    }

}

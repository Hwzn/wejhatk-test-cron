<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CommonQuestion;

class CommonQuestions extends Controller
{
    public function index()
    {
        $commonquestions=CommonQuestion::orderby('id','desc')->get();
        return view('dashboard.admin.commonquestion.index',compact('commonquestions'));

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'question_ar'=>'required|unique:common_questions,question->ar',
             'question_en'=>'required|unique:common_questions,question->en',
             'answer_ar'=>'required',
             'answer_en'=>'required',
             'question_ar.required'=>trans('validation.required'),
             'question_en.required'=>trans('validation.required'),
             'answer_ar.required'=>trans('validation.required'),
             'answer_en.required'=>trans('validation.required'),        
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $commonquestions=CommonQuestion::create([
              'question' => ['en' => $request->question_en, 'ar' => $request->question_ar],
              'answer' => ['en' => $request->answer_en, 'ar' => $request->answer_ar],
               'status'=>$request->status==true?'1':'0',
            ]);
            if(!is_null($commonquestions)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
              //return redirect()->route('showservices');
            }
  
          }
    }

    public function destroy($id)
    {
        $CommonQuestions=CommonQuestion::where('id',$id)->delete();
        if(!is_null($CommonQuestions))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

    public function edit($id)
    {
        $commonquestions=CommonQuestion::findorfail($id);
      if($commonquestions)
      {
        return response()->json($commonquestions);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            //  'question_ar'=>'required|unique:common_questions,question->ar',
            //  'question_en'=>'required|unique:common_questions,question->en',
            'question_ar'=>'required',
            'question_en'=>'required',
             'answer_ar'=>'required',
             'answer_en'=>'required',
             'question_ar.required'=>trans('validation.required'),
             'question_en.required'=>trans('validation.required'),
             'answer_ar.required'=>trans('validation.required'),
             'answer_en.required'=>trans('validation.required'),        
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
            $commonquestions=CommonQuestion::where('id',$request->question_id)->update([
                'question' => ['en' => $request->question_en, 'ar' => $request->question_ar],
                'answer' => ['en' => $request->answer_en, 'ar' => $request->answer_ar],
                'status'=>$request->status,

            ]);
         
            if(!is_null($commonquestions))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


}

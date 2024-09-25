<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Field;
use App\Models\Option;
use App\Models\DynamicForm;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DynamicFormValue;
use App\Models\DynamicUser;
use Illuminate\Support\Facades\DB;

class DynamicFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $forms = DynamicForm::select('slug', 'name')->groupBy('slug', 'name')->get();
        return view('dynamic-form.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->role == 'User'){
            return redirect()->to('/dashboard');
        }
        $fields = Field::all();
        return view('dynamic-form.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $is_form_exist = DynamicForm::where('slug', Str::slug($request->form_name, '-'))->first();

            if ($is_form_exist) {
                return redirect()->back()->withError("$request->form_name is already exist");
            }

            $data = $request->except("_token");
            $keys = array_keys($data);

            $new_arr = [];
            foreach ($keys as $indx =>  $key) {
                $key_arr = explode('_', $key);
                if (isset($key_arr[0]) && $key_arr[0] == 'fieldname') {
                    $new_arr[$indx]['dynamic_field'] = $data[$key_arr[0] . '_' . $key_arr[1]];

                    $is_multiple = "multiplechoice_$key_arr[1]";
                    if (in_array($is_multiple, $keys)) {

                        $new_arr[$indx]['options'] = $data[$is_multiple];
                    }

                    $is_required = "hidden_field_" . $key_arr[1];
                    if (in_array($is_required, $keys)) {
                        $new_arr[$indx]['required'] = true;
                    }

                    $type = "type_" . $key_arr[1];
                    if (in_array($type, $keys)) {
                        $new_arr[$indx]['type'] = $data[$type];
                    }

                    $new_arr[$indx]['name'] = $request->form_name;
                    $new_arr[$indx]['slug'] =  Str::slug($request->form_name, '-');
                }
            }

            foreach ($new_arr as $key => $item) {
                $item['user_id'] = auth()->user()->id;
                if (isset($item['options'])) {
                    $options = $item['options'];
                    $item = Arr::except($item, "options");
                    $dynamic_form_id = DynamicForm::insertGetId($item);

                    foreach ($options as $option) {
                        $option_data['value'] = $option;
                        $option_data['dynamic_form_id'] = $dynamic_form_id;
                        Option::create($option_data);
                    }
                } else {
                    DynamicForm::create($item);
                }
            }

            return redirect()->to('dashboard')->withSuccess('Successfully form generated');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DynamicForm  $dynamicForm
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $form_values = DynamicFormValue::where('dynamic_user_id', $slug)->get();
        return view('dynamic-form.show', compact('form_values'));
    }


    public function allUser($slug)
    {
        if(auth()->user()->role == 'Administration'){
            $form_users = DynamicFormValue::where('dynamic_form_slug', $slug)->select('dynamic_user_id')->distinct()->pluck('dynamic_user_id')->toArray();

            $users = [];
            if (count($form_users) == 1) {
                $users = DynamicUser::whereIn('id', [$form_users])->get();
            } elseif (count($form_users) > 1) {
                $users = DynamicUser::whereIn('id', $form_users)->get();
            }
        }elseif(auth()->user()->role == 'User'){
            $users = DynamicUser::where('user_id', auth()->user()->id)->get();
        }
        

        return view('dynamic-form.all-user', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DynamicForm  $dynamicForm
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $form_values = DynamicFormValue::where('dynamic_user_id', $slug)->pluck('field_value', 'field_name')->toArray();
        $form_slug = DynamicFormValue::where('dynamic_user_id', $slug)->first();
        $dynamic_forms = DynamicForm::where('slug', $form_slug->dynamic_form_slug)->get();

        return view('dynamic-form.edit', compact('dynamic_forms', 'form_values', 'form_slug'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DynamicForm  $dynamicForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DynamicForm $dynamicForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DynamicForm  $dynamicForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(DynamicForm $dynamicForm)
    {
        //
    }

    public function dynamicFormValueCreate($name)
    {
        $dynamic_forms = DynamicForm::where('slug', $name)->get();
        return view('dynamic-form.form_create', compact('dynamic_forms'));
    }

    public function dynamicFormValueStore(Request $request, $slug)
    {
        $data = $request->except("_token");

        $keys = array_keys($data);

        $new_arr = [];
        foreach ($keys as $index => $key) {

            $new_arr[$index]['field_name'] = $key;
            $new_arr[$index]['dynamic_form_slug'] = $slug;
            if (is_array($data[$key])) {
                $new_arr[$index]['field_value'] = json_encode($data[$key]);
            } else {
                $new_arr[$index]['field_value'] = $data[$key];
            }
        }

        $user = [];
        $user['user_id'] = auth()->user()->id;
        $dynamic_user = DynamicUser::create($user);

        foreach ($new_arr as $item) {
            $item['dynamic_user_id'] = $dynamic_user->id;
            DynamicFormValue::create($item);
        }

        return redirect()->to('/dashboard')->withSuccess('Successfully created');
    }
    public function dynamicFormValueUpdate(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $data = $request->except("_token");

            $form = DynamicFormValue::where('dynamic_user_id', $id)->first();

            // DynamicForm::where('slug',$slug)->delete();

            $keys = array_keys($data);

            $new_arr = [];
            foreach ($keys as $index => $key) {

                $new_arr[$index]['field_name'] = $key;
                $new_arr[$index]['dynamic_form_slug'] = $form->dynamic_form_slug;
                if (is_array($data[$key])) {
                    $new_arr[$index]['field_value'] = json_encode($data[$key]);
                } else {
                    $new_arr[$index]['field_value'] = $data[$key];
                }
            }

            DynamicFormValue::where('dynamic_user_id', $id)->delete();

            foreach ($new_arr as $item) {
                $item['dynamic_user_id'] = $id;
                DynamicFormValue::create($item);
            }



            DB::commit();

            return redirect()->to('dashboard')->withSuccess('Successfully updated');
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

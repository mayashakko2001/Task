<?php

namespace App\Http\Controllers;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    public function home(){
        return view('users.getAllUsers', compact('users'));
    }
    public function index()
    {
        $users = User::all();
        $locale = app()->getLocale();

        foreach ($users as $user) {
            
            $user->translated_name = $this->translateText($user->name, $locale);
            $user->translated_national_card_number = $this->translateText($user->national_card_number, $locale);
            $user->translated_phone = $this->translateText($user->phone, $locale);
            $user->translated_driving_license_number = $this->translateText($user->driving_lincense_number, $locale);
        }

        return view('users.getAllUsers', compact('users'));
    }
    private function translateText($text, $locale)
    {
        
        if (empty($text)) {
            return ''; 
        }
    
    
        if ($locale !== 'en') { 
            try {
                return GoogleTranslate::trans($text, $locale);
            } catch (\Exception $e) {
                
                return $text; 
            }
        }
        return $text;
    }

    public function create()
    {
        return view('users.addUser');
    }
    
    public function store(Request $request)
{
  
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|regex:/^[\p{Arabic}\p{Latin}\s]+$/u',
        'phone' => 'required|string|regex:/^0[6-7][0-9]{8}$/|size:10',
        'driving_lincense_number' => 'required|string|regex:/^[A-Za-z0-9]{15}$/',
        'national_card_number' => 'required|string|digits:15',
        'path_personal_card_image' => 'required|file|mimes:jpeg,png,jpg,gif,pdf',
        'path_driving_license_image_front' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        'path_driving_license_image_Back' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
    ], [
        'name.required' => __('validation.required', ['attribute' => __('messages.name')]),
        'phone.required' => __('validation.required', ['attribute' => __('messages.phone')]),
        'driving_lincense_number.required' => __('validation.required', ['attribute' => __('messages.driving_license_number')]),
        'national_card_number.required' => __('validation.required', ['attribute' => __('messages.national_card_number')]),
 
    ]);
    
   
    if ($validator->fails()) {
        return redirect()->route('users.addUser')
                         ->withErrors($validator)
                         ->withInput();
    }

  
    $user = User::where('name', $request->name)
                ->orWhere('phone', $request->phone)
                ->orWhere('driving_lincense_number', $request->driving_lincense_number)
                ->orWhere('national_card_number', $request->national_card_number)
                ->first(); 

  
    if ($user) {
        return redirect()->route('users.addUser')
                         ->with('duplicateFound', true)
                         ->with('duplicateUserId', $user->id) 
                         ->withInput()->with('success', __('messages.duplicate_user'));
    }


    $personal_card_image = $request->file('path_personal_card_image');
    $personal_card_image_name = $personal_card_image->getClientOriginalName();
    $b = $personal_card_image->storeAs('uploads', $personal_card_image_name);

    $driving_license_image_front = $request->file('path_driving_license_image_front');
    $driving_license_image_front_name = time() . '_' . $driving_license_image_front->getClientOriginalName();
    $a = $driving_license_image_front->storeAs('uploads', $driving_license_image_front_name);

    $driving_license_image_back = $request->file('path_driving_license_image_Back');
    $driving_license_image_back_name = time() . '_' . $driving_license_image_back->getClientOriginalName();
    $c = $driving_license_image_back->storeAs('uploads', $driving_license_image_back_name);

   
    User::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'driving_lincense_number' => $request->driving_lincense_number,
        'national_card_number' => $request->national_card_number,
        'path_peronal_card_image' => $b,
        'path_driving_license_image_front' => $a,
        'path_driving_license_image_Back' => $c,
    ]);

  
    return redirect()->route('users.index')->with('success', __('messages.user_created'));
}
    //..........................................................................................................
    public function downloadPdfperonal_card($id) {
        $user = User::findOrFail($id); 
        $filePath = storage_path('app/' . $user->path_peronal_card_image); 
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }
        if (file_exists($filePath)) {
            return response()->file($filePath);
        }
    
       
    }
//...................................................................................
public function download_driving_license_image_front($id) {
    $user = User::findOrFail($id); 
    $filePath = storage_path('app/' . $user->path_driving_license_image_front); 
    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
}
//.........................................................................................

public function download_driving_license_image_Back($id) {
    $user = User::findOrFail($id); 
    $filePath = storage_path('app/' . $user->path_driving_license_image_Back); 
    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
}
public function change(Request $request)
    {
        $locale = $request->input('locale');
        if (in_array($locale, ['en', 'ar', 'fr'])) { 
            App::setLocale($locale);
            session()->put('locale', $locale);
        }
        
        return redirect()->back(); 
    }

//................................................................................................
public function detailsUser($userId)
{
    $user = User::findOrFail($userId);
    
 
    $locale = app()->getLocale();
    
 
    $user->translated_name = $this->translateText($user->name, $locale);
    $user->translated_national_card_number = $this->translateText($user->national_card_number, $locale);
    $user->translated_phone = $this->translateText($user->phone, $locale);
    $user->translated_driving_license_number = $this->translateText($user->driving_lincense_number, $locale); 

    return view('users.detailsUser', compact('user'));
}

public function someOtherMethod(Request $request)
{
    
    $userId = $request->input('user_id'); 
    $exists = User::where('id', $userId)->exists(); 

  
    if ($exists) {
        return redirect()->route('users.detailsUser', ['userId' => $userId])
                         ->with('duplicateFound', true)
                         ->with('message', __('messages.duplicate_user'))
                         ->withInput();
    }


    return redirect()->route('users.index')
                     ->with('message', __('messages.user_not_found')); 
}



public function changeLocale(Request $request)
{
    $request->validate(['locale' => 'required|in:en,ar,fr']);
    Session::put('locale', $request->locale);
    return redirect()->back();
}


public function search(Request $request)
{
   
    $request->validate([
        'name' => 'required|string|max:255',
    ], [
        'name.required' => __('validation.required', ['attribute' => __('messages.name')]),
    ]);

    $name = $request->input('name');
    $users = User::where('name', 'LIKE', '%' . $name . '%')->get(); 

   
    return view('users.getAllUsers', compact('users')); 
}

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $user->id)
                             ->withErrors($validator)
                             ->withInput();
        }

        $user->update($request->only('name', 'email'));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
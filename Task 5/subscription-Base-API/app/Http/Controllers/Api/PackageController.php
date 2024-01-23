<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Package;

class PackageController extends Controller
{
    public function addPackages(Request $request)
    {
        $validateData = $request->validate([
            'title' => ['required', 'unique:packages,title'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'expires_date' => ['required', 'date']
        ]);
        
        DB::beginTransaction();
        try{
            $package = Package::create($validateData);

            // $token = $package->createToken('authToken')->accessToken;
            DB::commit();

            return response()->json([
                // 'token' => $token,
                'package' => $package,
                'message' => 'Package added successfully',
                'status' => 1
            ], 200);

        }catch(\Exception $e){

            DB::rollback();
            return response()->json([
                'message' => 'Error creating package: ' . $e->getMessage(),
                'status' => 0
            ], 400);
        }
    }
    
    public function updatePackage(Request $request, $id)
    {
        $package = Package::find($id);

        if (is_null($package)) {
            return response()->json([
                'status' => 0,
                'message' => "Package id not exist"
            ], 400);
        }else{
            try {
                DB::beginTransaction();
    
                $package->title = $request->input('title');
                $package->description = $request->input('description');
                $package->price = $request->input('price');
                $package->expires_date = $request->input('expires_date');
                $package->updated_at =  date('Y-m-d H:i:s');;
                $package->save();
    
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                
                return response()->json([
                    'status' => 0,
                    'message' => "Internal server error",
                    'error' => $e->getMessage()
                ], 500);
            }
            return response()->json([
                'status' => 1,
                'message' => "Pacakge updated successfully"
            ], 200);
        }
    }

    public function deletePackage($id)
    {
        $package = Package::find($id);

        if(is_null($package)){
            $response = [
                'message' => 'Subscription package doesnot exits',
                'status' => 0
            ];
            $resCode = 400;
        }else{
            DB::beginTransaction();
            try{
                $package->delete();
                DB::commit();
                $response = [
                    'message' => 'Pacakge deteleted successfully',
                    'status' => 1
                ];
                $resCode = 200;
            }catch(\Exception $e){
                DB::rollBack();
                $response = [
                    'message' => 'Internal server error',
                    'status' => 0
                ];
                $resCode = 500;
            }
        }
        return response()->json($response, $resCode);
    }

    public function getAllPackages()
    {
        $packages = Package::all();
        
        return response()->json([
            // 'token' => $token,
            'packages' => $packages,
            'message' => 'All active packages',
            'status' => 1
        ], 200);

    }

    public function getPackage($id)
    {
        $package = Package::find($id);

        if(is_null($package)){
            $response = [
                'message' => 'Subscription package doesnot exits',
                'status' => 0
            ];
            $resCode = 400;
        }else{
            $response = [
                'package' => $package,
                'message' => 'package found',
                'status' => 1
            ];
            $resCode = 200;
        }
        return response()->json($response, $resCode);
        
    }
}

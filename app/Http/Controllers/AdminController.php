<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class Admincontroller extends Controller
{
   
    //
     //authentification//
   //inscription//
   function inscription(Request $request)
   {
    
     try {
         //step 1 : Validation des données
             //Tel
             $validateTelephone = Validator::make($request->all(), 
             [
                 'telephone' => 'required|min:10|unique:gestionnaires',
             ]);
             if ($validateTelephone->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Numero de téléphone incorrecte ou ce compte existe déjà',
                     'errors' => $validateTelephone->errors()
                 ], 401);
             }
          
             //date de naissance
             $validateDate_naiss = Validator::make($request->all(), 
             [
                 'date_naissance' => 'required',
             ]);
             if ($validateDate_naiss->fails()){
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre date de naissance',
                     'errors' => $validateDate_naiss->errors()
                 ], 401);
             }
            
             //DOMICILE
             $validateDomicile= Validator::make($request->all(), 
             [
                 'domicile' => 'required',
             ]);
             if ($validateDomicile->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre domicile',
                     'errors' => $validateDomicile->errors()
                 ], 401);
             }
             //nom
             $validateNom = Validator::make($request->all(), 
             [
                 'nom' => 'required|min:3',
             ]);
             if ($validateNom->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre nom minimum 3 caract^ères',
                     'errors' => $validateNom->errors()
                 ], 401);
             }
             //prenom
             $validatePrenom = Validator::make($request->all(), 
             [
                 'prenom' => 'required|min:4',
             ]);
             if ($validatePrenom->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre prénom minimum 4 caract^ères',
                     'errors' => $validatePrenom->errors()
                 ], 401);
             }
             //email
             $validateEmail = Validator::make($request->all(), 
             [
                 'email' =>'required|unique:gestionnaires',
             ]);
             if ($validateEmail->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre Email SVP',
                     'errors' => $validateEmail->errors()
                 ], 401);
             }
             //cni
              $validateCni= Validator::make($request->all(), 
              [
                  'cni' =>'required',
              ]);
              if ($validateCni->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'Veuillez entrer votre numero cni SVP',
                      'errors' => $validateCni->errors()
                  ], 401);
              }
              //ville 
             $validateVille = Validator::make($request->all(), 
             [
                 'ville' =>'required',
             ]);
             if ($validateVille->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre ville SVP',
                     'errors' => $validateVille->errors()
                 ], 401);
             }
             //commune_quartier 
              $validateCommune = Validator::make($request->all(), 
              [
                  'commune' =>'required',
              ]);
              if ($validateCommune->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'Veuillez entrer votre commune et quartier  SVP',
                     'errors' => $validateCommune->errors()
                  ], 401);
              }
              //actif
            
             $validateActif = Validator::make($request->all(), 
             [
                 'actif' =>'required',
             ]);
             if ($validateActif->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'est ce que vous etes actif',
                     'errors' => $validateActif->errors()
                 ], 401);
             }
             
         //step2 : ouverture de compte
             $User = User::create([
                 'phone' => $request->telephone,
             ]);
            
             $Gestionnaire = Gestionnaire::create([
                 'nom'        => $request->nom,
                 'prenom'     => $request->prenom,
                 'date_naissance' => $request->date_naissance,
                 'genre'      => $request->genre,
                 'telephone'  => $request->telephone,
                  'email'=> $request->email,
                  'cni'=>$request->cni,
                  'ville'=>$request->ville,
                  'commune'=>$request->commune,
                  'actif'=>$request->actif,
                 'domicile' => $request->domicile,
                 'id_users'   => $User->id
             ]);
         //step3 : generation de token
         return response()->json([
             'statusCode' => 200,
             'status'   => true,
             'message'  => 'compte Gestionnaire ouvert avec succès',
             'Gestionnaire'  =>$Gestionnaire,
             'token'   => $User->createToken("API TOKEN")->plainTextToken
         ], 200);
     } catch (\Throwable $th) {
         //throw $th;
         return response()->json([
             'statusCode' => 500,
             'status' => false,
             'message' => $th->getMessage()
         ], 500);
     }
   }
}

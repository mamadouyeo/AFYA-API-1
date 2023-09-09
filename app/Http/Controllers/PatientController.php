<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Laravel\Sanctum\HasApiTokens;
use Symfony\Contracts\Service\Attribute\Required;
class Patientcontroller extends Controller
{
    // use HasApiTokens, HasFactory, Notifiable;
    /**
    * --------------------
    * AUTHANTIFICATION
    * --------------------
    */

    //Inscription
    public function inscriptionPatient(Request $request)
    {
        try {
            /**
             * step 1 : Validation des données
             */
            //nom
            $validateNom = Validator::make(
                $request->all(),
                [
                'nom' => 'required|min:3',
          ]
            );
            if ($validateNom->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez entrer votre nom minimum 3 caract^ères',
                    'errors' => $validateNom->errors()
                ], 401);
            }
            //prenom
            $validatePrenom = Validator::make(
                $request->all(),
                [
                'prenom' => 'required|min:4',
          ]
            );
            if ($validatePrenom->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez entrer votre prénom minimum 4 caractères',
                    'errors' => $validatePrenom->errors()
                ], 401);
            }
            //date de naissance
            $validateDateNais = Validator::make(
                $request->all(),
                [
                'date_naissance' => 'required',
             ]
            );
            if ($validateDateNais->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez préciser votre date de naissance',
                    'errors' => $validateDateNais->errors()
                ], 401);
            }
            //genre

            $validateGenre = Validator::make(
                $request->all(),
                [
                'genre' => 'required',
             ]
            );
            if ($validateGenre->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez préciser votre genre',
                    'errors' => $validateGenre->errors()
                ], 401);
            }
            //Telephone
            $validateTel = Validator::make(
                $request->all(),
                [
                'telephone' => 'required|min:10|unique:patients',
             ]
            );
            if ($validateTel->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Numero de téléphone incorrecte ou existe déjà',
                    'errors' => $validateTel->errors()
                ], 401);
            }
            //Email
            $validateEmail = Validator::make(
                $request->all(),
                [
                'email' => 'required|min:10|unique:users',
              ]
            );
            if ($validateEmail->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'email incorrecte ou existe déjà',
                    'errors' => $validateEmail->errors()
                ], 401);
            }
            //Mot de passe
            $validatePass = Validator::make(
                $request->all(),
                [
                'password' => 'required|min:8',
             ]
            );
            if ($validatePass->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Mot de passe minimum 8 caractères',
                    'errors' => $validatePass->errors()
                ], 401);
            }
            //cni
            $validateCni = Validator::make(
                $request->all(),
                [
                'cni' => 'required',
              ]
            );
            if ($validateCni->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Numero cni incorrecte ou existe déjà',
                    'errors' => $validateCni->errors()
                ], 401);
            }
            //profession
            $validateProfession = Validator::make(
                $request->all(),
                [
                'profession' => 'required',
             ]
            );
            if ($validateProfession->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veillez rensegner votre profession',
                    'errors' => $validateProfession->errors()
                ], 401);
            }
            //ville
            $validateville = Validator::make(
                $request->all(),
                [
                'ville' => 'required',
             ]
            );
            if ($validateville->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'veillez rensegner la ville',
                    'errors' => $validateville->errors()
                ], 401);
            }
            //quartient ou commune
            $validatecommune_quartier = Validator::make(
                $request->all(),
                [
                'commune_quartier' => 'required',
              ]
            );
            if ($validatecommune_quartier->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'veillez rensegner la commune ou le quartier',
                    'errors' => $validatecommune_quartier->errors()
                ], 401);
            }

            //parrainage
            $validateparrainage = Validator::make(
                $request->all(),
                [
                'parrainage' => 'required',
                ]
            );
            if ($validateparrainage->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'veillez rensegner le parrainage',
                    'errors' => $validateparrainage->errors()
                ], 401);
            }
            //step2 : ouverture de compte
            $user = User::create([
                'telephone' => $request->telephone,
                'email' => $request->email,
            ]);
            
            $patient = Patient::create([
                'nom'        => $request->nom,
                'prenom'     => $request->prenom,
                'date_naissance' => $request->date_naissance,
                'genre'      => $request->genre,
                'telephone'  => $request->telephone,
                'email'      => $request ->email,
                'password' => Hash::make($request->password),
                'profession' => $request->profession,
                'cni'        => $request ->cni,
               'ville'       => $request ->ville,
               'commune_quartier' => $request ->commune_quartier,
               'parrainage' => $request->parrainage,
               'id_users'   => $user->id,
            ]);
            //step3 : generation de token
            return response()->json([
                'statusCode' => 200,
                'status'   => true,
                'message'  => 'compte patient ouvert avec succès',
                'patient'  => $patient,
                'token'   => $user->createToken("API TOKEN")->plainTextToken
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

    /**
     * *********************
     * connection du pateint
     ***********************
     */
   function loginPatient(Request $request)
   {
    //validation des données
    $valideClient = Validator::make($request->all(),[
        'tel' => 'required|min:10|max:10',
        'password' => 'required',
    ]);

    //verification des données
    $patient = Patient::where('telephone', $request->telephone)->first();

    if ($patient) 
    {
        // compare le mot de passe envoyer à celui de la base de donne
       if (hash::check($request->password, $patient->password)  ) 
       {
        //generation de token
        //$token = $patient->createToken("API TOKEN")->plainTextToken;
        return response()->json([
            'statuscode'=>200,
            'status'  => true,
            'message' => "connecté avec succès",
            'patient' => $patient,
            // 'token'   => $token,
        ], 200);

       }else {
        return response()->json([
            'statusCode' => 401,
            'status' => false,
            'message' => 'mode passe incorect',
            'errors' => $validateNom->errors()
        ], 401);
       }
    return 'hello';

    }else 
    {
        return response()->json([
            'statusCode' => 401,
            'status' => false,
            'message' => 'Veuillez verifier les informations',
            'patient' => $patient,
            'errors' => $validateNom->errors()
        ], 401);
    }
   }

           /**********************
            *  affichier un compte
            **********************/
        
    function getPatientCount(Request $request)
    {
       try {
            $user = Auth::user();
            $patient = Patient::Where('patient_id',$request->id);
            return response()->json([
                'statuscode'=>200,
                'status'  => true,
                'message' => "affichier le compte du patient",
                'user'    => $user,
                'patient' => $patient
            ], 200);
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            'statuscode'=>500,
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
       }
    }


            /**********************
            * mise ajour du compte
            **********************/

    function updatePatientCount(Request $request)
    {
        try {
            $res_telephone = USer::where('telephone',$request->tel)->first();
            $res_email = USer::where('email',$request->email)->first();
           
            if ($res_tel=='') {
                $validePatient = Validator::make($request->all(),[
                 'telephone' => 'min:10|max:10|unique:users'
                ]);
                if ($valideOffreur->fails()) {
                    return response()->json(['statuscode'=>'404',
                                             'status'=>'false',
                                             'message'=>'Erreur de validation',
                                             'data'=> '',
                                             'error'=> $valideOffreur->errors(),
                                            ],404);
                }
                User::where('id', Auth::id())->update(['telephone'=> $request->telephone]);
            }
            if ($res_email=='') {
                $validePatient = Validator::make($request->all(),[
                    'email' => 'email|unique:users'
                ]);
                if ($validePatient->fails()) {
                    return response()->json(['statuscode'=>'404',
                                             'status'=>'false',
                                             'message'=>'Erreur de validation',
                                             'data'=> '',
                                             'error'=> $validePatient->errors(),
                                            ],404);
                }
                User::where('id', Auth::id())->update(['email'=> $request->email]);
            }
          
            Patient::where('id', Auth::id())->update(['telephone'      => $request->telephone,
                                                   'password'  => Hash::make($request->password),
                                                 ]);
            Patient::where('users_id',Auth::id())->update(['nom' => $request->nom,
                                                            'prenom' => $request->prenom,
                                                            'genre' => $request->genre,
                                                            'telephone' => $request->telephone,
                                                            'email' => $request->email,
                                                            'password' => $request->password,
                                                            'password' => $request->password,
                                                            'profession' => $request->profession,
                                                            'ville' => $request->ville,
                                                           'cni' => $request->cni,
                                                           'commune_quartier' => $request->commune_quartier,
                                                           'parrainage' => $request->parrainage,
                                                          ]);                                        
            $user = User::firstWhere('id',Auth::id());
            $patient = Patient::firstWhere('users_id',Auth::id());                                         
            return response()->json(['statuscode'=>200,
                                     'status'  => true,
                                     'message' => "modifier le compte",
                                     'user'    => $user,
                                     'offreur' => $patient
                                   ], 200);                                                       
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'statuscode'=>500,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

   }

   

    
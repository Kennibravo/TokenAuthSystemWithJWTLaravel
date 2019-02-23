<?php

	namespace Workload\Http\Controllers;

    use Workload\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
		use Mail;
		use Workload\Mail\VerifyMail;
		use Workload\Mail\WelcomeMail;


    class UserController extends Controller
    {
        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                // 'name' => 'required|string|max:255',
                // 'email' => 'required|string|email|max:255|unique:users',
                // 'password' => 'required|string|min:6|confirmed',


                'sex' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'mobile' => 'digits_between:11,13',
                'role' => 'required|in:1,2',
                'specialization' => 'required_if:user_type,2',
                'state' => 'required|integer',
                'lga' => 'required|integer',
                //'state' => 'exists:states,id',
                //'lga' => 'exists:lgas,id',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ]);

            if($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->toJson()], 400);
            }

            $user = User::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'username' => $request->get('username'),
                'specialization' => $request->get('specialization'),
                'sex' => $request->get('sex'),
                'mobile' => $request->get('mobile'),
                'role' => $request->get('role'),
                'state' => $request->get('state'),
                'lga' => $request->get('lga'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

						Mail::to($user->email)->send(new VerifyMail($user));

            //return response()->json(compact('user','token'),201);
            return response()->json(['success' => 'User registered successfully'], 200);
        }

        public function getAuthenticatedUser()
            {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }

            public function logout(){
		        auth()->logout();
				return response()->json(['message' => 'Successfully logged out']);
    }

    }

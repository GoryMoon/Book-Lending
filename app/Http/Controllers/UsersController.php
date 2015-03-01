<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Support\Facades\Password;

class UsersController extends Controller {

	protected $user;

	protected $tokens;

	public function __construct(User $user, TokenRepositoryInterface $tokens)
	{
		$this->user = $user;
		$this->tokens = $tokens;
	}

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('users.index')->with('users', $this->user->where('userLvl', '>', '0')->get());
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if (!$this->user->isValid($input = $request->only('username', 'email', 'userLvl', 'passwordType'))) {
			return Redirect::back()->withInput()->withErrors($this->user->errors);
		}

		$user = new User;
		$user->username = $input['username'];
		$user->email = $input['email'];
		$user->userLvl = $input['userLvl'];

		$genPass = uniqid();
		if ($input['passwordType'] == '0') {
			$user->password = Hash::make($input['password']);
		} elseif ($input['passwordType'] == '1') {
			$user->password = Hash::make($genPass);
		} else {
			$user->password = $genPass;
		}

		$user->save();

		$token = null;
		if ($input['passwordType'] == '2') {
			$tokenUser = Password::getUser(array('email' => $user->email));
			$token = $this->tokens->create($tokenUser);
		}

		Mail::send('emails.welcome', array('user' => $user, 'password' => $genPass, 'passType' => $input['passwordType'], 'token' => $token), function ($message) use ($user)
		{
			$message->to($user->email);
			$message->subject('Välkommen');
		});

		return Redirect::route('admin.users.index');
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('users.edit')->with('user', $this->user->where('id', '=', $id)->firstOrFail());
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		if (!$this->user->isValid($input = $request->only('username', 'email', 'userLvl'), true)) {
			return Redirect::back()->withInput()->withErrors($this->user->errors);
		}

		$this->user->find($id)->update($input);

		return Redirect::route('admin.users.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = $this->user->find($id);
		$user->delete();
		return Redirect::route('admin.users.index');
	}

}
<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Order;
use App\Models\User;
use Exception;

class OrderController extends Controller
{
	public function index() {
		return view('orders.index');
	}

	public function show() {
		return view('orders.show');
	}

	public function create() {
		return view('orders.create');
	}

	public function back_create(Request $request) {
		$order = new Order();
		$order->company = $request->company;
		$order->client = $request->client;
		$order->email = $request->email;
		$order->question = $request->question;

		return view('orders.create')->with(['order' => $order]);
	}

	public function confirmation(Request $request) {
		$this->validate_order($request);

		$order = new Order();
		$order->company = $request->company;
		$order->client = $request->client;
		$order->email = $request->email;
		$order->question = $request->question;

		return view('orders.confirmation')->with(['order' => $order]);
	}

	public function store(Request $request) {
		$this->validate_order($request);

		DB::beginTransaction();

		try {
			$user = new User();
			$user->company = $request->company;
			$user->name = $request->client;
			$user->email = $request->email;
			$user->password = "password";
			$user->save();

			$user_id = $user->id;

			$order = new Order();
			$order->user_id = $user_id;
			$order->company = $request->company;
			$order->client = $request->client;
			$order->email = $request->email;
			$order->question = $request->question;
			$order->save();

			DB::commit();
		} catch(Exception $e) {
			DB::rollBack();
			return redirect()->route('errors.500');
		}

		return redirect()->route('orders.create')->with('success', 'お問い合わせを送信しました。');
	}

	public function validate_order(Request $request) {
		$validate_rule = [
			'client' => 'required',
			'email' => ['bail', 'required', 'string', 'email', 'unique:users, email'],
			'question' => 'required'
		];

		$validate_message = [
			'client.required' => '名前は必須項目です。',
			'email.required' => 'メールアドレスは必須項目です。',
			'email.unique' => '既に登録されているメールアドレスです。',
			'email.max' => 'メールアドレスが長すぎます。',
			'question.required' => 'お問い合わせ内容は必須項目です。'
		];

		$request->validate($validate_rule, $validate_message);
	}
}
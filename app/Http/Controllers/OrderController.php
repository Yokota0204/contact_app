<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
	public function index() {
		$orders = (new Order)->orderBy('id', 'desc')->simplePaginate(20);
		$orders = $this->processOrders($orders);

		$status_arr = status_array();
		$inputs_params = "";

		$params = [
			'orders' => $orders,
			'status_arr' => $status_arr,
			'inputs_params' => $inputs_params,
		];
		return view('orders.index', $params);
	}

	public function search(Request $request) {
		$orders = new Order;

		$search_start_date = $request->input('start_date');
		$search_end_date = $request->input('end_date');
		$search_status = $request->input('status');
		$search_company = $request->input('company');
		$search_client = $request->input('client');
		$search_email = $request->input('email');

		if (($request->has('start_date') && !empty($request->input('start_date'))) && ($request->has('end_date') && !empty($request->input('end_date')))) {
			$orders = $orders->dateAfter($search_start_date." 00:00:00")->dateBefore($search_end_date." 23:59:59");
		} elseif (!($request->has('start_date') && !empty($request->input('start_date'))) && ($request->has('end_date') && !empty($request->input('end_date')))) {
			$orders = $orders->dateBefore($search_end_date." 23:59:59");
		} elseif (($request->has('start_date') && !empty($request->input('start_date'))) && !($request->has('end_date') && !empty($request->input('end_date')))) {
			$today = date("Y-m-d")." 23:59:59";
			$orders = $orders->dateBefore($today)->dateAfter($search_start_date." 00:00:00");
		}

		if ($request->has('status') && !empty($request->input('status'))) {
			$orders = $orders->where('status', $search_status);
		}

		if ($request->has('company') && !empty($request->input('company'))) {
			$orders = $orders->where('company', 'LIKE', "%$search_company%");
		}

		if ($request->has('client') && !empty($request->input('client'))) {
			$orders = $orders->where('client', 'LIKE', "%$search_client%");
		}

		if ($request->has('email') && !empty($request->input('email'))) {
			$orders = $orders->where('email', 'LIKE', "%$search_email%");
		}

		$status_arr = status_array();

		$inputs = [
			'start_date' => $search_start_date,
			'end_date' => $search_end_date,
			'status' => $search_status,
			'company' => $search_company,
			'client' => $search_client,
			'email' => $search_email,
		];

		$inputs_params = http_build_query($inputs);

		$orders = $orders->orderBy('id', 'desc')->simplePaginate(20);
		$orders = $this->processOrders($orders);
		$params = [
			'orders' => $orders,
			'inputs' => $inputs,
			'status_arr' => $status_arr,
			'inputs_params' => $inputs_params,
		];

		return view('orders.index', $params);
	}

	public function show(Request $request, $id) {
		$order = Order::find($id);
		$emails = $order->emails()->orderBy('id', 'desc')->get();

		$status_arr = status_array();

		$search_start_date = $request->input('start_date');
		$search_end_date = $request->input('end_date');
		$search_status = $request->input('status');
		$search_company = $request->input('company');
		$search_client = $request->input('client');
		$search_email = $request->input('email');

		$inputs = [
			'start_date' => $search_start_date,
			'end_date' => $search_end_date,
			'status' => $search_status,
			'company' => $search_company,
			'client' => $search_client,
			'email' => $search_email,
		];

		$inputs_params = http_build_query($inputs);

		$data = [
			'order' => $order,
			'status_arr' => $status_arr,
			'inputs_params' => $inputs_params,
			'emails' => $emails,
		];
		return view('orders.show', $data);
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

	public function update(Request $request, $id) {
		DB::beginTransaction();

		try {
			$status = $request->input('status');

			$order = Order::find($id);
			$order->status = $status;
			$order->save();
		} catch (Exception $e) {
			DB::rollBack();
			Log::info($e);
		}

		DB::commit();

		return redirect('/admin/orders/'.$id)->with(['success' => 'ステータスを更新しました。']);
	}

	public function validate_order(Request $request) {
		$validate_rule = [
			'client' => 'required',
			'email' => ['bail', 'required', 'string', 'email', 'unique:users,email'],
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

	function processOrders($orders) {
		foreach ($orders as $order) {
			$order->created_at_string = datetimeDisplay($order->created_at);
		}
		return $orders;
	}
}

function status_array() {
	return [
		'1' => ['val' => '1', 'label' => '未開封'],
		'2' => ['val' => '2', 'label' => '未対応'],
		'3' => ['val' => '3', 'label' => '対応中（未返信）'],
		'4' => ['val' => '4', 'label' => '保留中（返信済み）'],
		'5' => ['val' => '5', 'label' => '対応中（返信済み）'],
		'99' => ['val' => '99', 'label' => '対応済み'],
	];
}

function datetimeDisplay(string $datetime) {
	$carbon = new Carbon($datetime);
	return $carbon->format('Y/m/d H:i');
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

use App\Models\Admin;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
	public function index() {
		$orders = new Order;
		$admin = Auth::user();

		if ($admin->role == "3") {
			$orders = $orders->where('in_charge', $admin->uid);
		}
		$orders = $orders->orderBy('id', 'desc')->simplePaginate(20);

		$inputs_params = "";

		$params = [
			'orders' => $orders,
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

		$admin = Auth::user();

		if ($admin->role == "3") {
			$orders = $orders->where('in_charge', $admin->uid);
		}

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

		$orders = $orders->orderBy('id', 'desc')->simplePaginate(20);

		$inputs = [
			'start_date' => $search_start_date,
			'end_date' => $search_end_date,
			'status' => $search_status,
			'company' => $search_company,
			'client' => $search_client,
			'email' => $search_email,
		];

		$inputs_params = http_build_query($inputs);

		$params = [
			'orders' => $orders,
			'inputs' => $inputs,
			'inputs_params' => $inputs_params,
		];

		return view('orders.index', $params);
	}

	public function show(Request $request, $id) {
		$admin = Auth::user();
		$order = Order::find($id);

		if ($order == null || ($admin->role == "3" && $order->in_charge != $admin->uid)) {
			return redirect()->route('admin.orders.index');
		}

		$emails = $order->emails()->orderBy('id', 'desc')->get();
		$users = Admin::get();

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
			'inputs_params' => $inputs_params,
			'emails' => $emails,
			'users' => $users,
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
			$order = new Order();
			$order->company = $request->company;
			$order->client = $request->client;
			$order->email = $request->email;
			$order->question = $request->question;
			$order->save();

			$carbon = new Carbon($order->created_at);
			$order->created_at_display = $carbon->format('Y/m/d H:i');
			$order->save();

			DB::commit();
		} catch(Exception $e) {
			DB::rollBack();
			return redirect()->route('errors.500');
		}

		return redirect()->route('orders.create')->with('success', 'お問い合わせを送信しました。');
	}

	public function update_status(Request $request) {
		DB::beginTransaction();

		try {
			$id = $request->input('id');
			$status = $request->input('status');

			$order = Order::find($id);
			$order->status = $status;
			$order->save();

			DB::commit();

			return redirect()
				->route('admin.orders.show', ['id' => $id])
				->with(['success' => 'ステータスを更新しました。']);
		} catch (Exception $e) {
			DB::rollBack();
			Log::error($e);

			return redirect()
				->route('admin.orders.show', ['id' => $id])
				->withInput()
				->withErrors(['message' => 'ステータスの更新に失敗しました。']);
		}
	}

	public function update_in_charge(Request $request) {
		DB::beginTransaction();

		try {
			$id = $request->input('id');
			$in_charge = $request->input('in_charge');

			$order = Order::find($id);
			$order->in_charge = $in_charge;
			$order->save();

			DB::commit();

			return redirect()
				->route('admin.orders.show', ['id' => $id])
				->with(['success' => '担当者を更新しました。']);
		} catch (Exception $e) {
			DB::rollBack();
			Log::error($e);

			return redirect()
				->route('admin.orders.show', ['id' => $id])
				->withInput()
				->withErrors(['message' => '担当者の更新に失敗しました。']);
		}
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
}
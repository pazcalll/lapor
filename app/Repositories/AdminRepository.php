<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Assignment;
use App\Models\Facility;
use App\Models\Report;
use App\Models\User;
use App\Models\UserAddressDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AdminRepository extends UsersRepository
{
	public function getUnacceptedReports()
	{
		$data = Report::with(['reportFile', 'reportLocation'])->where('status', 'MENUNGGU')->get();
		return $data;
	}

	public function getOfficers()
	{
		$data = User::where('role', 'officer')->get();
		return $data;
	}

	public function processReport()
	{
		try {
			DB::beginTransaction();
			$reportData = [
				'referral' => request()->post('referral')
			];
			$report = Report::where('referral', $reportData['referral'])->where('status', "MENUNGGU")->first()->toArray();
			if (count($report) == 0) {
				return response()->json(['error' => "Data sudah diproses"], 400);
			}
			// dd($report);
			$data = [
				'user_id' => request()->post('officer'),
				'report_id' => $report['id'],
				'additional' => request()->post('additional')
			];
			$reportUpdate = Report::where('referral', $reportData['referral'])->update(['status' => 'DIPROSES']);
			$assignment = Assignment::create($data);
			DB::commit();
		} catch (\Exception $th) {
			DB::rollback();
			return response()->json(['error' => $th], 400);
		}
	}

	public function getAcceptedReports()
	{
		// $report = Report::where('status', 'DIPROSES')->get()->toArray();
		$report = Report::with([
			"assignment" => function ($query) {
				return $query->select('id', 'user_id', 'report_id', 'additional', 'created_at');
			},
			"assignment.officer" => function ($query) {
				return $query->select('id', 'name', 'role');
			},
			"reporter" => function ($query) {
				return $query->select('id', 'name', 'role');
			},
			"facility" => function ($query) {
				return $query->select('id', 'name');
			},
			"reportFile" => function ($query) {
				return $query->select('report_id', 'proof_file');
			},
			"reportLocation" => function ($query) {
				return $query->select('report_id', 'street', 'rt', 'rw', 'village', 'sub_district');
			}
		])->select('id', 'referral', 'facility_id', 'user_id', 'issue')->where('status', "DIPROSES")->get()->toArray();
		return $report;
	}

	public function getFinishedReports()
	{
		// $report = Report::where('status', 'DIPROSES')->get()->toArray();
		$report = Report::with([
			"assignment" => function ($query) {
				return $query->select('id', 'user_id', 'report_id', 'additional', 'created_at', 'finished_at', 'file_finish');
			},
			"assignment.officer" => function ($query) {
				return $query->select('id', 'name', 'role');
			},
			"reporter" => function ($query) {
				return $query->select('id', 'name', 'role');
			},
			"facility" => function ($query) {
				return $query->select('id', 'name');
			}
		])->select('id', 'referral', 'facility_id', 'user_id', 'location', 'issue', 'proof_file')->where('status', "SELESAI")->get()->toArray();
		return $report;
	}

	public function getNonAdminUsers()
	{
		$users = User::where('role', '!=', 'admin')->get();
		return $users;
	}

	public function getEnumUser()
	{
		$type = DB::table('information_schema.columns')
			->select('column_type')
			->where('table_schema', 'lapor')
			->where('table_name', 'users')
			->where('column_name', 'role')
			->first();
		$enum = [];
		$flag = 0;
		$newWord = "";
		for ($i = 0; $i < strlen($type->COLUMN_TYPE); $i++) {
			if ($flag == 0 && $type->COLUMN_TYPE[$i] == "'") {
				$flag = 1;
			} else if ($type->COLUMN_TYPE[$i] == "'" && $flag == 1) {
				$enum[] = $newWord;
				$newWord = "";
				$flag = 0;
			} else if ($flag == 1) {
				$newWord = $newWord . $type->COLUMN_TYPE[$i];
			}
		}
		return $enum;
	}

	public function editUser()
	{
		User::where('username', request()->post('username'))->update([
			"role" => request()->post('role')
		]);
	}

	public function getFacilitiesDatatable()
	{
		$data = Facility::select('id', 'name', 'created_at', 'updated_at')->get();
		return $data;
	}

	public function createFacility()
	{
		$create = Facility::create([
			'name' => request()->post('name')
		]);
		return $create;
	}

	public function editFacility()
	{
		try {
			DB::beginTransaction();

			$validate = request()->validate([
				'name_old' => 'required',
				'name_new' => 'required',
			], [
				'required' => 'Semua field wajib diisi'
			]);
			$edit = Facility::where("name", $validate['name_old'])->update([
				"name" => $validate['name_new']
			]);

			DB::commit();
			return $edit;
		} catch (\Exception $th) {
			return response()->json(["error" => $th], 400);
		}
	}

	public function deleteFacility()
	{
		try {
			DB::beginTransaction();

			$validate = request()->validate([
				'name_delete' => 'required',
			], [
				'required' => 'Semua field wajib diisi'
			]);
			$edit = Facility::where("name", $validate['name_delete'])->delete();

			DB::commit();
			return $edit;
		} catch (\Exception $th) {
			return response()->json(["error" => $th], 400);
		}
	}

	public function createOpd()
	{
		try {
			DB::beginTransaction();
			$validate = request()->validate([
				'username' => 'required|unique',
				'name' => 'required',
				'password' => 'required',
				'rt' => 'nullable',
				'rw' => 'nullable',
				'street' => 'nullable',
				'village' => 'nullable',
				'sub_district' => 'nullable',
				'phone' => 'required',
			], [
				'required' => 'Semua field dengan tanda bintang wajib diisi',
				'username.unique' => 'Username tidak boleh ada yang sama'
			]);
			$newOpd = User::create([
				'username' => $validate['username'],
				'name' => $validate['name'],
				'password' => Hash::make($validate['password']),
				'role' => 'officer',
				'phone' => $validate['phone']
			]);
			$opdAddressDetail = UserAddressDetail::create([
				'street' => $validate['street'],
				'village' => $validate['village'],
				'rt' => $validate['rt'],
				'rw' => $validate['rw'],
				'sub_district' => $validate['sub_district'],
				'user_id' => $newOpd->id,
			]);

			DB::commit();
			return $newOpd;
		} catch (Exception $th) {
			return response()->json($th, 400);
		}
	}

	public function registerCustomer()
	{
		// dd(request()->all());
		$validator = Validator::make(request()->all(), [
			'username' => 'required|unique:users',
			'password' => 'required|max:16',
			'name' => 'required',
			'phone' => 'required',
			'rt' => 'nullable',
			'rw' => 'nullable',
			'village' => 'nullable',
			'sub_district' => 'nullable',
			'street' => 'nullable',
			'appointment_letter' => 'required|file|max:2048'
		]);

		// dd($validator->errors()->all());
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}
		try {
			DB::beginTransaction();
			$validator = $validator->validate();

			$filename = time() . '_' . $validator['appointment_letter']->getClientOriginalName();
			$validator['appointment_letter']->storeAs('public/appointment_letter', $filename);
			$newCustomer = User::create([
				'name' => $validator['name'],
				'username' => $validator['username'],
				'password' => Hash::make($validator['password']),
				'phone' => $validator['phone'],
				'role' => 'customer',
				'appointment_letter' => $filename,
			]);

			$customerAddress = UserAddressDetail::create([
				'street' => $validator['street'],
				'rt' => $validator['rt'],
				'rw' => $validator['rw'],
				'village' => $validator['village'],
				'sub_district' => $validator['sub_district'],
				'user_id' => $newCustomer->id
			]);

			DB::commit();
			return response()->json($newCustomer, 200);
		} catch (Exception $th) {
			return response()->json(['error' => $th->getMessage()], 400);
		}
	}

	public function rejectReport()
	{
		$validator = Validator::make(request()->all(), [
			'referral' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}
		$validator = $validator->validate();
		try {
			$reject = Report::where('referral', $validator['referral'])->update([
				'status' => 'DITOLAK'
			]);
			return response()->json($reject, 200);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], 400);
		}
	}
}
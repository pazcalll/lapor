<?php

namespace App\Repositories;

use App\Exports\FinishedReportsExport;
use App\Interfaces\UserInterface;
use App\Models\Assignment;
use App\Models\BearerDuration;
use App\Models\CustomerPosition;
use App\Models\Facility;
use App\Models\Report;
use App\Models\ReportLocation;
use App\Models\User;
use App\Models\UserAddressDetail;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Maatwebsite\Excel\Facades\Excel;

class AdminRepository extends UsersRepository
{
	public function getUnacceptedReports()
	{
		$data = Report::with([
			'reportFile' => function ($query) {
				return $query->select('proof_file', 'report_id');
			},
			'reportLocation' => function ($query) {
				return $query->select('street', 'rt', 'rw', 'sub_district', 'village', 'report_id');
			},
			"reporter" => function ($query) {
				return $query->select('id', 'name', 'role');
			},
			"facility" => function ($query) {
				return $query->select('id', 'name');
			},
		])->where('status', 'MENUNGGU DIVERIFIKASI')->get();
		return $data;
	}

	public function getOpds()
	{
		$data = User::where('role', 'opd')->get();
		return $data;
	}

	public function processReport()
	{
		// return response()->json(['error' => request()->all()], 400);
		$validator = Validator::make(request()->all(), [
			'referral' => ['required', 'exists:reports,referral'],
			'additional' => 'nullable',
			'deadline_at' => ['required', 'date'],
			'opd' => [
				'required',
				Rule::exists('users', 'id')->where('role', 'opd'),
			]
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}

		$validator = $validator->validated();

		try {
			DB::beginTransaction();
			$reportData = [
				'referral' => request()->post('referral')
			];
			$report = Report::where('referral', $reportData['referral'])->where('status', "MENUNGGU DIVERIFIKASI")->first()->toArray();
			if (count($report) == 0) {
				return response()->json(['error' => "Data sudah diproses"], 400);
			}
			// dd($report);
			$data = [
				'user_id' => request()->post('opd'),
				'report_id' => $report['id'],
				'additional' => request()->post('additional')
			];
			$reportUpdate = Report::where('referral', $reportData['referral'])->update([
				'status' => 'SEDANG DIPROSES',
				'deadline_at' => $validator['deadline_at']
			]);
			$assignment = Assignment::create($data);
			DB::commit();
		} catch (\Exception $th) {
			DB::rollback();
			return response()->json(['error' => $th], 400);
		}
	}

	public function getAcceptedReports()
	{
		// $report = Report::where('status', 'SEDANG DIPROSES')->get()->toArray();
		$report = Report::with([
			"assignment" => function ($query) {
				return $query->select('id', 'user_id', 'report_id', 'additional', 'created_at');
			},
			"assignment.opd" => function ($query) {
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
		])->select('id', 'referral', 'deadline_at', 'facility_id', 'user_id', 'issue')->where('status', "SEDANG DIPROSES")->get()->toArray();
		return $report;
	}

	public function getFinishedReports()
	{
		// $report = Report::where('status', 'SEDANG DIPROSES')->get()->toArray();
		$report = Report::with([
			"assignment" => function ($query) {
				return $query->select('id', 'user_id', 'report_id', 'additional', 'created_at', 'finished_at', 'file_finish');
			},
			"assignment.opd" => function ($query) {
				return $query->select('id', 'name', 'role');
			},
			"reporter" => function ($query) {
				return $query->select('id', 'name', 'role');
			},
			"facility" => function ($query) {
				return $query->select('id', 'name');
			},
			"reportLocation" => function ($query) {
				return $query->select('street', 'rt', 'rw', 'sub_district', 'village', 'report_id');
			},
			"reportFile" => function ($query) {
				return $query->select('report_id', 'proof_file');
			},
			"feedback" => function ($query) {
				return $query->select('report_id', 'feedback', 'rating');
			}
		])->select('id', 'referral', 'facility_id', 'user_id', 'issue', 'status', 'created_at')->where('status', "LAPORAN TELAH SELESAI")->get()->toArray();
		return $report;
	}

	public function getNonAdminUsers()
	{
		$users = User::with(['userAddressDetail', 'customerPosition', 'bearerDuration'])->whereNotIn('role', ['admin', 'regent'])->get();
		return $users;
	}

	public function getEnumUser()
	{
		$type = DB::table('information_schema.columns')
			->select('column_type')
			->where('table_schema', env('DB_DATABASE'))
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

	public function updateCustomer()
	{
		// dd(request()->all());
		$validator = Validator::make(request()->all(), [
			"id" => [
				'required',
				'exists:users,id',
				function ($attribute, $value, $fail) {
					$user = User::find(request()->id);
					if ($user->role != 'customer') {
						$fail('Invalid Role');
					}
				}
			],
			"name" => ['required', 'min:4', 'max:64'],
			"username" => ['required', 'max:16'],
			"password" => ['nullable', 'confirmed', 'min:6', 'max:32'],
			"gender" => 'required',
			"year_start" => 'required',
			"year_end" => 'required',
			"appointment_letter" => ['nullable', 'file', 'max:2048'],

			"phone" => ['required'],
			"street" => ['required'],
			"rt" => 'required',
			"rw" => 'required',
			"village" => 'required',
			"sub_district" => 'required',
			"phone" => 'required',
		], [
			'required' => 'Semua field dengan tanda bintang wajib diisi'
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}

		try {
			DB::beginTransaction();

			$validator = $validator->validated();
			$editData = User::where('username', $validator['username'])->first();
			$originalData = User::where('id', $validator['id'])->first();
			// dd(Auth::user());
			if ($editData != null && $editData->username != $originalData->username) {
				return response()->json(['errors' => ['username sudah dipakai']], 400);
			}
			$userData = [
				"name" => $validator['name'],
				"username" => $validator['username'],
				"password" => $validator['password'],
				"phone" => $validator['phone']
			];
			$userDataDetail = [
				"street" => $validator['street'],
				"rt" => $validator['rt'],
				"rw" => $validator['rw'],
				"village" => $validator['village'],
				"sub_district" => $validator['sub_district']
			];

			if (!isset($userData['password'])) {
				unset($userData['password']);
			}
			if (isset($validator['appointment_letter'])) {
				// unset($userData['appointment_letter']);
				// $appointment_letter = User::where('id', request()->post('id'))->select('id', 'appointment_letter')->first();
				$filename = time() . '_' . $validator['appointment_letter']->getClientOriginalName();
				// Storage::delete('public/appointment_letter/' . $appointment_letter->appointment_letter);
				Storage::put('public/appointment_letter/' . $filename, file_get_contents(request()->file('appointment_letter')));
				User::where('id', $validator['id'])->update([
					'appointment_letter' => $filename
				]);
			}

			User::where('id', request()->post('id'))->update($userData);
			UserAddressDetail::where('user_id', request()->post('id'))->update($userDataDetail);
			if ($editData->role == User::ROLE_CUSTOMER) {
				BearerDuration::where('customer_id', $editData->id)->update([
					'year_start' => $validator['year_start'],
					'year_end' => $validator['year_end']
				]);
			}
			DB::commit();
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()], 400);
		}
	}

	public function updateOpd()
	{
		// dd(request()->post());
		$validator = Validator::make(request()->all(), [
			'id' => [
				'required',
				function ($attribute, $value, $fail) {
					$user = User::find(request()->id);
					if ($user->role != 'opd') {
						$fail('Invalid Role');
					}
				}
			],
			'name' => ['required', 'min:4', 'max:64'],
			'username' => ['required', 'max:16'],
			'password' => ['nullable', 'confirmed', 'min:6', 'max:32'],
			'phone' => ['required'],
			'street' => ['required'],
			'rt' => 'required',
			'rw' => 'required',
			'village' => 'required',
			'sub_district' => 'required',
			'phone' => 'required',
		], [
			'required' => 'Semua field dengan tanda bintang wajib diisi'
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}

		try {
			DB::beginTransaction();

			$validator = $validator->validated();
			$editData = User::where('username', $validator['username'])->first();
			$originalData = User::where('id', $validator['id'])->first();

			if ($editData != null && $editData->username != $originalData->username) {
				return response()->json(['errors' => ['username sudah dipakai']], 400);
			}
			$userData = [
				"name" => $validator['name'],
				"username" => $validator['username'],
				"password" => $validator['password'],
				"phone" => $validator['phone']
			];
			$userDataDetail = [
				"street" => $validator['street'],
				"rt" => $validator['rt'],
				"rw" => $validator['rw'],
				"village" => $validator['village'],
				"sub_district" => $validator['sub_district']
			];

			if (!isset($userData['password'])) {
				unset($userData['password']);
			}

			User::where('id', request()->post('id'))->update($userData);
			UserAddressDetail::where('user_id', request()->post('id'))->update($userDataDetail);
			DB::commit();
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()], 400);
		}
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
				'username' => 'required|unique:users',
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
				'role' => 'opd',
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
			return response()->json(["errors" => $th->getMessage()], 400);
		}
	}

	public function registerCustomer()
	{
		$validator = Validator::make(request()->all(), [
			'username' => 'required|unique:users',
			'password' => 'required|max:16',
			'name' => 'required',
			'gender' => 'required',
			'year_start' => 'required',
			'year_end' => 'required',
			'customer_position' => ['required', Rule::in(CustomerPosition::POSITION)],
			'phone' => 'required',
			'rt' => 'required',
			'rw' => 'required',
			'village' => 'required',
			'sub_district' => 'required',
			'street' => 'required',
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

			$customerPeriod = BearerDuration::create([
				'customer_id' => $newCustomer->id,
				'year_start' => $validator['year_start'],
				'year_end' => $validator['year_end']
			]);

			$customerAddress = UserAddressDetail::create([
				'street' => $validator['street'],
				'rt' => $validator['rt'],
				'rw' => $validator['rw'],
				'village' => $validator['village'],
				'sub_district' => $validator['sub_district'],
				'user_id' => $newCustomer->id
			]);

			$customerPosition = CustomerPosition::create([
				'customer_id' => $newCustomer->id,
				'position' => $validator['customer_position']
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

	public function editReport()
	{
		$validator = Validator::make(request()->all(), [
			'referral' => ['required', 'exists:reports,referral'],
			'rt' => 'required|max:2',
			'rw' => 'required|max:2',
			'village' => 'required',
			'sub_district' => 'required',
			'street' => 'required',
			'issue' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}
		$validator = $validator->validate();

		try {
			DB::beginTransaction();
			$edit = Report::leftJoin('report_locations as rl', 'rl.id', '=', 'reports.id')
				->where('referral', $validator['referral'])
				->update([
					'reports.issue' => $validator['issue'],
					'rl.street' => $validator['street'],
					'rl.rt' => $validator['rt'],
					'rl.rw' => $validator['rw'],
					'rl.village' => $validator['village'],
					'rl.sub_district' => $validator['sub_district']
				]);
			DB::commit();
			return response()->json($edit, 200);
		} catch (\Throwable $th) {
			//throw $th;
			return response()->json(['errors' => $th->getMessage()], 400);
		}
	}

	public function changeUserStatus()
	{
		$validator = Validator::make(request()->all(), [
			'status' => ['required', Rule::in(User::ACCOUNT_STATUS_ACTIVE, User::ACCOUNT_STATUS_INACTIVE)],
			'id' => ['required', 'exists:users,id']
		], [
			'required' => 'Semua field wajib diisi'
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}
		$validator = $validator->validate();

		$user = User::find($validator['id'])->update([
			'status' => $validator['status']
		]);

		return response([$validator, $user], 200);
	}

	public function getFinishedReportsExcel()
	{
		return Excel::download(new FinishedReportsExport, 'laporan selesai.xlsx');
	}

	public function changeAssignmentOpd()
	{
		request()->validate([
			'opd_id' => ['required', 'exists:users,id', Rule::prohibitedIf(User::find(request()->opd_id)->role != 'opd')],
			'referral' => ['required']
		]);

		return Assignment::whereHas('report', fn ($query) => $query->where('referral', request()->referral))
			->update([
				'user_id' => request()->opd_id
			]);
	}

	public function summary()
	{
		$opd = request()->get('opd') ?? null;

		$incomingReport = Report::where('status', 'MENUNGGU DIVERIFIKASI')->count();

		$processReport = Report::when($opd != 0, function ($q) use ($opd) {
			return $q->whereHas('assignment', function ($query) use ($opd) {
				$query->where('user_id', $opd);
			});
		})
			->where('status', 'SEDANG DIPROSES')
			->count();

		$finishedReport = Report::when($opd != 0, function ($q) use ($opd) {
			return $q->whereHas('assignment', function ($query) use ($opd) {
				$query->where('user_id', $opd);
			});
		})
			->where('status', 'LAPORAN TELAH SELESAI')
			->count();

		$summary = [
			[
				'title' => 'Laporan Masuk',
				'shortDesc' => 'Laporan yang belum ditangani',
				'number' => $incomingReport,
				'meterialIcon' => 'zmdi-case-download',
				'iconColor' => '#c2c2c2'
			],
			[
				'title' => 'Laporan Sedang Diproses',
				'shortDesc' => 'Laporan yang sedang diproses',
				'number' => $processReport,
				'meterialIcon' => 'zmdi-case-play',
				'iconColor' => '#ffae00'
			],
			[
				'title' => 'Laporan Selesai',
				'shortDesc' => 'Laporan yang sudah ditangani',
				'number' => $finishedReport,
				'meterialIcon' => 'zmdi-case-check',
				'iconColor' => '#70c24a'
			],
		];
		return response()->json(['data' => $summary]);
	}

	public function yearlyReport()
	{
		$report = Report::when(request()->year,
				fn ($q) => $q->whereYear('created_at', request()->year)
			)
			->when(request()->facility_id, 
				fn($q) => $q->where('facility_id', request()->facility_id)
			)
			->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(id) as count'))
			->groupBy('month')
			->orderBy('month')
			->get();

		return $report;
	}

	function waStoreReport() {
		// $validate = request()->validate([
		// 	'username' => ['required', 'exists:users,username'],
		// 	'facility_id' => ['required', 'exists:facilities,id'],
		// 	'rt' => 'required',
		// 	'rw' => 'required',
		// 	'street' => 'required',
		// 	'village' => 'required',
		// 	'sub_district' => 'required',
		// 	'issue' => 'required'
		// ], [
		// 	'required' => 'Semua atribut wajib diisi'
		// ]);

		// $user = User::where('username', $validate['username'])->first();
		// $referral = createReferral();

		// $report = Report::create([
		// 	'referral' => $referral,
		// 	'facility_id' => $validate['facility_id'],
		// 	'user_id' => $user->id,
		// 	'issue' => $validate['issue'],
		// 	'status' => Report::STATUS_WAITING
		// ]);

		// $reportLocation = ReportLocation::create([
		// 	'street' => $validate['street'],
		// 	'village' => $validate['village'],
		// 	'sub_district' => $validate['sub_district'],
		// 	'rt' => $validate['rt'],
		// 	'rw' => $validate['rw'],
		// 	'report_id' => $report->id
		// ]);

		// return [$report, $reportLocation];

		$stringData = request()->pesan;
		$arrayData = explode('#', $stringData);

		$data = [];
		foreach ($arrayData as $element) {
            $parts = explode(':', $element);

			$name = $parts[0];
            $value = $parts[1];

            $data[$name] = $value;
        }

		$shouldExistKeys = [
			'username',
			'facility_id',
			'rt',
			'rw',
			'street',
			'village',
			'sub_district',
			'issue'
		];

		// --------- validate if not all required keys were exist -------------
		$difference = array_diff(array_keys($data), $shouldExistKeys);

		if ($difference) {
			$messageData = '';
			foreach ($difference as $key => $value) {
				(($key + 1) == count($difference)) ? $messageData = $messageData.$value : $messageData = $messageData.$value.', ';
			}

			throw new Exception("$messageData is not set");
		}
		// ---------------------------------------------------------------------

		$user = User::where('username', $data['username'])->first();
		$referral = strtoupper(bin2hex(random_bytes(6)));

		$report = Report::create([
			'referral' => $referral,
			'facility_id' => $data['facility_id'],
			'user_id' => $user->id,
			'issue' => $data['issue'],
			'status' => Report::STATUS_WAITING
		]);

		$reportLocation = ReportLocation::create([
			'street' => $data['street'],
			'village' => $data['village'],
			'sub_district' => $data['sub_district'],
			'rt' => $data['rt'],
			'rw' => $data['rw'],
			'report_id' => $report->id
		]);

		return [$report, $reportLocation];
	}

	public function waShowReport($referral) {
		return Report::with('facility')
			->where('referral', $referral)
			->first();
	}
}

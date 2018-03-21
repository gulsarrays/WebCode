<?php

namespace App\Http\Controllers\Others;

use Illuminate\Routing\Controller;
use DB;
use Illuminate\Http\Request;
//use Excel;

class AuditController extends Controller {

    public function getAllAudits(Request $request) {
        $allAudits = DB::table('audits')
                        ->leftjoin('users_admin', 'audits.user_id', 'users_admin.id')
                        ->select('audits.*', 'users_admin.username')
                        ->orderBy('audits.id', 'desc')->get();

        return view('bushfire.audits', compact('allAudits'));
    }

    public function getAllAuditsAjax(Request $request) {

        $columns = array(
            0 => 'id',
            1 => 'username',
            2 => 'auditable_type',
            3 => 'event',
            4 => 'old_values',
            5 => 'new_values',
            6 => 'updated_at',
        );

        $dataInitial = DB::table('audits')
                        ->leftjoin('users_admin', 'audits.user_id', 'users_admin.id')
                        ->select('audits.*', 'users_admin.username')
                        ->orderBy('audits.id', 'desc')
                        ->get()->toArray();

        $totalData = count($dataInitial);
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        if($limit == '-1') {
           $limit =  $totalFiltered;
        }
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $userData = DB::table('audits')
                    ->leftjoin('users_admin', 'audits.user_id', 'users_admin.id')
                    ->select('audits.*', 'users_admin.username')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $userData = DB::table('audits')
                    ->leftjoin('users_admin', 'audits.user_id', 'users_admin.id')
                    ->select('audits.*', 'users_admin.username')
                    ->Where(function($query) use ($search) {
                        $query->orWhere('users_admin.username', 'LIKE', "%{$search}%")
                        ->orWhere('audits.auditable_type', 'LIKE', "%{$search}%")
                        ->orWhere('audits.event', 'LIKE', "%{$search}%")
                        ->orWhere('audits.old_values', 'LIKE', "%{$search}%")
                        ->orWhere('audits.new_values', 'LIKE', "%{$search}%")
                        ->orWhere('audits.updated_at', 'LIKE', "%{$search}%");
                    })->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            $totalFiltered = DB::table('audits')
                    ->leftjoin('users_admin', 'audits.user_id', 'users_admin.id')
                    ->select('audits.*', 'users_admin.username')
                    ->Where(function($query) use ($search) {
                        $query->orWhere('users_admin.username', 'LIKE', "%{$search}%")
                        ->orWhere('audits.auditable_type', 'LIKE', "%{$search}%")
                        ->orWhere('audits.event', 'LIKE', "%{$search}%")
                        ->orWhere('audits.old_values', 'LIKE', "%{$search}%")
                        ->orWhere('audits.new_values', 'LIKE', "%{$search}%")
                        ->orWhere('audits.updated_at', 'LIKE', "%{$search}%");
                    })
                    ->count();
        }

        $data = array();
        if (!empty($userData)) {
            $srno = $start;
            if ($order === 'id' && $dir === 'asc') {
                $srno = ($totalData + 1) - $start;
            }
            foreach ($userData as $tmpUserData) {

                if ($order === 'id' && $dir === 'asc') {
                    $srno--;
                } else {
                    $srno++;
                }
                $nestedData['id'] = $srno;
                $nestedData['username'] = $tmpUserData->username;
                $nestedData['auditable_type'] = $tmpUserData->auditable_type;
                $nestedData['event'] = $tmpUserData->event;
                $nestedData['updated_at'] = $tmpUserData->updated_at;

                $str_old_values = null;
                $old_values = json_decode($tmpUserData->old_values, true);
                foreach ($old_values as $key => $value) {
                    if ($key != 'deleted_at' && $key != 'password') {
                        if ($key == 'is_active') {
                            $str_old_values .= "Status  :  " . (($value == 1) ? 'Active' . "<br/>" : 'InActive') . "<br/>";
                        } else {
                            $str_old_values .= (($key != 'password' && $key != 'id' && $key != 'user_type') ? $key . " : " . $value . "<br/>" : "");
                        }
                    }
                }
                $nestedData['str_old_values'] = $str_old_values;

                $str_new_values = null;
                $new_values = json_decode($tmpUserData->new_values, true);
                foreach ($new_values as $key => $value) {
                    if ($key == 'is_active') {
                        $str_new_values .= "Status  :  " . (($value == 1) ? 'Active' . "<br/>" : 'InActive') . "<br/>";
                    } else {
                        $str_new_values .= (($key != 'password' && $key != 'id' && $key != 'user_type') ? $key . " : " . $value . "<br/>" : "");
                    }
                }
                $nestedData['str_new_values'] = $str_new_values;


                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "limit" => $limit,
            "start" => $start,
            "order" => $order,
            "dir" => $dir,
            "search" => (!empty($search) ? $search : null)
        );

        echo json_encode($json_data);
    }

    public function downloadAuditsCsvExcel($type) {

        $data[] = array("Sr No", "Change By", "Module", "Event", "Old values", "New values", "Modified Timings");

        $userData = DB::table('audits')
                ->leftjoin('users_admin', 'audits.user_id', 'users_admin.id')
                ->select('audits.*', 'users_admin.username')
                ->orderBy('audits.id', 'desc')
                ->get();
        $srno = 0;
        foreach ($userData as $tmpUserData) {
            $srno++;
            $str_old_values = null;
            $old_values = json_decode($tmpUserData->old_values, true);
            foreach ($old_values as $key => $value) {
                if ($key != 'deleted_at' && $key != 'password') {
                    if ($key == 'is_active') {
                        $str_old_values .= "Status  :  " . (($value == 1) ? 'Active' . "\r\n" : 'InActive') . "\r\n";
                    } else {
                        $str_old_values .= (($key != 'password' && $key != 'id' && $key != 'user_type') ? $key . " : " . $value . "\r\n" : "");
                    }
                }
            }
            $str_old_values = substr($str_old_values, 0, -2);

            $str_new_values = null;
            $new_values = json_decode($tmpUserData->new_values, true);
            foreach ($new_values as $key => $value) {
                if ($key == 'is_active') {
                    $str_new_values .= "Status  :  " . (($value == 1) ? 'Active' . "\r\n" : 'InActive') . "\r\n";
                } else {
                    $str_new_values .= (($key != 'password' && $key != 'id' && $key != 'user_type') ? $key . " : " . $value . "\r\n" : "");
                }
            }
            $str_new_values = substr($str_new_values, 0, -2);
            $data[] = array("$srno", "$tmpUserData->username", "$tmpUserData->auditable_type", "$tmpUserData->event", "$str_old_values", "$str_new_values", "$tmpUserData->updated_at");
        }

        Excel::create('Filename', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {

                    // call cell manipulation methods
                    $row->setBackground('#d3d3d3');
                });
            });
        })->download($type);
 
    }
}

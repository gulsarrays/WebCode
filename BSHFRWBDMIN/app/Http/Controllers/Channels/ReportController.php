<?php

namespace App\Http\Controllers\Channels;

use Illuminate\Routing\Controller;
use App\Repository\ReportRepository as ReportRepo;

use Illuminate\Http\Request;

class ReportController extends Controller {

	/*
	 To get reports of channel content via api call
	*/


	public function __construct(ReportRepo $report)
	{
		$this->reportRepo = $report;
	}

	public function index()
	{
		try{
			$reports = $this->reportRepo->getReports(GET_REPORTS);
			$reportTypes = $this->reportRepo->getReports(GET_REPORT_TYPES);
			return view('channel.reports', compact('reports','reportTypes'));

		}catch(\Exception $e){
			return redirect ('/reports')->withError ( "Couldn't fetch reports" );
		}
		
	}

	public function create(){
		return view('channel.create-reports');
	}

	public function store(Request $request){
		try{
			
			$result = $this->reportRepo->createReportType($request->input(),CREATE_REPORT_TYPE);
			if($result)
				return redirect ('/reports#reportstype')->withSuccess ( "Report type created successfully" );

		}catch(\Exception $e){
			return redirect ('/reports#reportstype')->withError ( "Duplicate Report type can not be created" );
		}
	}

	public function show(){

	}

	public function edit($id){
		$reportType = $this->reportRepo->fetchReportType($id, EDIT_REPORT_TYPE);
				
		return view('channel.edit-reports',compact('reportType'));
	}

	public function update(Request $request, $id){
		
		try{
			$input = $request->all ();
			$result = $this->reportRepo->updateReportType($input, UPDATE_REPORT_TYPE);
			if($result){
				return redirect ('/reports#reportstype')->withSuccess ( 'Report type updated!' );
			}else{
				return redirect ('/reports#reportstype')->withError ( 'Could not update Report type' );
			}
		}catch(\Exception $e){
			// return $e->getMessage();
			return redirect ('/reports#reportstype')->withError ( 'Already Exists' );
		}
	}

	public function destroy($id)
	{
		$result = $this->reportRepo->deleteReportType($id, DELETE_REPORT_TYPE);
		if($result){
			return redirect ('/reports#reportstype')->withSuccess ( 'Report type deleted!' );
		}else{
			return redirect ('/reports#reportstype')->withError ( 'Could not delete Report type' );
		}
	}


}
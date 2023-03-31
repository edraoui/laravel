<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use luminate\Http\UploadedFile;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Models\User;
use PDF;


class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function saveCookie(Request $request){
				$name = $request ->input('txt_Name');
				Cookie::queue("name_user",$name,3600);
				return redirect()->back();
			}
    public function saveAvatar(Request $request){
				$request -> validate([
                    "avatar"=>'required|image'
                ]);
                $avatarName= time().".".$request->avatar->getClientOriginalExtension();
                $request->avatar->move(public_path('avatars'),$avatarName);
                Auth()->user()->update(['avatar' => $avatarName]);
                return back()->with('sucess','avatar updated');
			}
    public function export()
            {
                return Excel::download(new UsersExport, 'users.xlsx');
            }
    public function import()
            {
                Excel::import(new UsersImport, request()->file('file'));

                return redirect('/')->with('success', 'All good!');
            }
    public function generatePDF()
            {
                $users = User::get();

                $data = [
                    'title' => 'Welcome to ItSolutionStuff.com',
                    'date' => date('m/d/Y'),
                    'users' => $users
                ];

                $pdf = PDF::loadView('myPDF', $data);

                return $pdf->download('itsolutionstuff.pdf');
            }
            public function preview()
            {
                return view('chart');
            }

            /**
             * Write code on Construct
             *
             * @return \Illuminate\Http\Response
             */
    public function download()
            {
                $render = view('chart')->render();

                $pdf = new PDF;
                $pdf->addPage($render);
                $pdf->setOptions(['javascript-delay' => 5000]);
                $pdf->saveAs(public_path('report.pdf'));

                return response()->download(public_path('report.pdf'));
            }
        }

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\medrec;
use App\Models\transactions;
use App\Models\transactions_medicines;
use App\Models\transactions_images;
use App\Models\generalfunction;

class CheckupController extends Controller
{
    // use Auth;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('index');
        return view('pages.reports.checkup.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->input('medrec'));
        $edititem = medrec::find($request->input('medrec'));
        // $allergieslist = allergies::all();

        // $q = 'select a.medrec_id, a.allergy_id, b.allergyname
        //         from allergies_medrecs a, allergies b 
        //          where medrec_id = "'.$id.'" 
        //            and a.allergy_id = b.id
        //          order by a.allergy_id';
        // $assignedaller = DB::select($q);
    
        // return view('pages.newtrans')
        //     ->with('edititem', $edititem )
        //     ->with('allergieslist', $allergieslist)
        //     ->with('assignedaller', $assignedaller);  
        
        return view('pages.newtrans')
            ->with('edititem', $edititem );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('store');
        $errormsg = [
            'required' => 'This field is required',
        ];

        $this->validate($request, [
            'check_s' => 'required',
            'check_o' => 'required',
            'check_a' => 'required',
            'check_p' => 'required',
            'check_action' => 'required',
            'diagnosis' => 'required',
        ],$errormsg);
        
        
        $insert = new transactions();
        $insert->medrec_id = $request->input('inp_medrecID');
        $insert->check_s = $request->input('check_s');
        $insert->check_o = $request->input('check_o');
        $insert->check_a = $request->input('check_a');
        $insert->check_p = $request->input('check_p');
        $insert->action = $request->input('check_action');
        $insert->diagnosis = $request->input('diagnosis');
        $insert->save();
        
        $str = strval($request->input('inp_medID'));
        $listmedicines = explode(',',$str);
        foreach($listmedicines as $temp_listmedicines){
            $medicinename = $request->input('inpnamemed'.$temp_listmedicines);
            $qtymed = $request->input('inpqtymed'.$temp_listmedicines);
            if ($qtymed == ''){
                $qtymed = 0;
            }
            if (trim($medicinename) <> '' && $qtymed <> 0){
                $insert2 = new transactions_medicines();
                $insert2->transaction_id = $insert->id;
                $insert2->medicines_id = '0';
                $insert2->desc = $request->input('inpnamemed'.$temp_listmedicines);
                $insert2->qty = $request->input('inpqtymed'.$temp_listmedicines);
                $insert2->rule = $request->input('inprulemed'.$temp_listmedicines);
                $insert2->save();
            }
        };
        

        if ($request->hasFile('checkupImage')){
            $images = $request->file('checkupImage');
            
            if (!empty($images)){
                foreach($images as $temp_images){
                    $path = $temp_images->store('CheckupPhoto/'.$insert->id, 'public');
                    $strPath = strval($path);
                    $filePath = explode('/',$strPath);
                    $fileName = $filePath[count($filePath)-1];
                    $insert3 = new transactions_images();
                    $insert3->transactions_id = $insert->id;
                    $insert3->information = $temp_images->getClientOriginalName();
                    $insert3->image_url = $fileName;
                    $insert3->save();

                }
            }
        }

        generalfunction::notificationMsg($request, 'success', 'Medical checkup created successfully');
        
    
        return redirect(route('medrec.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $displaycheckup = transactions::find($id);
        /* diremark karena medicine menggunakan freetext
        $q = '
        select a.* , b.medicinename
        from transactions_medicines a, medicines b 
        where a.transaction_id = "'.$displaycheckup->id.'"
        and a.medicines_id = b.id 
        ';*/
        $q = '
        select a.*
        from transactions_medicines a
        where a.transaction_id = "'.$displaycheckup->id.'"
        ';
        //$transactions_medicines = transactions_medicines::where('transaction_id', $displaycheckup->id)->get();
        $transactions_medicines = DB::select($q);
        $transactions_images = transactions_images::where('transactions_id', $displaycheckup->id)->get();

        $edititem = medrec::find($displaycheckup->medrec_id);
        // $allergieslist = allergies::all();

        $q = 'select a.medrec_id, a.allergy_id, b.allergyname
                from allergies_medrecs a, allergies b 
                 where medrec_id = "'.$displaycheckup->medrec_id.'" 
                   and a.allergy_id = b.id
                 order by a.allergy_id';
        $assignedaller = DB::select($q);
        
        //return json_encode($transactions_medicines);

        return view('pages.reports.checkup.show')
            ->with('edititem', $edititem )
            // ->with('allergieslist', $allergieslist)
            ->with('assignedaller', $assignedaller)
            ->with('displaycheckup', $displaycheckup)
            ->with('transactions_medicines', $transactions_medicines)
            ->with('transactions_images', $transactions_images);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $access = generalfunction::checkPermission('edit checkup');
        if (!$access) {
            return redirect(route('checkup.index'));
        }

        $displaycheckup = transactions::find($id);
        /* diremark karena medicine menggunakan freetext
        $q = '
        select a.* , b.medicinename
        from transactions_medicines a, medicines b 
        where a.transaction_id = "'.$displaycheckup->id.'"
        and a.medicines_id = b.id 
        ';*/
        $q = '
        select a.*
        from transactions_medicines a
        where a.transaction_id = "'.$displaycheckup->id.'"
        ';
        //$transactions_medicines = transactions_medicines::where('transaction_id', $displaycheckup->id)->get();
        $transactions_medicines = DB::select($q);
        $transactions_images = transactions_images::where('transactions_id', $displaycheckup->id)->get();

        $edititem = medrec::find($displaycheckup->medrec_id);
        // $allergieslist = allergies::all();

        $q = 'select a.medrec_id, a.allergy_id, b.allergyname
                from allergies_medrecs a, allergies b 
                 where medrec_id = "'.$displaycheckup->medrec_id.'" 
                   and a.allergy_id = b.id
                 order by a.allergy_id';
        $assignedaller = DB::select($q);
        
        //return json_encode($transactions_medicines);

        return view('pages.reports.checkup.edit')
            ->with('edititem', $edititem )
            // ->with('allergieslist', $allergieslist)
            ->with('assignedaller', $assignedaller)
            ->with('displaycheckup', $displaycheckup)
            ->with('transactions_medicines', $transactions_medicines)
            ->with('transactions_images', $transactions_images);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if ($request->hasFile('checkupImage')){
            $images = $request->file('checkupImage');
            
            if (!empty($images)){
                foreach($images as $temp_images){
                    $path = $temp_images->store('CheckupPhoto/'.$id, 'public');
                    $strPath = strval($path);
                    $filePath = explode('/',$strPath);
                    $fileName = $filePath[count($filePath)-1];
                    $insert3 = new transactions_images();
                    $insert3->transactions_id = $id;
                    $insert3->information = $temp_images->getClientOriginalName();
                    $insert3->image_url = $fileName;
                    $insert3->save();

                }
                
                generalfunction::notificationMsg($request, 'success', 'Medical checkup updated successfully');
            }
        }else{
            generalfunction::notificationMsg($request, 'warning', 'No data change');
        }

        return back();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        
        $query = $request->get('query');
        if ($query != ''){
            if ($query == 'today'){
                $query = '
                select a.*, b.medrec_name 
                from transactions a, medrecs b
                where date(a.created_at) = current_date
                and a.medrec_id = b.id
                order by a.created_at desc';
            }elseif($query == 'month'){
                $month = date('m');
                $year = date('Y');
                $query = '
                select a.*, b.medrec_name 
                from transactions a, medrecs b
                where month(a.created_at) = "'.$month.'"
                and year(a.created_at) = "'.$year.'"
                and a.medrec_id = b.id
                order by a.created_at desc';
            }else{ //select range
                $str = strval($query);
                $range = explode(',', $str);
                $range_from = $range[0];
                $range_to = $range[1];
                if ($range_to != ""){
                    $query = '
                    select a.*, b.medrec_name 
                    from transactions a, medrecs b
                    where date(a.created_at) between "'.$range_from.'" and "'.$range_to.'"
                    and a.medrec_id = b.id
                    order by a.created_at desc';
                }else{
                    $query = '
                    select a.*, b.medrec_name 
                    from transactions a, medrecs b
                    where date(a.created_at) = "'.$range_from.'"
                    and a.medrec_id = b.id
                    order by a.created_at desc';
                }
            }
        }
        if ($query != ''){
            $result = DB::select($query);
        }
        $totalrow = count($result);
        if ($totalrow > 0){
            $output = "";
            foreach ($result as $temp_result){
                $date = date_create(strval($temp_result->created_at));
                $date1 = date_format($date, "d-M-Y");
                $output = $output.
                '
                    <tr>
                        <td>'.$date1.'</td>
                        <td>
                            <div class="flex"> 
                                <span>'.$temp_result->id.'</span>
                                ';
                
                if(auth()->user()->hasPermissionTo('show checkup') || auth()->user()->hasRole('level4')){
                    $output = $output.
                    '<a href="'.route('checkup.show', $temp_result->id).'" class="btn btn-xs btn-success ml-3">Show</a>
                    ';
                }
                    

                if(auth()->user()->hasPermissionTo('edit checkup') || auth()->user()->hasRole('level4')){
                    $output = $output.
                    '<a href="'.route('checkup.edit', $temp_result->id).'" class="btn btn-xs btn-primary">Edit</a>
                    ';
                }
                                

                $output = $output.'               
                            </div>
                            
                        </td>
                        <td>'.$temp_result->medrec_id.'</td>
                        <td>'.$temp_result->medrec_name.'</td>
                        <td>'.$temp_result->diagnosis.'</td>
                    </tr>
                ';
            }
        }else{
            $output ='
                <tr>
                    <td align="center" colspan="5"> No data found</td>
                </tr>
            ';
        }
        
        $data = array(
            'tabledata' => $output,
            'totalrow' => $totalrow,
        );

        echo json_encode($data);

    }
}

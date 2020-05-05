<?php

namespace App\Http\Controllers\freelancer;

use App\Freelancer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Freelancer $freelancer,Request $request)
    {
        $user = $freelancer->user;
        $freelancer->update(['username'=>$request->username]);
        if ($request->has('avatar')) {
            $user->update(['avatar' => $request->avatar->store('images','public')]);
        }
        if ($request->has('skills')) {
            $skills = explode(',',$request->skills);
            foreach ($skills as $skill) {
                DB::insert('insert into skill_user values(?,?)',[$skill,$freelancer->user_id]);
            }
        }
        if ($request->has('categories')) {
            $categories = explode(',',$request->categories);
            foreach ($categories as $category) {
                DB::insert("insert into category_freelancer(category_id,freelancer_id) values(?,?)",[$category,$freelancer->user_id]);
            }
        }
        return response('created',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}

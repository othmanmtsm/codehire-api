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
    public function index(Freelancer $freelancer)
    {
        return response()->json([
            'username' => $freelancer->username,
            'title' => $freelancer->title,
            'hourlyrate' => $freelancer->hourly_rate,
            'avatar' => $freelancer->user->avatar,
            'member_since' => $freelancer->user->created_at->format('M d Y'),
            'skills' => $freelancer->skills,
            'categories' => $freelancer->categories,
            'experience' => $freelancer->experience
        ]);
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
        $freelancer->update(['hourly_rate'=>$request->hourlyrate]);
        $freelancer->update(['username'=>$request->username]);
        $freelancer->update(['title'=>$request->title]);
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
        return $request;
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

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'website',
        'country',
        'avatar',
        'description',
        'facebook_account',
        'twitter_account',
        'github_account',
        'googleplus_account',    
    ];

    const FOLDER_IMAGE = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userQuestions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function userBlogs()
    {
        return $this->hasMany('App\Models\Blog');
    }

    public function userComments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function follow()
    {
        return $this->hasMany('App\Models\FollowHistory');
    }

    public function uploadImage($file, $dir)
    {
        $time = Carbon::now();
        $dataFile = $file;
        $nameFile = $time->timestamp . $dataFile->getClientOriginalName();
        $destinationPath = base_path() . '/public/avatar/' . $dir;
        $file->move($destinationPath, $nameFile);
        return $nameFile;
    }   

    public function getNewUser()
    {
        return User::orderBy('created_at','DESC')->paginate(10);
    }

    public function updateUser(array $data , $id)
    {
        $user = User::find($id);
        if (isset($data['password']) && $data['password'] != '') {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        if (isset($data['avatar'])) {
            $data['image'] = $this->uploadImage($data['avatar'], User::FOLDER_IMAGE);
        } else {
            $data['image'] = $user->avatar;
        }

        $input = [ 
            'name' => $data['name'],
            'address' => $data['address'],
            'password' => $data['password'],
            'email' => $data['email'],
            'website' => $data['website'],
            'country' => $data['country'],
            'avatar' => $data['image'],
            'description' => $data['description'],
            'facebook_account' => $data['facebook_account'],
            'twitter_account' => $data['twitter_account'],
            'github_account' => $data['github_account'],
            'googleplus_account' => $data['googleplus_account'],
        ];
        return $user->update($input);
    }

    public function searchUser($input)
    {
        return User::where('name', 'LIKE', '%' . $input['search'] . '%')
            ->orWhere('email', 'LIKE', '%' .$input['search'] . '%')
            ->paginate(10);
    }

    public function getOldUser()
    {
        return User::orderBy('created_at','ASC')->paginate(10);
    }

    public function getMostQuestionsUser()
    {
        return User::withCount("userQuestions as questions")->orderBy('questions', 'DESC')->paginate(10);
    }

    public function getMostBlogsUser()
    {
        return User::withCount("userBlogs as blogs")->orderBy('blogs', 'DESC')->paginate(10);
    }

    public function getMostCommentsUser()
    {
        return User::withCount("userComments as comments")->orderBy('comments', 'DESC')->paginate(10);
    }
}

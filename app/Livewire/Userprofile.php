<?php

namespace App\Livewire;

use App\Models\Images;
use App\Models\Like;
use App\Models\Post;
use App\Models\replay;
use Livewire\WithFileUploads;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;


class Userprofile extends Component
{
    use WithFileUploads;

    public $username;
    public $useremail;
    public $post;

    public $postname;
    // public $imagetest

    public $userimage;

    //edit 
    public $editpost;
    public $editid;
    public $editpostimage;

    public function render()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->username = $user->name;
            $this->useremail = $user->email;
            $this->userimage = $user->image;

            $posts = Post::where('user_id', $user->id)->with('img')->get();
            // dd($posts->toArray());
            // $posts = Post::with('img')->get()->toArray();

            // dd($posts);
            $this->post = $posts;
        }

        return view('livewire.userprofile');
    }

    public function logoutuser()
    {
        Auth::logout();
        session()->flash('message', 'Logout Successfully🤓');
        return $this->redirect('/login', navigate: true);
    }


    public function editprofile()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->name = $this->username;
            $user->email = $this->useremail;

            // $this->userimage = '';

            // if ($this->userimage) {
            //     $user->image = $this->userimage->store('public/images');
            // }



            $user->save();

            session()->flash('message', 'Update Successfully🤓');
            // return redirect('profile');
        }
    }

    public function deletepost($id)
    {
        if (Auth::check()) {
            $post = Post::find($id);

            $images = Images::where('post_id', $post->id)->get();
            foreach ($images as $image) {
                Storage::delete($image->img_url);
                $image->delete();
            }

            $replay = replay::where('post_id', $post->id)->get();
            foreach ($replay as $replays) {
                $replays->delete();
            }
            $like = Like::where('post_id', $post->id)->get();
            foreach ($like as $likes) {
                $likes->delete();
            }

            $post->delete();

            session()->flash('message', 'Delete Successfully 🤓');
        }
    }




    public $postId;

    public function postedit($id)
    {
        if (Auth::check()) {
            $post = Post::find($id);
            if ($post) {
                $this->postId = $id;
                $this->editpost = $post->postname;

                if ($this->editpostimage) {
                    $image = Images::where('post_id', $id)->first();
                    $this->editpostimage = $image->img_url;
                    dd($this->editpostimage);
                }
            }
        }
    }

    public function postupdate()
    {
        if (Auth::check()) {
            $post = Post::find($this->postId);
            $post->postname = $this->editpost;


            $image = Images::find($this->postId);

            if ($this->editpostimage) {
                // foreach ($this->editpostimage as $images) {
                //     $imageorignalname = $images->getClientOriginalName();
                //     $image->img_url = $images->storeAs('public/images', $imageorignalname);
                //     $image->save();
                // }
            }
            $post->update();
            return $this->redirect('profile', navigate: true);
        }
        $this->editpost = '';
    }
}

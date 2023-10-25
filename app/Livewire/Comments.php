<?php

namespace App\Livewire;

use App\Models\Images;
use App\Models\Like;
use App\Models\Post;
use App\Models\replay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Nette\Utils\Paginator;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;

use function Laravel\Prompts\alert;

class Comments extends Component
{
    use WithFileUploads;

    public $newcomment;
    public $error;
    public $showReplyForm;
    public $replaytext;
    public $replaycomment;
    public $liked;
    public $likedCommentId;
    public $postimage = [];
    public $videopost;
    public $video;
    public $pdfpost;

    public $title;
    public $description;
    public $imagepreview;
    // public $comments;

    public $linkPreviews = [];

    use WithPagination;

    protected $rules = [
        'newcomment' => 'required|max:500',
        // 'postimage' => 'image|mimes:jpeg,png|max:2048',
    ];

    public function addcomment()
    {
        $this->validate();

        if (Auth::check()) {
            $user = Auth::user();

            $savepost = new Post();
            $savepost->user_id = $user->id;
            $savepost->postname = $this->newcomment;



            if ($this->videopost) {
                $videoname = $this->videopost->getClientOriginalName();
                $savepost->video = $this->videopost->storeAs('public/images', $videoname);
            }

            if ($this->pdfpost) {
                $pdfname = $this->pdfpost->getClientOriginalName();
                $savepost->url = $this->pdfpost->storeAs('public/images', $pdfname);
            }

            $savepost->save();

            $this->postimage = $this->postimage ?? [];
            $this->postimage = array_slice($this->postimage, 0, 6);
            foreach ($this->postimage as $image) {
                $imageModel = new Images();
                $imageModel->post_id = $savepost->id;
                $imageorignalname = $image->getClientOriginalName();
                $imageModel->img_url = $image->storeAs('public/images', $imageorignalname);
                $imageModel->save();
            }

            $this->videopost = '';
            $this->postimage = [];
            $this->newcomment = '';

            session()->flash('message', 'Posts Added Successfully 🥳');
        }
    }


    public function render()
    {
        $comments = Post::orderBy('id', 'desc')->paginate(8);

        // $posts = Post::with('img')->get()->toArray();

        // dd($posts);

        $webreview = Post::get();
        // if ($webreview) {
        //     $linkPreviews = [];

        //     foreach ($webreview as $value) {
        //         $postname = $value->postname;

        //         // Check if the postname is a valid URL
        //         if (filter_var($postname, FILTER_VALIDATE_URL)) {
        //             $response = Http::get($postname);
        //             $html = $response->body();
        //             $crawler = new Crawler($html);

        //             $linkPreview = [
        //                 'title' => $crawler->filter('meta[property="og:title"]')->attr('content'),
        //                 'description' => $crawler->filter('meta[property="og:description"]')->attr('content'),
        //                 'imagepreview' => $crawler->filter('meta[property="og:image"]')->attr('content'),
        //             ];

        //             $linkPreviews[] = $linkPreview;
        //         }
        //     }

        //     $this->linkPreviews = $linkPreviews;
        // }


        foreach ($comments as $comment) {
            $user = User::find($comment->user_id);
            $comment->user_image = $user->image;
            $comment->user_name = $user->name;

            $comment->replies = Replay::where('post_id', $comment->id)->get();
            foreach ($comment->replies as $reply) {
                $replyUser = User::find($reply->user_id);
                $reply->user_image = $replyUser->image;
                $reply->user_name = $replyUser->name;
            }
        }

        return view('livewire.comments', compact('comments'));
    }


    public function delete($deletePostid)
    {
        $post = Post::where('id', $deletePostid)->delete();
        // $this->comments = $this->comments->except($deletePostid);

        session()->flash('message', 'Post Delete Successfully 🥸');
    }

    public function paginationView()
    {
        return 'pagination-links';
    }

    public function logoutuser()
    {
        Auth::logout();
        session()->flash('message', 'Logout Successfully🤓');
        return $this->redirect('/login', navigate: true);
    }

    //Replay
    public function replayform($id)
    {
        $this->showReplyForm = $id;
    }


    public function addReply($id)
    {
        if (Auth::check()) {

            if ($this->replaytext == "") {
                return;
            } else {
                $user = Auth::user();
                $comment = Post::where('id', $id)->first();

                $replay = new replay();
                $replay->user_id = $user->id;
                $replay->post_id = $id;
                $replay->replay = $this->replaytext;
                $replay->save();


                $this->replaytext = '';
            }
        }
    }

    public $like = [];
    public function toggleLike($commentId)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $comment = Post::find($commentId);

            $like = Like::where('user_id', $user->id)
                ->where('post_id', $comment->id)
                ->first();

            if ($like) {
                $like->delete();
            } else {
                $like = new Like();
                $like->user_id = $user->id;
                $like->post_id = $comment->id;
                $like->status = 1;
                $like->save();
            }
        }
    }
}

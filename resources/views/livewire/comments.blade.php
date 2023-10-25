<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/crud" wire:navigate='crud'>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile" wire:navigate='myprofile'>My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)" wire:click='logoutuser'>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                <div class="card-body p-4">
                    <div class="form-outline mb-4">
                        <form wire:submit='addcomment' enctype="multipart/form-data">
                            @if (session()->has('message'))
                                <div class="p3 bg-green-300 textgreen">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <textarea type="text" id="addANote" class="form-control" placeholder="Type Post..." wire:model='newcomment'
                                name='postname'></textarea>

                            {{-- image Icodssdsdsdn --}}
                            <div>dss</div>
                            <label for="fileInput" class="btn-link" title="Post an Image" data-toggle="tooltip">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                    <path
                                        d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                                </svg>
                                <input type="file" id="fileInput" name="postimage" wire:model='postimage'
                                    style="display: none;" multiple>
                            </label>
                            &nbsp;

                            {{-- Video Icon --}}
                            <label for="videoInput" class="btn-link" title="Post a Video" data-toggle="tooltip">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-camera-reels-fill" viewBox="0 0 16 16">
                                    <path d="M6 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path d="M9 6a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                    <path
                                        d="M9 6h.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 7.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 16H2a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h7z" />
                                </svg>
                                <input type="file" id="videoInput" accept="video/*" wire:model="videopost"
                                    style="display: none;">
                            </label>

                            {{-- Pdf Icon --}}
                            <label class="btn-link" title="Post a Video" data-toggle="tooltip">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                                    <path
                                        d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z" />
                                    <path
                                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                </svg>
                                <input type="file" accept=".pdf" wire:model="pdfpost" style="display: none;">
                            </label>

                            @error('newcomment')
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading"></h4>
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                            @error('postimage')
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading"></h4>
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                            {{-- <div wire:dirty>Unsaved changes...</div> --}}
                            <button class="btn btn-primary" type="submit">Add Post</button>
                        </form>
                    </div>
                    {{-- {{dd($comments->toArray())}} --}}

                    @foreach ($comments as $comment)
                        <div class="card mb-4">
                            <div class="card-body">
                                <p>
                                    {{-- <embed src="{{ Storage::url($comment->user_image) }}" width="70%"
                                        height="70%" /> --}}
                                    <img src="{{ Storage::url($comment->user_image) }}"
                                        style="height: 25px; weight: 20px; border-radius: 50%; object-fit: cover;">
                                    {{ $comment->user_name }}
                                </p>
                                <p>
                                    {{ $comment->postname }}

                                    @foreach ($linkPreviews as $linkPreview)
                                        @if ($linkPreview['title'])
                                            <h2>{{ $linkPreview['title'] }}</h2>
                                            <p>{{ $linkPreview['description'] }}</p>
                                            <img src="{{ $linkPreview['imagepreview'] }}" class="img-fluid"
                                                alt="Link Preview" />
                                        @endif
                                    @endforeach

                                </p>

                                @if ($comment->url)
                                    <div style="text-align: center">
                                        <embed src="{{ Storage::url($comment->url) }}" width="70%" height="70%" />
                                    </div>
                                @endif

                                @if ($comment->video)
                                    <div style="text-align: center">
                                        <video width="400" controls>
                                            <source src="{{ Storage::url($comment->video) }}" type="video/mp4">
                                        </video>

                                    </div>
                                @endif

                                <div id="image-slider" class="splide">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach ($comment->img as $image)
                                                <div style="text-align: center">
                                                    <img src="{{ Storage::url($image->img_url) }}"
                                                        style="width:50%;">
                                                </div>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">

                                        <div class="d-flex flex-row align-items-center">

                                            <button style="border-radius: 50%"
                                                wire:click="toggleLike({{ $comment->id }})"
                                                class="btn btn-{{ $comment->likes->firstWhere('status', 1) ? 'primary' : ' ' }}">
                                                <svg width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg" svg-inline=""
                                                    role="presentation" focusable="false" tabindex="-1">
                                                    <path
                                                        d="M10.74 2c2.349 0 3.927 2.235 3.927 4.32C14.667 10.543 8.119 14 8 14c-.118 0-6.667-3.457-6.667-7.68C1.333 4.235 2.911 2 5.26 2 6.607 2 7.49 2.683 8 3.283 8.511 2.683 9.393 2 10.74 2z"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </button>
                                            <h5>
                                                {{ $comment->likes->where('status', 1)->count() }}
                                            </h5>

                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center">
                                        <i class="far fa-thumbs-up mx-2 fa-xs text-black"
                                            style="margin-top: -0.16rem;"></i>
                                        <p class="small text-muted mb-0">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <button wire:click="replayform({{ $comment->id }})">Reply</button>
                            </div>
                            @if ($showReplyForm === $comment->id)
                                <div class="card-body">
                                    <form wire:submit.prevent="addReply({{ $comment->id }})">
                                        <div class="form-group">
                                            <input type="text" wire:model="replaytext" class="form-control"
                                                placeholder="Type a reply">
                                        </div>
                                        {{-- <a href="" class="btn btn-primary" wire:submit='addReply'></a> --}}
                                        <button type="submit" class="btn btn-primary" wire:submit='addReply'>Add
                                            Reply</button>
                                    </form>
                                </div>
                            @endif

                            <!-- Replies -->
                            <div class="card-body">
                                <b>Replays...</b>
                            </div>
                            @foreach ($comment->replies as $reply)
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <p>
                                            <img src="{{ Storage::url($reply->user_image) }}"
                                                style="height: 25px; width: 25px; border-radius: 50%; object-fit: cover;">
                                            {{ $reply->user_name }}
                                        </p>
                                        <p>{{ $reply->replay }} - {{ $reply->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    {{ $comments->links('pagination-links') }}
                </div>
            </div>
        </div>
    </div>
</div>

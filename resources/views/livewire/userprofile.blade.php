<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/crud" wire:navigate='crud'>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile" wire:navigate.hover='myprofile'>My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)" wire:click='logoutuser'>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    @if (session()->has('message'))
        <script>
            Swal.fire({
                icon: 'success', // You can customize the icon
                title: 'Success',
                text: "{{ session('message') }}",
                showConfirmButton: false,
                timer: 3000 // Set a timer to automatically close the alert after 3 seconds
            });
        </script>
    @endif

    <section class="vh-100" style="background-color: #9de2ff;">
        <div class="container py-3 h-50">
            <div class="row d-flex justify-content-between h-100">
                <div>
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex text-black">
                                <div class="flex-shrink-0">
                                    <img src="{{ Storage::url($userimage) }}" alt="Generic placeholder image"
                                        class="img-fluid" style="width: 118px; border-radius: 50%;">
                                </div>&nbsp; &nbsp; &nbsp;
                                <div class="flex-grow-0 ms-3">
                                    <h5 class="mb-2" wire:model='getuserdata'> Name : {{ $username }}</h5>
                                    <p class="mb-2 pb-1" style="color: #2b2a2a;"> Email : {{ $useremail }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form wire:submit.prevent="editprofile" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Change Username:</label>
                                <input type="text" class="form-control" wire:model="username">
                            </div>
                            <div class="form-group">
                                <label for ="recipient-name" class="col-form-label">Change Email:</label>
                                <input type="text" class="form-control" wire:model="useremail">
                            </div>
                            {{-- <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Profile Image:</label>
                                <input type="file" class="form-control" wire:model='user_image'>
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </form>
                </div>

                <div class="col-5">
                    <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                        <h4 style="text-align: center; padding:10px">My Posts</h4>
                        <div class="card-body p-4">
                            @if (count($post) > 0)
                                @foreach ($post as $posts)
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <p>{{ $posts->postname }}</p>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    @if ($posts->video)
                                                        <video width="400" controls>
                                                            <source src="{{ Storage::url($posts->video) }}"
                                                                type="video/mp4">
                                                        </video>
                                                    @endif
                                                </div>
                                                <div>
                                                    @foreach ($posts->img as $image)
                                                        <img src="{{ Storage::url($image->img_url) }}"
                                                            class="img-thumbnail" alt="User Image"
                                                            style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover;">
                                                    @endforeach
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click='deletepost({{ $posts->id }})'
                                                        wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE">Delete</button>&nbsp;

                                                    <button class="btn btn-primary" class="btn btn-primary"
                                                        data-toggle="modal" data-target="#exampleModal"
                                                        wire:click='postedit({{ $posts->id }})'>Edit</button>
                                                </div>
                                            </div>
                                            <p class="small mb-0 ms-2">
                                                {{ $posts->created_at->diffForHumans() }}</p>
                                        </div>

                                    </div>
                                    <hr>
                                @endforeach
                            @else
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            <p class="small mb-0 ms-2" style="text-align: center">No Posts</p>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit='postupdate' enctype="multipart/form-data">
                        <input type="hidden" class="form-control" wire:model='editid'>
                        <div class="form-group">
                            <label for="editpost" class="col-form-label">Post</label>
                            <input type="text" class="form-control" wire:model='editpost'>
                        </div>
                        <div class="form-group">
                            <label for="editpostimage" class="col-form-label">Post Image</label>
                            <input type="file" class="form-control" wire:model.blur='editpostimage'>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>

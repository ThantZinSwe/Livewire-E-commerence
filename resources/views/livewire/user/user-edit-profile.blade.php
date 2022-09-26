<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            Edit Profile
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('user.profile')}}" class="btn btn-success pull-right">My Profile</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if (Session::has('success_message'))
                        <div class="alert alert-success">
                            {{Session::get('success_message')}}
                        </div>
                    @endif
                    <form wire:submit.prevent="editProfile" enctype="multipart/form-data">
                        <div class="col-md-4">
                            @if ($newImage)
                                <img src="{{$newImage->temporaryUrl()}}" alt="" width="100%">
                            @elseif ($image)
                                <img src="{{asset('assets/images/profile/'.$image)}}" alt="" width="100%">
                            @else
                                <img src="{{asset('assets/images/profile/default.png')}}" alt="" width="100%">
                            @endif
                            <input type="file" wire:model="newImage" style="margin-top: 30px">
                        </div>

                        <div class="col-md-8">
                            <p><b>Name : </b> <input type="text" class="form-control" wire:model="name"></p>
                            <p><b>Email : </b> {{$email}}</p>
                            <p><b>Phone : </b> <input type="text" class="form-control" wire:model="mobile"></p>
                            <hr>
                            <p><b>Line1 : </b> <input type="text" class="form-control" wire:model="line1"></p>
                            <p><b>Line2 : </b> <input type="text" class="form-control" wire:model="line2"></p>
                            <p><b>City : </b> <input type="text" class="form-control" wire:model="city"></p>
                            <p><b>Province : </b> <input type="text" class="form-control" wire:model="province"></p>
                            <p><b>Country : </b> <input type="text" class="form-control" wire:model="country"></p>
                            <p><b>Zipcode : </b> <input type="text" class="form-control" wire:model="zipcode"></p>
                            <button type="submit" class="btn btn-info pull-right">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

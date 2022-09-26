<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserEditProfile extends Component {

    use WithFileUploads;

    public $user_id;
    public $image;
    public $newImage;
    public $email;
    public $name;
    public $mobile;
    public $line1;
    public $line2;
    public $city;
    public $province;
    public $country;
    public $zipcode;

    public function mount( $user_id ) {
        $user = User::findOrFail( $user_id );
        $this->user_id = $user_id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->profile->mobile;
        $this->image = $user->profile->image;
        $this->line1 = $user->profile->line1;
        $this->line2 = $user->profile->line2;
        $this->city = $user->profile->city;
        $this->province = $user->profile->province;
        $this->country = $user->profile->country;
        $this->zipcode = $user->profile->zipcode;
    }

    public function editProfile() {
        $user = User::findOrFail( $this->user_id );
        $user->name = $this->name;
        $user->save();

        if ( $this->newImage ) {
            $imageName = uniqid() . '-' . $this->newImage->getClientOriginalName();
            $this->newImage->storeAs( 'profile', $imageName );

            if ( $this->image ) {

                if ( File::exists( public_path() . '/assets/images/profile/' . $this->image ) ) {
                    File::delete( public_path() . '/assets/images/profile/' . $this->image );
                }

            }

        } else {
            $imageName = $this->image;
        }

        $user->profile->image = $imageName;
        $user->profile->mobile = $this->mobile;
        $user->profile->line1 = $this->line1;
        $user->profile->line2 = $this->line2;
        $user->profile->city = $this->city;
        $user->profile->province = $this->province;
        $user->profile->country = $this->country;
        $user->profile->zipcode = $this->zipcode;
        $user->profile->save();

        session()->flash( 'success_message', 'Profile has been updated successfully' );
    }

    public function render() {
        return view( 'livewire.user.user-edit-profile' )
            ->layout( 'layouts.base' );
    }

}

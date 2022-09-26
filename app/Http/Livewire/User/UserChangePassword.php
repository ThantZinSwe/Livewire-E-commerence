<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserChangePassword extends Component {

    public $current_password;
    public $password;
    public $password_confirmation;

    protected $rules = array(
        'current_password' => 'required',
        'password'         => 'required|min:8|confirmed|different:current_password',
    );

    public function changePassword() {
        $this->validate();

        if ( Hash::check( $this->current_password, Auth::user()->password ) ) {
            $user = User::findOrFail( Auth::user()->id );
            $user->password = Hash::make( $this->password );
            $user->save();
            session()->flash( 'success_message', 'Pasword has been change success' );
        } else {
            session()->flash( 'error_message', 'Password does not match!' );
        }

    }

    public function render() {
        return view( 'livewire.user.user-change-password' )
            ->layout( 'layouts.base' );
    }

}

<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfileComponent extends Component {
    public function render() {
        $user = User::findOrFail( Auth::user()->id );

        return view( 'livewire.user.user-profile-component', array( 'user' => $user ) )
            ->layout( 'layouts.base' );
    }

}

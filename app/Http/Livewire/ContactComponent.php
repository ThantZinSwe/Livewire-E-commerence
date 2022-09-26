<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactComponent extends Component {

    public $name;
    public $email;
    public $phone;
    public $comment;

    protected $rules = array(
        'name'    => 'required',
        'email'   => 'required|email',
        'phone'   => 'required',
        'comment' => 'required',
    );

    public function sendMessage() {
        $this->validate();

        Contact::create( array(
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'comment' => $this->comment,
        ) );

        session()->flash( 'success_message', 'Thanks, Your message has been sent success' );
    }

    public function render() {
        return view( 'livewire.contact-component' )
            ->layout( 'layouts.base' );
    }
}

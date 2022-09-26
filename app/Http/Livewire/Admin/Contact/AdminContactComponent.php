<?php

namespace App\Http\Livewire\Admin\Contact;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class AdminContactComponent extends Component {

    use WithPagination;

    public function render() {
        $contacts = Contact::paginate( 12 );
        return view( 'livewire.admin.contact.admin-contact-component', array('contacts' => $contacts) )
            ->layout( 'layouts.base' );
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\Models\Sale;
use Livewire\Component;

class AdminSaleComponent extends Component {

    public $status;
    public $sale_date;

    protected $rules = array(
        'status'    => 'required',
        'sale_date' => 'required',
    );

    public function mount() {
        $sale = Sale::find( 1 );
        $this->status = $sale->status;
        $this->sale_date = $sale->sale_date;
    }

    public function updateSale() {
        $this->validate();

        $sale = Sale::find( 1 );
        $sale->update( array(
            'sale_date' => $this->sale_date,
            'status'    => $this->status,
        ) );

        session()->flash( 'success_message', 'Sale setting has been updated successfully!' );
    }

    public function render() {
        return view( 'livewire.admin.admin-sale-component' )
            ->layout( 'layouts.base' );
    }
}

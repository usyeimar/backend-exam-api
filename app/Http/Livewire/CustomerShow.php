<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;

class CustomerShow extends Component
{

    public Customer $customer;
    public function render()
    {
        return view('livewire.customer-show');
    }
}

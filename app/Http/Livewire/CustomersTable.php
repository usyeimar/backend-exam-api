<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomersTable extends Component
{
    use WithPagination;

    public $search = 'u';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : $this->sortDirection = 'asc';

        $this->sortField = $field;
    }


    public function render()
    {
        return view('livewire.customers-table', [
            'customers' => Customer::where('first_name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->orWhere('phone_number', 'like', '%'.$this->search.'%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }


    public function deleteCustomer(Customer $customer)
    {
        $customer->delete();
    }
}

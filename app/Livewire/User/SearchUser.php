<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;

class SearchUser extends Component
{
    public $search = '';

    public function render()
    {
        $query = User::query();

        if (!empty($this->search)) {
            $query->where('user_name', 'like', "%{$this->search}%")
                  ->orWhere('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
        }

        $users = $query->paginate(5);

        return view('livewire.user.search-user', [
            'users' => $users,
        ]);
    }
}

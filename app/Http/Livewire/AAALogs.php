<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use stdClass;
use App\Models\ClientLog;

class AAALogs extends Component
{
    public $logs;
    public $logsData;
    public $page;
    public $searchTerm = '';

    public function mount()
    {
        // Retrieve data from the database and convert to an array of objects
        $this->logs = ClientLog::latest('EVENTTIME')
            ->take(100)
            ->get()
            ->map(function ($item) {
                return (object) $item->toArray();
            })->toArray();
    }

    public function render()
    {
        $this->logsData = $this->logs;
        if(!$this->logsData){
            $this->logsData = [];
        }
        //If user search some string, this code block triggers
        $searchTerm = $this->searchTerm;
        if($searchTerm !== '' || $searchTerm !== null){

            $results = array_filter($this->logsData, function ($obj) use ($searchTerm) {
                foreach ($obj as $property => $value) {
                    if (is_string($value) && strpos($value, $searchTerm) !== false) {
                        return true;
                    }
                }
                return false;
            });

            //Convert to object collection
            $results = collect($results);
            $results = $results->map(function ($item) {
                return (object) $item;
            })->toArray();
            $this->logsData = $results;
        }
        //Data rendering to the blade with pagination
        $perPage = 12;
        $this->page = request("page") ?? $this->page;
        $rawCollection = $this->logsData;
        $fixedCollection = new Collection();
        if (gettype($rawCollection) == "array") {
            foreach($rawCollection as $key => $val) {
                $fixedCollection->put($key, $val);
            }
        } else {
            $fixedCollection = $rawCollection;
        }

        $items = $fixedCollection->forPage($this->page, $perPage);
        if($items->count() === 0){
            $this->page = 1;
            $items = $fixedCollection->forPage($this->page, $perPage);
        }
        $paginator = new LengthAwarePaginator($items, $fixedCollection->count(), $perPage, $this->page, ['path' => url('aaalogs')]);
        return view('livewire.aaalogs', ['aaalogsData' => $paginator]);
    }

}

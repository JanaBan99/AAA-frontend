<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use stdClass;
use Carbon\Carbon;

class RadiusLogs extends Component
{
    public $lines = [];
    public $lineArray = [];
    public $searchTerm = '';
    public $page = 1;
    public $defaultRowCount = 250;
    public $rowCount;
    public $fromDate = '';
    public $toDate = '';
    public $fromDateFormated = '';
    public $toDateFormated = '';

    protected $messages = [
        'rowCount.between' => 'The row count must be between 1 and 5000',
        'rowCount.integer' => 'Row count must be an integer',
        'fromDate' => 'The from date field must be a valid date',
        'toDate' => 'The from date field must be a valid date',
        'toDate.after_or_equal' => 'The toDate must be a date after or equal to the fromDate',
    ];

    protected function rules(){
        return [
            'rowCount' => ['required','integer', 'between:1,5000'],
            'fromDate' => ['date'],
            'toDate' => ['date', 'after_or_equal:fromDate'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->rowCount =session('rowCount') ?? $this->defaultRowCount; // Set to default row count if there's no rowCount in session
        $this->fromDate = session('fromDate') ?? $this->fromDate;
        $this->toDate = session('toDate') ?? $this->toDate;

        $this->readFile($this->rowCount);
    }

    public function readFile($rowCountNumber)
    {
        // dump(base_path('/var/log/freeradius/radius.log'));
        if (config('app.env') === 'production') {
            $filePath = '/var/log/freeradius/radius.log';
        }else{
            $filePath = storage_path('logs/radius.log');
        }
        if (file_exists($filePath)) {

            $lines = file($filePath, FILE_SKIP_EMPTY_LINES);
            $filteredLines = array_slice($lines, -$rowCountNumber);

            // Filter lines by fromDate and toDate
            if (session('fromDate') && session('toDate')) {

                $this->fromDateFormated = Carbon::parse(session('fromDate'))->format('D M d H:i:s Y');
                $this->toDateFormated = Carbon::parse(session('toDate'))->format('D M d H:i:s Y');

                $filteredLines = array_filter($filteredLines, function($line) {
                    // Assuming the date is at the beginning of the line
                    $lineDate = substr($line, 0, 24); // Adjust this based on your log format
                    $lineDate = Carbon::createFromFormat('D M d H:i:s Y', $lineDate);

                    return $lineDate->greaterThanOrEqualTo($this->fromDateFormated) && $lineDate->lessThanOrEqualTo($this->toDateFormated);
                });
                $this->lines = $filteredLines;
            }else{
                $this->lines = $filteredLines;
            }

        } else {
            $this->lines[] = "File not found.";
        }
    }

    public function updateLogs()
    {
        $validatedData = $this->validate();
        session(['rowCount' => $this->rowCount]);

        //Date conversion
        if($this->fromDate !== "" || $this->fromDate !== null ){
            session(['fromDate' => $this->fromDate]);
        }else{
            session()->forget('fromDate');
        }

        if($this->toDate !== "" || $this->toDate !== null ){
            session(['toDate' => $this->toDate]);
        }else{
            session()->forget('toDate');
        }

        $this->readFile($this->rowCount);

    }

    public function render()
    {
        $this->lineArray = $this->lines;
        if(!$this->lineArray){
            $this->lineArray = [];
        }

        ///If user search some string, this code block triggers
        $searchTerm = $this->searchTerm;
        if($searchTerm !== '' || $searchTerm !== null){

            $results = array_filter($this->lines, function ($line) {
                return stripos($line, $this->searchTerm) !== false;
            });
            //Convert to object collection
            $results = collect($results);
            $results = $results->map(function ($item) {
                return (object) $item;
            })->toArray();
            $this->lineArray = $results;
        }

        //Data rendering to the blade with pagination
        $perPage = 10;
        $this->page = request("page") ?? $this->page;
        $rawCollection = $this->lineArray;
        $fixedCollection = new Collection();
        if (gettype($rawCollection) == "array") {
            foreach($rawCollection as $key => $val) {
                $fixedCollection->put($key, $val);
            }
        } else {
            $fixedCollection = $rawCollection;
        }

        //If there are no records in current page in paginator when delete records, the page redirects to page one
        $items = $fixedCollection->forPage($this->page, $perPage);
        if($items->count() === 0){
            $this->page = 1;
            $items = $fixedCollection->forPage($this->page, $perPage);
        }
        $paginator = new LengthAwarePaginator($items, $fixedCollection->count(), $perPage, $this->page, ['path' => url('radiuslogs')]);
        // dump($paginator);
        return view('livewire.radiuslogs', ['linesArray' => $paginator]);
    }

}

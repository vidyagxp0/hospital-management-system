<?php

namespace App\Livewire;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PatientTable extends LivewireTableComponent
{
    use WithPagination;

    public $showButtonOnHeader = true;

    public $showFilterOnHeader = true;

    public $buttonComponent = 'patients.add-button';

    public $FilterComponent = ['patients.filter-button', Patient::FILTER_STATUS_ARR];

    public $statusFilter;

    protected $model = Patient::class;

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

    // public function resetPage($pageName = 'page')
    // {
    //     $rowsPropertyData = $this->getRows()->toArray();
    //     $prevPageNum = $rowsPropertyData['current_page'] - 1;
    //     $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
    //     $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

    //     $this->setPage($pageNum, $pageName);
    // }

    public function changeFilter($statusFilter)
    {
        $this->resetPage($this->getComputedPageName());
        $this->statusFilter = $statusFilter;
        $this->setBuilder($this->builder());
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('patients.created_at', 'desc')
            ->setQueryStringStatus(false);
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '4') {
                return [
                    'width' => '8%',
                ];
            }
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                    'style' => 'padding-right:20px !important',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.patients'), 'patientUser.first_name')
                ->view('patients.columns.patient')
                ->sortable()
                ->searchable(function(Builder $query,$direction){
                    $query->whereHas('user', function(Builder $q) use ($direction){
                        $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                    });
                }),
            Column::make('email', 'patientUser.email')
                ->searchable()
                ->hideIf(1),
            Column::make(__('messages.user.phone'), 'patientUser.phone')
                ->view('patients.columns.phone')
                ->sortable()->searchable(),
            Column::make(__('messages.user.blood_group'), 'patientUser.blood_group')
                ->view('patients.columns.blood_group')
                ->sortable()->searchable(),
            Column::make(__('messages.common.status'), 'patientUser.status')
                ->view('patients.columns.status'),
            Column::make(__('messages.common.action'), 'id')
                ->view('patients.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = Patient::where('patients.tenant_id', '=',getLoggedInUser()->tenant_id)->whereHas('patientUser')->with('patientUser.media')->select('patients.*');
        $query->when(isset($this->statusFilter), function (Builder $q) {
            if ($this->statusFilter == 1) {
                $q->where('status', Patient::ACTIVE);
            }
            if ($this->statusFilter == 2) {
                $q->where('status', Patient::INACTIVE);
            }
        });

        return $query;
    }
}

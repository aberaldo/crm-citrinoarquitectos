<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BudgetRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BudgetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BudgetCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Budget::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/budget');
        CRUD::setEntityNameStrings(trans('crud.budget.budget'), trans('crud.budget.budgets'));
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->denyAccess('show');
        CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BudgetRequest::class);

        $this->crud->addField([
            'name'  => 'title',
            'label' => trans('crud.budget.title'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => trans('crud.budget.head'),
        ]);
        
        $this->crud->addField([
            'name'  => 'client_id',
            'label' => trans('crud.client.client'),
            'type'  => 'relationship',
            'allows_null' => true,
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => trans('crud.budget.head'),
        ]);
        
        $this->crud->addField([
            'name'  => 'date',
            'label' => trans('crud.budget.date'),
            'type'  => 'date_picker',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => trans('crud.budget.head'),
        ]);
        
        $this->crud->addField([
            'name'  => 'address',
            'label' => trans('crud.budget.address'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => trans('crud.budget.head'),
        ]);
        
       /* $this->crud->addField([   // repeatable
            'name'  => 'testimonials',
            'label' => 'Testimonials',
            'type'  => 'repeatable',
            'fields' => [
                [
                    'name'  => 'service_id',
                    'label' => trans('crud.service.service'),
                    'type'  => 'select2_from_ajax',
                    'entity' => 'service',
                    'attribute' => 'name',
                    'allows_null' => true,
                    'wrapper'   => [
                        'class' => 'form-group col-md-6'
                    ],
                ],
            ],
        
            'new_item_label'  => trans('crud.budget.AddService'),
            'init_rows' => 0,
            'tab' => trans('crud.budget.services'),
        
        ]);*/
        
        $this->crud->addField([
            'name'            => 'commercial_conditions',
            'label'           => trans('crud.budget.commercialConditions'),
            'type'            => 'table',
            'entity_singular' => trans('crud.budget.condition'),
            'columns'         => [
                'name'  => trans('crud.budget.condition'),
                'desc'  => trans('crud.budget.description'),
            ],
            'max' => 50,
            'min' => 0,
            'tab' => trans('crud.budget.commercialConditions'),
        ],);
        
        $this->crud->addField([
            'name'            => 'notes',
            'label'           => trans('crud.budget.notes'),
            'type'            => 'table',
            'entity_singular' => trans('crud.budget.note'),
            'columns'         => [
                'name'  => trans('crud.budget.note'),
                'desc'  => trans('crud.budget.description'),
            ],
            'max' => 50,
            'min' => 0,
            'tab' => trans('crud.budget.notes'),
        ],);
        
        $this->crud->addField([
            'name'            => 'team',
            'label'           => trans('crud.budget.team'),
            'type'            => 'table',
            'entity_singular' => trans('crud.budget.member'),
            'columns'         => [
                'name'  => trans('crud.budget.member'),
                'desc'  => trans('crud.budget.name'),
            ],
            'max' => 50,
            'min' => 0,
            'tab' => trans('crud.budget.team'),
        ],);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

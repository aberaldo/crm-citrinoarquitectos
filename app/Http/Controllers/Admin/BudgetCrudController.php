<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BudgetRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class BudgetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BudgetCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;


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
        $this->crud->addButtonFromView('line', 'pdf', 'pdf', 'beginning');

        $this->crud->addColumn([
            'name'         => 'id',
            'type'         => 'text',
            'label'        => trans('crud.budget.id'),
        ]);
        
        $this->crud->addColumn([
            'name'         => 'client',
            'type'         => 'relationship',
            'label'        => trans('crud.client.client'),
            'entity'    => 'client',
            'attribute' => 'name',
            'model'     => App\Models\Client::class, 
        ]);
        
        $this->crud->addColumn([
            'name'         => 'address',
            'type'         => 'text',
            'label'        => trans('crud.budget.address'),
        ]);

        $this->crud->addColumn([
            'name'         => 'date',
            'type'         => 'date',
            'format' => 'DD/MM/YYYY',
            'label'        => trans('crud.budget.date'),
        ]);
        
        $this->crud->addColumn([
            'name'         => 'currency',
            'type'         => 'text',
            'label'        => trans('crud.budget.currency'),
        ]);
        
        $this->crud->addColumn([
            'name'         => 'status',
            'type'         => 'text',
            'label'        => trans('crud.budget.status'),
        ]);

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'id',
            'label' => trans('crud.budget.id')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'id', '=', "$value");
        });

        $this->crud->addFilter([
            'name'  => 'client',
            'type'  => 'select2_ajax',
            'label' => trans('crud.client.client'),
            'method' => 'POST',
            'minimum_input_length' => 0,
            'select_attribute' => 'name',
            'select_key' => 'id',
        ], 
        backpack_url('budget/fetch/client'),
        function ($value) {
            $this->crud->addClause('where', 'client_id', $value);
        });

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'title',
            'label' => trans('crud.budget.title')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => trans('crud.budget.status'),
          ], [
            'Pago' => 'Pago',
            'Impago' => 'Impago',
          ], function($value) { // if the filter is active
             $this->crud->addClause('where', 'status', $value);
          });
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

        Widget::add()
              ->to('after_content')
              ->type('budget');
    
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
            'label' => trans('crud.client.client'),
            'type' => "relationship",
            'name'  => 'client_id',
            'ajax' => true,
            'data_source' => backpack_url('budget/fetch/client'),
            'placeholder' => trans('crud.client.client'),
            'minimum_input_length' => 0,
            'wrapper' => ['class' => 'form-group col-md-6'],
            'tab' => trans('crud.budget.head'),
            'allows_null'     => true,
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
                'class' => 'form-group col-md-8'
            ],
            'tab' => trans('crud.budget.head'),
        ]);
        
        $this->crud->addField([
            'name'  => 'social_laws_amount',
            'label' => trans('crud.budget.social_laws_amount'),
            'type'  => 'number',
            'wrapper'   => [
                'class' => 'form-group col-md-4'
            ],
            'hint'       => 'Monto en pesos uruguayos',
            'tab' => trans('crud.budget.head'),
        ]);
        
        $this->crud->addField([
            'name'        => 'currency',
            'label' => trans('crud.budget.currency'),
            'type'        => 'select_from_array',
            'options'     => ['UYU' => trans('crud.budget.uyu'), 'USD' => trans('crud.budget.usd')],
            'allows_null' => true,
            'wrapper'   => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => trans('crud.budget.head'),
        ],);
        
        $this->crud->addField([
            'name'        => 'payment_method',
            'label' => trans('crud.budget.payment_method'),
            'type'        => 'select_from_array',
            'options'     => ['Contado' => 'Contado', 'Crédito' => 'Crédito'],
            'allows_null' => true,
            'wrapper'   => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => trans('crud.budget.head'),
        ],);
        
        $this->crud->addField([
            'name'        => 'status',
            'label'       => trans('crud.budget.status'),
            'type'        => 'select_from_array',
            'options'     => ['Pago' => 'Pago', 'Impago' => 'Impago'],
            'allows_null' => true,
            'wrapper'   => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => trans('crud.budget.head'),
        ],);
        
        $this->crud->addField([
            'name'  => 'headings',
            'label' => trans('crud.budget.headings'),
            'type'  => 'repeatable',
            'fields' => [
                [
                    'name'  => 'heading',
                    'label' => trans('crud.budget.description'),
                    'type'  => 'text',
                ],
                [
                    'name'            => 'subheading',
                    'label'           => trans('crud.budget.subheadings'),
                    'type'            => 'table_citrino',
                    'entity_singular' => trans('crud.budget.subheading'),
                    'columns'         => [
                        'description'  => [
                            'label' => trans('crud.budget.description'),
                            'type' => 'textarea',
                            'class' => 'col-sm-4',
                        ],
                        'unit'  => [
                            'label' => trans('crud.budget.unit'),
                            'type' => 'text',
                            'class' => 'col-sm-1',
                        ],
                        'qty'  => [
                            'label' => trans('crud.budget.qty'),
                            'type' => 'number',
                            'class' => 'col-sm-1',
                        ],
                        'price'  => [
                            'label' => trans('crud.budget.price'),
                            'type' => 'number',
                            'class' => 'col-sm-2',
                        ],
                        'tax'  => [
                            'label' => trans('crud.budget.tax'),
                            'type' => 'number',
                            'class' => 'col-sm-2',
                        ],
                    ],
                ],
            ],
        
            'new_item_label'  => trans('crud.budget.addHeading'),
            'init_rows' => 0,
            'tab' => trans('crud.budget.headings'),
        
        ]);

        $this->crud->addField([
            'name' => 'subtotal',
            'label' => 'Subtotal',
            'type' => 'number',
            'attributes' => [
                "readonly" => "true",
                'class' => 'form-control col-md-2',
            ],
            'tab' => trans('crud.budget.headings'),
        ]);
        $this->crud->addField([
            'name' => 'iva',
            'label' => 'IVA',
            'type' => 'number',
            'attributes' => [
                "readonly" => "true",
                'class' => 'form-control col-md-2',
            ],
            'tab' => trans('crud.budget.headings'),
        ]);
        $this->crud->addField([
            'name' => 'total',
            'label' => 'Total',
            'type' => 'number',
            'attributes' => [
                "readonly" => "true",
                'class' => 'form-control col-md-2',
            ],
            'tab' => trans('crud.budget.headings'),
        ]);
        
        $this->crud->addField([
            'name'            => 'conditions',
            'label'           => trans('crud.budget.conditions'),
            'type'            => 'table',
            'entity_singular' => trans('crud.budget.condition'),
            'columns'         => [
                'name'  => trans('crud.budget.condition'),
                'desc'  => trans('crud.budget.description'),
            ],
            'max' => 50,
            'min' => 0,
            'tab' => trans('crud.budget.conditions'),
        ],);
        
        /*$this->crud->addField([
            'name'            => 'notes',
            'label'           => trans('crud.budget.notes'),
            'type'            => 'textarea',
            'attributes' => [
                'rows' => 5,
            ],
            'tab' => trans('crud.budget.notes'),
        ],);*/

        $this->crud->addField([
            'name'            => 'notes',
            'label'           => '',
            'type'            => 'table_citrino',
            'entity_singular' => trans('crud.budget.note'),
            'columns'         => [
                'note'  => [
                    'label' => trans('crud.budget.notes'),
                    'type' => 'text',
                    'class' => 'col-sm-10',
                ],
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
    
    public function fetchClient()
    {

        return $this->fetch([
            'model' => \App\Models\Client::class,
        ]);
       
    }
}
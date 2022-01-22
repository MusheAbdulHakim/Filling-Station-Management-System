<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        CRUD::column('name');
        CRUD::column('avatar')->type('browse');
        CRUD::column('designation_id')
            ->type('select')
            ->entity('designation')
            ->attribute('title')
            ->model("app\Models\Designation")
            ->wrapper([
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('unit/'.$related_key.'/show');
                },
            ]);
        CRUD::column('email')->type('email');
        CRUD::column('phone');
        CRUD::column('address');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */

        CRUD::addField([  
            'name'  => 'name',
            'label' => 'FullName',
            'type'  => 'text',
        ]);
        CRUD::addField([  // Select2
            'label'     => 'Designation',
            'type'      => 'select2',
            'model' =>  'app\Models\Designation',
            'name'      => 'designation_id', // the db column for the foreign key
            'entity'    => 'designation', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
        ]);
        CRUD::addField([  
            'name'  => 'email',
            'label' => 'Email',
            'type'  => 'email',
        ]);
        CRUD::addField([  
            'name'  => 'phone',
            'label' => 'Phone',
            'type'  => 'text',
        ]);
        CRUD::addField([  
            'name'  => 'address',
            'label' => 'Address',
            'type'  => 'text',
        ]);
        CRUD::addField([  
            'name'  => 'avatar',
            'label' => 'Avatar',
            'type'  => 'browse',
        ]);
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

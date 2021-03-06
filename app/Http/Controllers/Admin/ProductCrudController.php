<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        CRUD::column('name');
        CRUD::column('quantity')
            ->type('number')
            ->type('select')
            ->entity('purchase')
            ->attribute('quantity')
            ->model("app\Models\Purchase")
            ->wrapper([
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('purchase/'.$related_key.'/show');
                },
        ]);
        
        CRUD::column('unit_id')
            ->type('select')
            ->entity('unit')
            ->attribute('name')
            ->model("app\Models\Unit")
            ->wrapper([
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('unit/'.$related_key.'/show');
                },
        ]);
        
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        CRUD::addField([   
            'name'  => 'name',
            'label' => 'Product Name',
            'type'  => 'text',
        ]);
        CRUD::addField([  // Select2
            'label'     => 'unit',
            'type'      => 'select2',
            'model' =>  'app\Models\Unit',
            'name'      => 'unit_id', // the db column for the foreign key
            'entity'    => 'unit', // the method that defines the relationship in your Model
            'attribute' => 'name', 
        ]);
        
        // CRUD::addField([   
        //     'name'  => 'cost_price',
        //     'label' => 'Cost Price',
        //     'type'  => 'number',
        //     'suffix' => '.00',
        //     ]);
        // CRUD::addField([   
        //     'name'  => 'sale_price',
        //     'label' => 'Sale Price',
        //     'type'  => 'number',
        //     'suffix' => '.00',
            
        // ]);
        CRUD::addField([
            'name' => 'upload',
            'type' => 'upload',
            'label' => 'Upload Image',
            'upload' => true,
            'disk' => 'uploads'
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

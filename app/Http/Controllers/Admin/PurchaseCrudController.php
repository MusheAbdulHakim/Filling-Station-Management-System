<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PurchaseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PurchaseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PurchaseCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Purchase::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/purchase');
        CRUD::setEntityNameStrings('purchase', 'purchases');
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
        // CRUD::setFromDb(); // columns
        CRUD::column('product_id')
            ->type('select')
            ->entity('product')
            ->attribute('name')
            ->model("app\Models\Product")
            ->wrapper([
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('unit/'.$related_key.'/show');
                },
            ]);
        CRUD::column('supplier_id')
            ->type('select')
            ->entity('supplier')
            ->attribute('name')
            ->model("app\Models\Supplier")
            ->wrapper([
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('supplier/'.$related_key.'/show');
                },
            ]);
        CRUD::column('quantity');
        
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PurchaseRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
        CRUD::addField([  // Select2
            'label'     => 'Product',
            'type'      => 'select2',
            'model' =>  'app\Models\Product',
            'name'      => 'product_id', // the db column for the foreign key
            'entity'    => 'product', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
        ]);
        CRUD::addField([  // Select2
            'label'     => 'Supplier',
            'type'      => 'select2',
            'model' =>  'app\Models\Supplier',
            'name'      => 'supplier_id', // the db column for the foreign key
            'entity'    => 'supplier', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
        ]);
        CRUD::addField([  
            'name'  => 'quantity',
            'label' => 'Quantity Purchased',
            'type'  => 'number',
        ]);
        CRUD::addField([  
            'name'  => 'comment',
            'label' => 'Comment',
            'type'  => 'textarea',
            
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

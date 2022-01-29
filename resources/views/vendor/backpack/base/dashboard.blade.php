@extends(backpack_view('blank'))

@php
	// ---------------------
	// JUMBOTRON widget demo
	// ---------------------
	// Widget::add([
 //        'type'        => 'jumbotron',
 //        'name' 		  => 'jumbotron',
 //        'wrapperClass'=> 'shadow-xs',
 //        'heading'     => trans('backpack::base.welcome'),
 //        'content'     => trans('backpack::base.use_sidebar'),
 //        'button_link' => backpack_url('logout'),
 //        'button_text' => trans('backpack::base.logout'),
 //    ])->to('before_content')->makeFirst();

	// -------------------------
	// FLUENT SYNTAX for widgets
	// -------------------------
	// Using the progress_white widget
	// 
	// Obviously, you should NOT do any big queries directly in the view.
	// In fact, it can be argued that you shouldn't add Widgets from blade files when you
	// need them to show information from the DB.
	// 
	// But you do whatever you think it's best. Who am I, your mom?
	$userCount = App\User::count();
	$purchaseCount = App\Models\Purchase::count();
 	

    $widgets['before_content'][] = [
	  'type' => 'div',
	  'class' => 'row',
	  'content' => [ // widgets 
		  	[ 
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6',
		        // 'class' => 'col-md-6',
		        'controller' => \App\Http\Controllers\Admin\Charts\LatestUsersChartController::class,
				'content' => [
				    'header' => 'New Users Past 7 Days', // optional
				    // 'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>', // optional
					
		    	]
	    	],
	    	[ 
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6',
		        // 'class' => 'col-md-6',
		        'controller' => \App\Http\Controllers\Admin\Charts\LatestPurchaseChartController::class,
				'content' => [
				    'header' => 'Past 7 Days Purchases', // optional
				    // 'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>', // optional
		    	]
	    	],
    	]
	];

    
    
@endphp

@section('content')
	{{-- In case widgets have been added to a 'content' group, show those widgets. --}}
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('group', 'content')->toArray() ])
@endsection

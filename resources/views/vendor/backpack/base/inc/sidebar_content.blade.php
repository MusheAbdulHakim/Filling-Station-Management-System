<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon la la-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='nav-icon la la-list'></i> Products</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplier') }}'><i class='nav-icon la la-user'></i> Suppliers</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase') }}'><i class='nav-icon la la-credit-card'></i> Purchases</a></li>
<li class="nav-item nav-dropdown">
  <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-cogs"></i> Expenses</a>
  <ul class="nav-dropdown-items">
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('expense-category') }}"><i class="nav-icon la la-files-o"></i> <span>Categories</span></a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('expense') }}"><i class="nav-icon la la-hdd-o"></i> <span>Expenses</span></a></li>
  </ul>
</li>
<li class="nav-item nav-dropdown">
  <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> HRM</a>
  <ul class="nav-dropdown-items">
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('designation') }}'><i class='nav-icon la la-question'></i> Designations</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee') }}'><i class='nav-icon la la-user'></i> Employees</a></li>
  </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sale') }}'><i class='nav-icon la la-shopping-basket'></i> Sales</a></li>
<!-- Users, Roles Permissions -->
<li class="nav-item nav-dropdown">
  <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i> Authentication</a>
  <ul class="nav-dropdown-items">
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-group"></i> <span>Roles</span></a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
  </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-cogs"></i> Advanced</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>File manager</span></a></li>
      @include('backpack-database-notifications::sidebarMenuItem')
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('backup') }}"><i class="nav-icon la la-hdd-o"></i> <span>Backups</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i class="nav-icon la la-terminal"></i> <span>Logs</span></a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('unit') }}'><i class='nav-icon la la-question'></i> Units</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('setting') }}"><i class="nav-icon la la-cog"></i> <span>Settings</span></a></li>

    </ul>
</li>


<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('client') }}'><i class='nav-icon la la-question'></i> {{trans('crud.client.clients')}}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('service') }}'><i class='nav-icon la la-question'></i> {{trans('crud.service.services')}}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('budget') }}'><i class='nav-icon la la-question'></i> {{trans('crud.budget.budgets')}}</a></li>

<style>
    @media print{

.noprint {
    display:none;
}



}

</style>
<div class="sidebar-wrapper noprint" data-simplebar="true">


    <div class="sidebar-header noprint">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">{{$appName}}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu noprint" id="menu">
         <li>
            <a href="{{url('forex/dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-atom'></i>
                </div>
                <div class="menu-title">Manage transactions</div>
            </a>
            <ul>

                <li> <a href="{{url('forex/sale/SL'.mt_rand(1000, 9999).time())}}"><i class="bx bx-right-arrow-alt"></i>Sell currency</a>
                </li>
                <li> <a href="{{url('forex/purchase/PC'.mt_rand(1000, 9999).time())}}"><i class="bx bx-right-arrow-alt"></i>Buy currency</a>
                </li>
                <li> <a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Transactions history</a>
                    <ul>
                        <li> <a href="{{url('forex/transactions')}}"><i class="bx bx-right-arrow-alt"></i> All Transactions</a>
                        </li>
                        <li> <a href="{{url('forex/transactions/sales')}}"><i class="bx bx-right-arrow-alt"></i>Sales</a>
                        </li>
                        <li> <a href="{{url('forex/transactions/purchases')}}"><i class="bx bx-right-arrow-alt"></i>Purchases</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-cabinet'></i>
                </div>
                <div class="menu-title">Manage Accounts</div>
            </a>
            <ul>
                <li> <a href="{{url('forex/accounts')}}"><i class="bx bx-right-arrow-alt"></i>My Accounts</a>
                </li>
                <li> <a href="{{url('forex/accounts/balances')}}"><i class="bx bx-right-arrow-alt"></i>Ending Balances</a>
                </li>
                <li> <a href="{{url('forex/accounts/transfers')}}"><i class="bx bx-right-arrow-alt"></i>Inter-Account transfers</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-coin-stack'></i>
                </div>
                <div class="menu-title">Manage capital</div>
            </a>
            <ul>
                <li> <a href="{{url('forex/capital')}}"><i class="bx bx-right-arrow-alt"></i>Capital Transactions</a>
                </li>
                <li> <a href="{{url('forex/capital/deposit')}}"><i class="bx bx-right-arrow-alt"></i>Deposit capital</a>
                </li>
                <li> <a href="{{url('forex/capital/withdraw')}}"><i class="bx bx-right-arrow-alt"></i>Withdraw capital</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{url('forex/currencies')}}">
                <div class="parent-icon"><i class="bx bx-money"></i>
                </div>
                <div class="menu-title">Currencies</div>
            </a>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon icon-color-11"><i class="bx bx-wallet"></i>
                </div>
                <div class="menu-title">My Expenditures</div>
            </a>
            <ul>

            <li> <a href="{{url('forex/expenditures')}}"><i class="bx bx-right-arrow-alt"></i>Expenditures</a>
            </li>
            <li> <a href="{{url('forex/losses')}}"><i class="bx bx-right-arrow-alt"></i>Losses</a>
            </li>
            </ul>
        </li>
        {{-- <li class="menu-label">Others</li> --}}

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Customers/Suppliers</div>
            </a>
            <ul>
                <li> <a href="{{url('forex/suppliers')}}"><i class="bx bx-right-arrow-alt"></i>Suppliers</a>
                </li>
                <li> <a href="{{url('forex/customers')}}"><i class="bx bx-right-arrow-alt"></i>Customers</a>
                </li>
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-briefcase-alt"></i>
                </div>
                <div class="menu-title">Manage Payments</div>
            </a>
            <ul>
                <li> <a href="{{url('forex/payments')}}"><i class="bx bx-right-arrow-alt"></i>Payment Lists</a>
                </li>
                <li> <a href="{{url('forex/payments/receive')}}"><i class="bx bx-right-arrow-alt"></i>Receive Payments</a>
                </li>
                <li> <a href="{{url('forex/payments/make')}}"><i class="bx bx-right-arrow-alt"></i>Make Payments</a>
                </li>
            </ul>
        </li>

     {{-- @role('superadministrator') --}}
        <li>
            <a href="{{url('forex/reports')}}">
                <div class="parent-icon"><i class="bx bx-file"></i>
                </div>
                <div class="menu-title">Reports</div>
            </a>
        </li>
        <li>
            <a href="{{route('users.index')}}">
                <div class="parent-icon"><i class="bx bx-user-plus"></i>
                </div>
                <div class="menu-title">Users</div>
            </a>
        </li>
        <li>
            <a href="https://support.ripontechug.co" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
     {{-- @endrole --}}
    </ul>
    <!--end navigation-->
</div>

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <title>@yield('page_title', setting('admin.title') . " - " . setting('admin.description'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="assets-path" content="{{ route('voyager.voyager_assets') }}"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
   

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif



    <!-- App CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">

    @yield('css')
    @if(__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif

    <!-- Few Dynamic Styles -->
    <style type="text/css">
        .voyager .side-menu .navbar-header {
            background:{{ config('voyager.primary_color','#22A7F0') }};
            border-color:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .widget .btn-primary{
            border-color:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .widget .btn-primary:focus, .widget .btn-primary:hover, .widget .btn-primary:active, .widget .btn-primary.active, .widget .btn-primary:active:focus{
            background:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .voyager .breadcrumb a{
            color:{{ config('voyager.primary_color','#22A7F0') }};
        }

        .counter {
    background-color:#f5f5f5;
    padding: 20px 0;
    border-radius: 5px;
}

.count-title {
    font-size: 40px;
    font-weight: normal;
    margin-top: 10px;
    margin-bottom: 0;
    text-align: center;
}

.count-text {
    font-size: 13px;
    font-weight: normal;
    margin-top: 10px;
    margin-bottom: 0;
    text-align: center;
}

.fa-2x {
    margin: 0 auto;
    float: none;
    display: table;
    color: #4ad1e5;
    font-size: xx-large;
}
    </style>

    @if(!empty(config('voyager.additional_css')))<!-- Additional CSS -->
        @foreach(config('voyager.additional_css') as $css)<link rel="stylesheet" type="text/css" href="{{ asset($css) }}">@endforeach
    @endif

    @yield('head')
</head>

<body class="voyager @if(isset($dataType) && isset($dataType->slug)){{ $dataType->slug }}@endif">
@php

@endphp
<div id="voyager-loader">
    <?php $admin_loader_img = Voyager::setting('admin.loader', ''); ?>
    @if($admin_loader_img == '')
        <img src="{{ voyager_asset('images/logo-icon.png') }}" alt="Voyager Loader">
    @else
        <img src="{{ Voyager::image($admin_loader_img) }}" alt="Voyager Loader">
    @endif
</div>

<?php
if (\Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'http://') || \Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'https://')) {
    $user_avatar = Auth::user()->avatar;
} else {
    $user_avatar = Voyager::image(Auth::user()->avatar);
}
?>

<div class="app-container">
    <div class="fadetoblack visible-xs"></div>
    <div class="row content-container">
        @include('voyager::dashboard.navbar')
        @include('voyager::dashboard.sidebar')
        <script>
            (function(){
                    var appContainer = document.querySelector('.app-container'),
                        sidebar = appContainer.querySelector('.side-menu'),
                        navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                        loader = document.getElementById('voyager-loader'),
                        hamburgerMenu = document.querySelector('.hamburger'),
                        sidebarTransition = sidebar.style.transition,
                        navbarTransition = navbar.style.transition,
                        containerTransition = appContainer.style.transition;

                    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
                    appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                    navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

                    if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] == 'true') {
                        appContainer.className += ' expanded no-animation';
                        loader.style.left = (sidebar.clientWidth/2)+'px';
                        hamburgerMenu.className += ' is-active no-animation';
                    }

                   navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
                   sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
                   appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
            })();
        </script>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body padding-top">
                @yield('page_header')
                <div id="voyager-notifications"></div>
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('voyager::partials.app-footer')

<!-- Javascript Libs -->


<script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script>

<script>
    @if(Session::has('alerts'))
        let alerts = {!! json_encode(Session::get('alerts')) !!};
        helpers.displayAlerts(alerts, toastr);
    @endif

    @if(Session::has('message'))

    // TODO: change Controllers to use AlertsMessages trait... then remove this
    var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
    var alertMessage = {!! json_encode(Session::get('message')) !!};
    var alerter = toastr[alertType];

    if (alerter) {
        alerter(alertMessage);
    } else {
        toastr.error("toastr alert-type " + alertType + " is unknown");
    }
    @endif
</script>
@include('voyager::media.manager')
@yield('javascript')
@stack('javascript')
@if(!empty(config('voyager.additional_js')))
    @foreach(config('voyager.additional_js') as $js)<script type="text/javascript" src="{{ asset($js) }}"></script>@endforeach
@endif

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">




<script>
         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ route('userdata') }}',
               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'name', name: 'Zone Name' },
                         { data: 'email', name: 'User Email' },
                         { data: 'display_name', name: 'User Role' },
                         { data: 'action', name: 'Actions' },              
                        
                     ]
            });
         });






         @if(Route::current()->getName()=='ledger')

         $(function() {

            var fromdate="{{$fromdate}}";
            var todate="{{$todate}}";
            var userid="{{$userid}}";
               $('#ledgertable').DataTable({
               processing: true,
               serverSide: true,
                ajax: {
                        url: '{{ route('ledgerdata') }}',
                        type: "get",
                        data: function (d) {
                              d.fromdate = fromdate;
                              d.todate = todate;
                              d.userid=userid;
                    },
                    beforeSend: function() {
   
                       // alert(fromdate+"////"+todate);
                    },
                },

               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'date', name: 'Date' },
                        { data: 'description', name: 'Description' },
                         { data: 'increase', name: 'Deposit' },
                         { data: 'decrease', name: 'Withdraw' },
                         { data: 'balance', name: 'Balance' },
             
                        
                     ],
                     dom: 'Bfrtip',
                      buttons: [
                              'excel', 'csv', 'pdf', 'copy'
                            ],
            });
         });

@endif


@if(Route::current()->getName()=='withdrawal')

         $(function() {
               $('#withdrawaltable').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ route('withdrawaldata') }}',
               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'name', name: 'User Name' },
                         { data: 'amount_requested', name: 'Requested Amount' },
                         { data: 'currentstatus', name: 'Status' },
                         { data: 'action', name: 'Actions' },              
                        
                     ],

            });
         });

@endif




@if(Route::current()->getName()=='deposit')

         $(function() {
             var fromdate="{{$fromdate}}";
            var todate="{{$todate}}";
               $('#deposittable').DataTable({
               processing: true,
               serverSide: true,
                ajax: {
                        url: '{{ route('depositdata') }}',
                        type: "get",
                        data: function (d) {
                              d.fromdate = fromdate;
                              d.todate = todate;
                    },
                },
               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'name', name: 'User Name' },
                         { data: 'transactiontype', name: 'Transaction Type' },
                         { data: 'amount', name: 'Amount' },
                         { data: 'date', name: 'Date' },  
                         { data: 'time', name: 'Time' },              
                        
                     ],
                    dom: 'Bfrtip',
                      buttons: [
                              'excel', 'csv', 'pdf', 'copy'
                            ],
            });
         });

@endif






@if(Route::current()->getName()=='withdraw')

         $(function() {

            var fromdate="{{$fromdate}}";
            var todate="{{$todate}}";
               $('#withdrawtable').DataTable({
               processing: true,
               serverSide: true,
                ajax: {
                        url: '{{ route('withdrawdata') }}',
                        type: "get",
                        data: function (d) {
                              d.fromdate = fromdate;
                              d.todate = todate;
                    },
                    beforeSend: function() {
   
                       // alert(fromdate+"////"+todate);
                    },
                },

               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'name', name: 'User Name' },
                         { data: 'transactiontype', name: 'Transaction Type' },
                         { data: 'amount', name: 'Amount' },
                         { data: 'date', name: 'Date' },  
                         { data: 'time', name: 'Time' },              
                        
                     ],
                     dom: 'Bfrtip',
                      buttons: [
                              'excel', 'csv', 'pdf', 'copy'
                            ],
            });
         });

@endif





@if(Route::current()->getName()=='allbets')
          $(function() {
               $('#allbetstable').DataTable({
               processing: true,
               serverSide: true,
                 ajax: {
                        url: '{{ route('showallbets') }}',
                        type: "get",
                        data: function (d) {
                              d.number = {{$number}};
                              d.id = {{$livegameid}};
                    },
                },

               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'live_game_id', name: 'Live Game Id' },
                        { data: 'uname', name: 'User Name' }, 
                        { data: 'number', name: 'Number' },
                        { data: 'amount', name: 'Amount' },
                                      
                        
                     ],
            });
         });
@endif


@if(Route::current()->getName()=='notifications')
          $(function() {
               $('#notificationstable').DataTable({
               processing: true,
               serverSide: true,
                 ajax: '{{ route('notificationsdata') }}',

               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'title', name: 'Title' },
                        { data: 'message', name: 'Message' }, 
                        { data: 'created_at', name: 'Created At' },
                        { data: 'action', name: 'Actions' },
                                      
                        
                     ]
            });
         });
@endif



@if(Route::current()->getName()=='pushnotifications')
          $(function() {
               $('#notificationstable').DataTable({
               processing: true,
               serverSide: true,
                 ajax: '{{ route('pushnotificationsdata') }}',

               columns: [
                        {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                        },
                        { data: 'title', name: 'Title' },
                        { data: 'message', name: 'Message' }, 
                        { data: 'created_at', name: 'Created At' },
                        { data: 'action', name: 'Actions' },
                                      
                        
                     ]
            });
         });
@endif



@if(Route::current()->getName()=='voyager.dashboard')


(function ($) {
    $.fn.countTo = function (options) {
        options = options || {};
        
        return $(this).each(function () {
            // set options for current element
            var settings = $.extend({}, $.fn.countTo.defaults, {
                from:            $(this).data('from'),
                to:              $(this).data('to'),
                speed:           $(this).data('speed'),
                refreshInterval: $(this).data('refresh-interval'),
                decimals:        $(this).data('decimals')
            }, options);
            
            // how many times to update the value, and how much to increment the value on each update
            var loops = Math.ceil(settings.speed / settings.refreshInterval),
                increment = (settings.to - settings.from) / loops;
            
            // references & variables that will change with each update
            var self = this,
                $self = $(this),
                loopCount = 0,
                value = settings.from,
                data = $self.data('countTo') || {};
            
            $self.data('countTo', data);
            
            // if an existing interval can be found, clear it first
            if (data.interval) {
                clearInterval(data.interval);
            }
            data.interval = setInterval(updateTimer, settings.refreshInterval);
            
            // initialize the element with the starting value
            render(value);
            
            function updateTimer() {
                value += increment;
                loopCount++;
                
                render(value);
                
                if (typeof(settings.onUpdate) == 'function') {
                    settings.onUpdate.call(self, value);
                }
                
                if (loopCount >= loops) {
                    // remove the interval
                    $self.removeData('countTo');
                    clearInterval(data.interval);
                    value = settings.to;
                    
                    if (typeof(settings.onComplete) == 'function') {
                        settings.onComplete.call(self, value);
                    }
                }
            }
            
            function render(value) {
                var formattedValue = settings.formatter.call(self, value, settings);
                $self.html(formattedValue);
            }
        });
    };
    
    $.fn.countTo.defaults = {
        from: 0,               // the number the element should start at
        to: 0,                 // the number the element should end at
        speed: 1000,           // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,           // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null,        // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
    };
    
    function formatter(value, settings) {
        return value.toFixed(settings.decimals);
    }
}(jQuery));

jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });
  
  // start all the timers
  $('.timer').each(count);  
  
  function count(options) {
    var $this = $(this);
    options = $.extend({}, options || {}, $this.data('countToOptions') || {});
    $this.countTo(options);
  }
});


     
@endif



    </script>





 <script type="text/javascript">
    
   $(function() {

    $("#usersbox").hide();

    $('input[type=radio][name=sendtype]').change(function() {
    if (this.value == 'all') {

        $("#usersbox").hide();
         $("#users").prop("required",false);
       
    }
    else if (this.value == 'selected') {

         $("#usersbox").show();
         $("#users").prop("required",true);
        
    }
});



   });


 </script>






</body>
</html>

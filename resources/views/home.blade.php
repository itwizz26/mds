@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="dash-left">{{ __('Dashboard') }}</div>
                    <div class="dash-right">
                        @if (Auth::check())
                            <a class="btn btn-primary" href="{{ URL::to('/home/pdf') }}">
                                Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    @if (Auth::check())
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($calendar ?? '')
                            <table width="100%">
                                <tr>
                                    <td class="cal-date"><h2>Date</h2></td>
                                    <td class="text-right"><h2>Name of Holiday</h2></td>
                                </tr>
                                <tr><td colspan="2"><hr /></td></tr>

                                @foreach( $calendar as $cal)
                                    <tr>
                                        <td class="cal-date">
                                            {{ $cal['date'] }}
                                        </td>
                                        <td class="text-right">{{ $cal['name'] }}</td>
                                    </tr>

                                @endforeach

                            </table>
                        @endif
                    @else
                        <p>
                            Please first run the the <i><code>php artisan holidays:fetch</code></i> command and then login or 
                            register to download the South African public holidays in PDF format
                        </p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

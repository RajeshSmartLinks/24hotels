@extends('layouts.flutter_app.master')

@section('content')

    <section id="services" class="services section-bg">
        <div class="container">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-bold-300 text-center" colspan="2"><img
                                src="{{asset('frontEnd/images/success.png')}}"/> Success
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Reference No</td>
                        <td>{{$data['reference_no']}}</td>
                    </tr>
                    <tr>
                        <td>Payment Id</td>
                        <td>{{$data['payment_id']}}</td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td>{{$data['currency_code']}} {{$data['paid_amount']}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        @if(isset($data['from']) && $data['from'] == 'hotel' && $data['status'] == 'booking pending')
                        <td> Booking Is In Progress you will recieve email in 5 min</td>
                        @else
                        <td>{{$data['status']}}</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection

@section('extra-script')
    @if(isset($data['from']) && $data['from'] == 'hotel')
    <script type="text/javascript">
        var  refId = "{{$data['reference_no']}}" ;
            // In order to call window.flutter_inappwebview.callHandler(handlerName <String>, ...args)
            // properly, you need to wait and listen the JavaScript event flutterInAppWebViewPlatformReady.
            // This event will be dispatched as soon as the platform (Android or iOS) is ready to handle the callHandler method.
            window.addEventListener("flutterInAppWebViewPlatformReady", function(event) {
                // call flutter handler with name 'mySum' and pass one or more arguments
                window.flutter_inappwebview.callHandler('24flightsHotels', refId).then(function(result) {
                    // get result from Flutter side. It will be the number 64.
                    console.log(result);
                });
            });
        </script>
    @else
    <script type="text/javascript">
        var  refId = "{{$data['reference_no']}}" ;
            // In order to call window.flutter_inappwebview.callHandler(handlerName <String>, ...args)
            // properly, you need to wait and listen the JavaScript event flutterInAppWebViewPlatformReady.
            // This event will be dispatched as soon as the platform (Android or iOS) is ready to handle the callHandler method.
            window.addEventListener("flutterInAppWebViewPlatformReady", function(event) {
                // call flutter handler with name 'mySum' and pass one or more arguments
                window.flutter_inappwebview.callHandler('24flightsChannel', refId).then(function(result) {
                    // get result from Flutter side. It will be the number 64.
                    console.log(result);
                });
            });
        </script>
    @endif

@endsection

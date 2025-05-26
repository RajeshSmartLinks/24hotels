@extends('admin.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <x-admin-breadcrumb :title="$titles['title']"></x-admin-breadcrumb>
            </div>
            <div class="content-body">
                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                
                               
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Site Name</th>
                                                    <th>Popup Image</th>
                                                    <th>Popup Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($settings) > 0)
                                                    @foreach($settings as $setting)
                                                    <?php //dd($setting);?>
                                                        <tr>
                                                            <td>{{$setting->site_name}} </td>
                                                            <td>{{$setting->pop_up_status}} </td>
                                                        
                                                            <td class="product-img"><img
                                                                    src="{{$setting->pop_up_image ?  asset('uploads/ads/'.$setting->pop_up_image) : $noImage}} "
                                                                    width="50"/>
                                                            </td>
                                                         
                                                            <td>
                                                                
                                                                @can('settings-edit')
                                                                    <a href="{{ route('setting.edit', $setting->id) }}"><i
                                                                            class="feather icon-edit"></i> Edit</a> 
                                                                @endcan

                                                             
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="3">No Record(s)</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- List Datatable Ends -->
            </div>
        </div>
    </div>


@endsection


@section('extrascript')
    <script>
        $('.zero-configuration').DataTable(
            {
                "displayLength": 50,
            }
        );

        @if(session('success'))
        toastr.success('{{session('success')}}', 'success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'error');
        @endif
    </script>
@endsection
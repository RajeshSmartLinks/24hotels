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

                <!-- invoice functionality start -->
                <section class="invoice-print mb-1">
                    <div class="row">
                        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">&nbsp;</fieldset>
                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                            @can('faq-view')
                            <a href="{{route('offers.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-list"></i>&nbsp;Go to List</a>
                            </a>
                            @endcan
                        </div>
                    </div>
                </section>

                <!-- Adding Form -->
                <section id="multiple-column-form" class="input-validation">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        {{-- <x-admin-error-list-show></x-admin-error-list-show> --}}


                                        <form class="form-horizontal" action="{{route('faq.update', $editFaq->id)}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control @error('question_en') is-invalid @enderror" placeholder="Question (English) *"
                                                                   name="question_en"  required value="{{$editFaq->question_en}}">
                                                                   @error('question_en')
                                                                   <span class="invalid-feedback" role="alert">
                                                                       <strong>{{ $message }}</strong>
                                                                   </span>
                                                               @enderror
                                                            <label for="first-name-column">Question (English) *</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text"  class="form-control  @error('question_ar') is-invalid @enderror" placeholder="Question (Arabic) *" name="question_ar" required value="{{$editFaq->question_ar}}">
                                                            @error('question_ar')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="first-name-column">Question (Arabic) *</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="number" class="form-control @error('order') is-invalid @enderror" placeholder="order *"
                                                                name="order" required value="{{$editFaq->order}}">
                                                                @error('order')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            <label for="first-name-column">Sort order *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                                            <option value = "" >Select Status</option>
                                                            <option value="Active" {{$editFaq->status == 'Active' ? 'selected' : ''}}>{{ucfirst('Active')}}</option>
                                                            <option value="InActive" {{$editFaq->status == 'InActive' ? 'selected' : ''}}>{{ucfirst('InActive')}}</option>
                                                           
                                                          
                                                        </select>
                                                        @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="first-name-column">Status</label>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="form-label-group">
                                                            <textarea id="ckeditor_en" class="form-control @error('answer_en') is-invalid @enderror" rows="5" placeholder="Answer(English)" name="answer_en" required>{{$editFaq->answer_en}}</textarea>
                                                            @error('answer_en')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="first-name-column">Answer(English)</label>

                                                            
                                                        </div>
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class=" col-12">
                                                        <div class="form-label-group">
                                                            <textarea id="ckeditor_ar" class="form-control @error('answer_ar') is-invalid @enderror" rows="5" placeholder="Answer(Arabic)" name="answer_ar" required>{{$editFaq->answer_ar}}</textarea>
                                                            @error('answer_ar')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="first-name-column">Answer(Arabic)</label>

                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Adding Form Ends -->

            </div>
        </div>
    </div>

@endsection


@section('extrascript')

    <!-- Date Picker Scripts -->
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>

    <script src="{{asset('admin-assets/js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>

    

    <script>

        $('#valid_upto').pickadate({
            selectMonths: true,
            selectYears: 200,
            min: new Date(1910, 1, 1),
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd',
        });

        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif

      
    </script>
@endsection

@extends('addCookiesClient::layouts')
@section('content')
    <div class="col-lg container">
        

       
       
        <div class="d-flex justify-content-between align-items-center"> 
            <h1>{{ __('Add Website') }} </h1>
            <form method="get" id="domainform">
                {!! Form::label("domain", __('Domain'), ['class'=>'form-label']) !!}
                {!! Form::select("domain", $alldomains, request('domain')??'', ['class'=>'form-control','onchange'=>"submitForm()"]) !!}
           </form>
            <a href="{{ route('CookiesClient') }}" class="btn btn-success text-white float-end">{{ __('Back') }}</a>
          
        </div>
        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @elseif ($message = Session::get('success'))
            <div class="alert alert-success text-capitalize">
                {{ $message }}
            </div>
        @endif
        <div class="row">
           
            <div class="col-lg">
                {{ Form::open(['method' => 'post']) }}
                <div class="formwrap">
                    <div class="row g-0">
                        <div class="col-12 col-md-3 col-xl-2">
                            <ul class="list-group rounded-0" id="myTab" role="tablist">
                                <li class="list-group-item active" id="start-tab" data-bs-toggle="tab"
                                    data-bs-target="#start" role="tab" aria-controls="start" aria-selected="true">
                                    {{ __('Necessary') }}</li>
                                <li class="list-group-item" id="section-tab" data-bs-toggle="tab" data-bs-target="#section"
                                    role="tab" aria-controls="section" aria-selected="false">{{ __('Functional') }}</li>
                                <li class="list-group-item" id="banner-tab" data-bs-toggle="tab" data-bs-target="#banner"
                                    role="tab" aria-controls="banner" aria-selected="false">{{ __('Analytics') }}</li>
                                <li class="list-group-item" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta"
                                    role="tab" aria-controls="meta" aria-selected="false">{{ __('Performance') }}</li>
                                <li class="list-group-item" id="extra-tab" data-bs-toggle="tab" data-bs-target="#extra"
                                    role="tab" aria-controls="extra" aria-selected="false">{{ __('Advertisement') }}
                                </li>
                                <li class="list-group-item" id="extra1-tab" data-bs-toggle="tab" data-bs-target="#extra1"
                                role="tab" aria-controls="extra1" aria-selected="false">{{ __('Web Cookie') }}
                            </li>
                            </ul>
                        </div>
                        <div class="col-md">
                            <div class="tab-content p-3 border rounded-0" id="myTabContent">
                                <div class="tab-pane fade show active" id="start" role="tabpanel"
                                    aria-labelledby="start-tab">
                                    <div class="row">
                                        @if(!empty($necessaryDetail))
                                        @foreach ($necessaryDetail as $n)
                                            @php
                                                $ndetails = !empty($n->details) ? json_decode($n->details,true) : [];
                                            @endphp
                                            <div class="card mb-4">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('ID') }}</th>
                                                                {{-- <th>{{ __('Domain') }}</th> --}}
                                                                <th>{{ __('Duration') }}</th>
                                                                <th>{{ __('Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$ndetails['cookie_id']??''}}</td>
                                                                {{-- <td>{{$ndetails['domain_id']??''}}</td> --}}
                                                                <td>{{$ndetails['duration']??''}}</td>
                                                                <td><a href="javascript:void(0);" onclick="editModule({{ $n->id }});"
                                                                            class="btn btn-dark badge fw-normal text-decoration-none">{{ __('Edit') }}</a></td>
                                                            </tr>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!} <br>
                                                    {!! $ndetails['description']??'' !!}
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="section" role="tabpanel" aria-labelledby="section-tab">
                                    <div class="row">
                                        @if(!empty($functionalDetail))
                                        @foreach ($functionalDetail as $n)
                                            @php
                                                $ndetails = !empty($n->details) ? json_decode($n->details,true) : [];
                                            @endphp
                                            <div class="card mb-4">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('ID') }}</th>
                                                                {{-- <th>{{ __('Domain') }}</th> --}}
                                                                <th>{{ __('Duration') }}</th>
                                                                <th>{{ __('Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$ndetails['cookie_id']??''}}</td>
                                                                {{-- <td>{{$ndetails['domain']??''}}</td> --}}
                                                                <td>{{$ndetails['duration']??''}}</td>
                                                                <td><a href="javascript:void(0);" onclick="editModule({{ $n->id }});"
                                                                            class="btn btn-dark badge fw-normal text-decoration-none">{{ __('Edit') }}</a></td>
                                                            </tr>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!} <br>
                                                    {!! $ndetails['description']??'' !!}
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif

                                    </div>

                                </div>

                                <div class="tab-pane fade" id="banner" role="tabpanel" aria-labelledby="banner-tab">
                                    <div class="row">
                                        @if(!empty($analyticsDetail))
                                        @foreach ($analyticsDetail as $n)
                                            @php
                                                $ndetails = !empty($n->details) ? json_decode($n->details,true) : [];
                                            @endphp
                                            <div class="card mb-4">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('ID') }}</th>
                                                                {{-- <th>{{ __('Domain') }}</th> --}}
                                                                <th>{{ __('Duration') }}</th>
                                                                <th>{{ __('Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$ndetails['cookie_id']??''}}</td>
                                                                {{-- <td>{{$ndetails['domain']??''}}</td> --}}
                                                                <td>{{$ndetails['duration']??''}}</td>
                                                                <td><a href="javascript:void(0);" onclick="editModule({{ $n->id }});"
                                                                            class="btn btn-dark badge fw-normal text-decoration-none">{{ __('Edit') }}</a></td>
                                                            </tr>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!} <br>
                                                    {!! $ndetails['description']??'' !!}
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="meta" role="tabpanel" aria-labelledby="meta-tab">
                                    <div class="row">
                                        @if(!empty($performanceDetail))
                                        @foreach ($performanceDetail as $n)
                                            @php
                                                $ndetails = !empty($n->details) ? json_decode($n->details,true) : [];
                                            @endphp
                                            <div class="card mb-4">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('ID') }}</th>
                                                                {{-- <th>{{ __('Domain') }}</th> --}}
                                                                <th>{{ __('Duration') }}</th>
                                                                <th>{{ __('Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$ndetails['cookie_id']??''}}</td>
                                                                {{-- <td>{{$ndetails['domain']??''}}</td> --}}
                                                                <td>{{$ndetails['duration']??''}}</td>
                                                                <td><a href="javascript:void(0);" onclick="editModule({{ $n->id }});"
                                                                            class="btn btn-dark badge fw-normal text-decoration-none">{{ __('Edit') }}</a></td>
                                                            </tr>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!} <br>
                                                    {!! $ndetails['description']??'' !!}
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="extra" role="tabpanel" aria-labelledby="extra-tab">
                                    @if(!empty($advDetail))
                                        @foreach ($advDetail as $n)
                                            @php
                                                $ndetails = !empty($n->details) ? json_decode($n->details,true) : [];
                                            @endphp
                                            <div class="card mb-4">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('ID') }}</th>
                                                                {{-- <th>{{ __('Domain') }}</th> --}}
                                                                <th>{{ __('Duration') }}</th>
                                                                <th>{{ __('Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$ndetails['cookie_id']??''}}</td>
                                                                {{-- <td>{{$ndetails['domain']??''}}</td> --}}
                                                                <td>{{$ndetails['duration']??''}}</td>
                                                                <td><a href="javascript:void(0);" onclick="editModule({{ $n->id }});"
                                                                            class="btn btn-dark badge fw-normal text-decoration-none">{{ __('Edit') }}</a></td>
                                                            </tr>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!} <br>
                                                    {!! $ndetails['description']??'' !!}
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                </div>

                                <div class="tab-pane fade" id="extra1" role="tabpanel" aria-labelledby="extra1-tab">
                                    <div class="card mb-4">
                                            <div class="col-md-12">
                                                <table class="table w-100" id="webcookied">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('ID') }}</th>
                                                            <th>{{ __('Type') }}</th>
                                                            <th>{{ __('Action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                   
                                </div>
                                
                                <a href="#" class="btn btn-sm btn-primary createbutton" data-bs-toggle="offcanvas"
                                data-bs-target="#moduleform" aria-controls="moduleform">
                                {{ __('Create') }}
                                </a>
                            </div>
                        </div>
                    </div>




                </div>
                {{ Form::close() }}
            </div>
        </div>


        <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="moduleform" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">{{ __('Create Cookie') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
    
    
                {!! Form::open(['route'=>'cookiesContentStore','method' => 'POST','id'=>'contentStore']) !!}
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::label('cookie_id', __('Cookie ID'), ['class' => 'form-label']) !!}
                            {!! Form::text('details[cookie_id]', null, ['class' => 'form-control', 'required','id'=>'cookie_id']) !!}
                        </div>
                     
                        <div class="col-md-4">
                            {!! Form::label('duration', __('Duration'), ['class' => 'form-label']) !!}
                            {!! Form::text('details[duration]', null, ['class' => 'form-control', 'required','id'=>'duration']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('category', __('Category'), ['class' => 'form-label']) !!}
                            {!! Form::select('category',$categories,'', ['class' => 'form-control', 'required','id'=>'category']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                    {{ Form::textarea('details[description]', null, ['class' => 'form-control', 'rows' => 2, 'cols' => 40,'id'=>'description']) }}
                </div>
    
                {!! Form::hidden('id', null, ['id' => 'id']) !!}
                {!! Form::hidden('domain', request('domain')??'', ['id' => 'domain']) !!}
                {!! Form::hidden('user_id', $user_id??'', ['id' => 'user_id']) !!}
                <button type="submit" name="action" value="Save" class="btn btn-primary"
                    id="submit">{{ __('Save') }}</button>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/admin.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <link href="/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/ckeditor/ckeditor/ckeditor.js"></script>

    <script src="/ckfinder/ckfinder.js"></script>
    <script>
        // var editor = CKEDITOR.replace('description');
        // CKFinder.setupCKEditor(editor);

        var moduleform = document.getElementById('moduleform')
        $('.createbutton').on('click', function() {
            $('#contentStore')[0].reset();
        });


        function editModule(moduleId) {
        
            $.ajax({
                url: '/cookieContent/' + moduleId+'/edit',
                type: 'GET',
                success: function(response) {
                    $('#id').val(response['id']);
                    $('#user_id').val(response['user_id']);
                    $('#cookie_id').val(response['details']['cookie_id']);
                    $('#duration').val(response['details']['duration']);
                    $('#category').val(response['category_id']);
                    $('#description').val(response['details']['description']);
                    $('#submit').val('Update').text('Update');
                    $('#moduleform').offcanvas('show'); // Show the off-canvas form
                    // $('.createbutton').data('action', 'edit')[0].click();
                    // $('.createbutton')[0].click();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function submitForm() {
            // Get the form element
            const form = document.getElementById('domainform');
            // Submit the form
            form.submit();
        }

        var selcomain = "{{request('domain')}}";
        if(selcomain){
            var table;
        table = $('#webcookied').DataTable({
            processing: true,
            serverSide: true,
            // ajax: "{{ route('webcookiedatatable') }}",
            ajax: {
            url: "{{ route('webcookiedatatable') }}",
            data: { 'domain': selcomain }, // Pass your custom value as a parameter
            },
            columns: [
                {
                    data: 'id'
                },
                {
                    data: 'type'
                },
                {
                    data: 'action'
                },
            ],
            "order": [
                [1, "desc"]
            ],
            'columnDefs': [{
                'targets': [2],
                'orderable': false,
            }],
        });
        }
        
    </script>
@endpush

@extends('addCookiesClient::layouts')
@section('content')
    <div class="col-lg container">
     

        <div class="d-flex justify-content-between align-items-center"> 
            <h1>{{ __('Website Cookie') }} </h1>
            <a href="{{ route('createCookieContent',$data->user_id) }}" class="btn btn-success text-white float-end">{{ __('Back') }}</a>
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
        <div class="formwrap card p-5">
            @if (!empty($data))

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            {!! Form::label('type', __('Type'), ['class' => 'form-label']) !!}
                            {!! Form::text('type', $data->type??'', ['class' => 'form-control', 'id' => 'website_name','readonly']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            {!! Form::label('domain', __('domain'), ['class' => 'form-label']) !!}
                            {!! Form::text('domain', $data->getDomain->domain??'', ['class' => 'form-control', 'id' => 'website_name','readonly']) !!}
                        </div>
                    </div>
                    @php
                        $details = !empty($data->details) ? json_decode($data->details,true) : [];
                    @endphp
                    @foreach ($details as $k=>$rowss)
                    <div class="col-md-4">
                        <div class="form-group mb-3">
    
                            {!! Form::label($k, __($k), ['class' => 'form-label']) !!}
                            {!! Form::text($k, $rowss, ['class' => 'form-control','readonly']) !!}
    
                        </div>
                    </div>
                    @endforeach
                </div>
      
            @endif
          
        </div>

        </div>
    </div>
   @endsection
   @push('scripts')
        <script src="js/jquery.min.js"></script>
        <link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery.dataTables.min.js"></script>

        <script>
          $('#my-table').DataTable({
            'columnDefs': [ {
                'targets': [4], 
                'orderable': false, 
            }]
        });
        </script>
   @endpush

@extends('addCookiesClient::layouts')
@section('content')
    <div class="col-lg container">
      
       

        <div class="d-flex justify-content-between align-items-center">
            <h1>{{ __('Add Website') }} </h1>
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

        <div class="card p-4">
            {!! Form::open(['route' => 'storeCookiesClient', 'method' => 'POST', 'id' => 'adduser']) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">

                        {!! Form::label('website_name', __('Website Name'), ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'id' => 'website_name']) !!}

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-3">
                        {!! Form::label('email', __('Email'), ['class' => 'form-label']) !!}
                        {!! Form::email('email', null, ['class' => 'form-control', 'required', 'id' => 'email']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    {!! Form::label('company_key', __('Company Key'), ['class' => 'form-label']) !!}
                    <div class="input-group">
                        {!! Form::text('company_key', null, ['class' => 'form-control', 'required', 'id' => 'company_key']) !!}
                     
                        <button class="btn btn-primary" onclick="generatekey()"
                            type="button">{{ __('Generate Key') }}</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" id="addMoreDomainButton" class="btn btn-success text-white"><i
                            class="flaticon-plus"></i></button>
                    <div class="form-group mb-3" id="addmore">
                        {!! Form::label('domain1', __('Domain'), ['class' => 'form-label']) !!}
                        {!! Form::text('domain[1]', null, ['class' => 'form-control', 'required', 'id' => 'domain1']) !!}
                    </div>

                </div>

            </div>
           
            <div class="col-md-4 pt-4">
                <button type="submit" class="btn btn-primary btn-xs">{{ __('Submit') }}</button>
            </div>
            
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script>
       let domainCounter = 1;

       $("#addMoreDomainButton").click(function() {
            domainCounter++;

            var html = '<div class="form-group mb-3" id="'+domainCounter+'">';
                html +='<label class="form-label domain'+domainCounter+'">Domain</label><div class="d-flex content-justify-between align-items-center">';
                html+='<input type="text" name="domain['+domainCounter+']" class="form-control">';
                html+='  <a class="deletediv btn btn-danger text-white btn-xs" data-id="'+domainCounter+'"><i class="flaticon-delete"></i></a>';
                html+='</div></div>';

                $('#addmore').append(html);
        });
        
        $(document).on('click','.deletediv',function(){
            var id = $(this).data('id');
            $('#'+id).remove();
        });

        $(document).ready(function() {
            $('#adduser').validate();
        });

        function generatekey() {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < 40) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            document.getElementById('company_key').value = result;
        }
    </script>
@endpush

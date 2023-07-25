@extends('addCookiesClient::layouts')
@section('content')
    <div class="col-lg container">
        
        <div class="d-flex justify-content-between align-items-center"> 
            <h1>{{ __('Edit Website') }} </h1>
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
            
            {!! Form::open(['route' => ['updateCookiesClient',$details->id], 'method' => 'POST', 'id' => 'adduser']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="website_name">{{__('Website Name')}}</label>
                            <input type="text" name="name" placeholder="Website name" id="website_name" class="form-control" value="{{$details->name??''}}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="email">{{__('Email')}}</label>
                            <input type="text" name="email" placeholder="Email" id="email" class="form-control" value="{{$details->email??''}}" required>
                        </div>
                    </div>
            
                  
                    <div class="col-md-4">
                        <label for="domain">{{__('Company Key')}}</label>
                        <div class="input-group">
                            <input placeholder="Company APIKEY" class="form-control" id="company_key" name="company_key" type="text" value="{{$alldomains[0]['company_key']??''}}" required>
                            <button class="btn btn-primary" onclick="generatekey()" type="button">{{__('Generate Key')}}</button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <button type="button" id="addMoreDomainButton" class="btn btn-success text-white"><i
                                class="flaticon-plus"></i></button>
                        <div class="form-group mb-3" id="addmore">
                         
                            
                          
                            @if (!empty($alldomains))
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($alldomains as $k=>$val)
                                @php
                                    $lastkey = $k;
                                @endphp
                                    <div class="form-group mb-3" id="{{$k}}">
                                        {!! Form::label('domain'.$k, __('Domain'), ['class' => 'form-label']) !!}
                                        <div class="d-flex content-justify-between align-items-center">
                                            {!! Form::text('domain['.$k.']', $val->domain, ['class' => 'form-control', 'required', 'id' => 'domain1']) !!}
                                            @if ($count>1)
                                                <a class="deletediv btn btn-danger text-white btn-xs" data-id="{{$k}}"><i class="flaticon-delete"></i></a> 
                                            @endif
                                        </div>
                                        
                                        @php
                                            $count++;
                                        @endphp
                                    </div>
                                @endforeach
                            @endif
                           
                            
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
        <script src="/js/jquery.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#adduser').validate();
            });
            
            function generatekey(){
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
            
                let domainCounter = {{$lastkey??'1'}};

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
        </script>
   @endpush

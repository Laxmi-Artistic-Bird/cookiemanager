@extends('addCookiesClient::layouts')
@section('content')
    <div class="col-lg container">
        <div class="d-flex justify-content-between align-items-center"> 
            <h1>{{ __('Cookie Website') }} </h1>
            <a href="{{ route('createCookiesClient') }}" class="btn btn-success text-white float-end">{{ __('Create') }}</a>
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
      
        <div class="formwrap">
            <table class="table table-hover" id="my-table">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">{{ __('Website Name') }}</th>
                        <th scope="col">{{ __('Email') }}</th>
                        <th scope="col">{{ __('Company Key') }}</th>
                        <th scope="col" width="230px">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>

            </table>
        </div>

        </div>
    </div>
   @endsection
   @push('scripts')
        <script src="js/jquery.min.js"></script>
        <link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery.dataTables.min.js"></script>

        <script>
        

        var table;
        table = $('#my-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('CookiesClientdatatable') }}",
            columns: [
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'company_key',
                },
                {
                    data: 'action'
                },
            ],
            "order": [
                [1, "desc"]
            ],
            'columnDefs': [{
                'targets': [2,3],
                'orderable': false,
            }],
        });
        </script>
   @endpush

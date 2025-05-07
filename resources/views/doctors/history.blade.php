@extends("layouts.doctors")
@section('content')

    <style>

        .card-title {
            font-size: 1.25rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            border-bottom: 2px solid #ddd;
            font-weight: 600;
        }

        .table tbody tr {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table tbody td {
            vertical-align: middle;
        }

        img.rounded-circle {
            border: 2px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress {
            background-color: #e9ecef;
            border-radius: 10px;
        }

        .progress-bar {
            border-radius: 10px;
        }

    </style>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Retseptlar tarixi</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">Bemor FISH</th>
                                <th class="border-bottom-0">Passporti</th>
                                <th class="border-bottom-0">Mazili</th>
                                <th class="border-bottom-0">Dori nomi</th>
                                <th class="border-bottom-0">Miqdori</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($history as $val)
                                <tr>
                                    <td>{{$val->patient->FISH}}</td>
                                    <td>{{$val->patient->passport}}</td>
                                    <td>{{$val->pharmacist->address}}</td>
                                    <td>{{$val->medicine->name}}</td>
                                    <td>{{$val->quantity}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

@endsection

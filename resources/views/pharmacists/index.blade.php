@extends("layouts.pharmacists")
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
                    <h5 class="card-title fw-semibold mb-4">Bemorlar</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">Bemor FISH</th>
                                <th class="border-bottom-0">Passporti</th>
                                <th class="border-bottom-0">Mazili</th>
                                <th class="border-bottom-0">Dori nomi</th>
                                <th class="border-bottom-0">Miqdori</th>
                                <th class="border-bottom-0">Narxi</th>
                                <th class="border-bottom-0">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $val)
                                <td>{{$val->patient->FISH}}</td>
                                <td>{{$val->patient->passport}}</td>
                                <td>{{$val->patient->address}}</td>
                                <td>{{$val->medicine->name}}</td>
                                <td>{{$val->quantity}}</td>
                                <td>{{$val->quantity * $val->medicine->price}} so'm</td>
                                <th>
                                    <button onclick="completeWork({{$val->id}}, '{{$val->medicine->name}}', {{$val->quantity}}, {{$val->quantity * $val->medicine->price}})" class="btn btn-primary">Yakunlash</button>
                                </th>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    <script>
        function completeWork(id, name, quanity, price){
            Swal.fire({
                title: "Yakunlash",
                text: name + "(" + quanity + "): " + price + "so'm",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yakunlash!",
                cancelButtonText: "Bekor qilish",
                confirmButtonColor: "#335bdd",
                cancelButtonColor: "#cccccc",
                preConfirm: () => {
                    return fetch(`/pharmacists/completed/${id}`, {
                        method: "GET",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                return data;
                            } else {
                                Swal.showValidationMessage(data.message);
                            }
                        })
                        .catch(error => {
                            Swal.showValidationMessage("Xatolik yuz berdi: " + error);
                        });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Yakunlandi!", "success")
                        .then(() => {
                            window.location.reload();
                        });
                }
            });
        }
    </script>

@endsection

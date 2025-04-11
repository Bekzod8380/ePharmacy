@extends("layouts.main")
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
                                <th class="border-bottom-0">Ma'lumotlar</th>
                                <th class="border-bottom-0">Bepul dorilar</th>
                                <th class="border-bottom-0">Doktorga murojaat</th>
                                <th class="border-bottom-0">Pulli dorilar</th>
                                <th class="border-bottom-0">Oxirgi ko'rik</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <p class="fw-bold mb-0">Akmal Xudoyberdiyev</p>
                                        </div>
                                    </div>
                                </td>
                                <td>15</td>
                                <td>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 60%;"></div>
                                    </div>
                                </td>
                                <td>23</td>
                                <td>Yanvar 15, 2024</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <p class="fw-bold mb-0">Zarina Tursunova</p>
                                        </div>
                                    </div>
                                </td>
                                <td>12</td>
                                <td>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-danger" style="width: 30%;"></div>
                                    </div>
                                </td>
                                <td>19</td>
                                <td>Noyabr 1, 2023</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

@endsection

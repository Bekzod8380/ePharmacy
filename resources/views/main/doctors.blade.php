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
                <h5 class="card-title fw-semibold mb-4">Shifokorlar</h5>
                <div class="btn-add-box text-end">
                    <button id="add_doctor" class="btn btn-success">Shifokor qo'shish</button>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">FISH</th>
                            <th class="border-bottom-0">Email</th>
                            <th class="border-bottom-0">Amallar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($doctors as $doctor)
                        <tr id="doctor-{{ $doctor->id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-0">{{ $doctor->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $doctor->email }}</td>
                            <td>
                                <button onclick="deleteDoctor({{ $doctor->id }})" class="btn btn-danger">O‘chirish</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <script>
        document.getElementById("add_doctor").addEventListener("click", function () {
            Swal.fire({
                title: "Shifokor qo'shish",
                html: `
                    <form id="doctorForm">
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="text" name="name" id="name" class="form-control" required placeholder="Ism Familiya">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="email" name="email" id="email" required class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="password" name="password" id="password" required class="form-control" placeholder="Parol">
                            </div>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: "Saqlash",
                preConfirm: () => {
                    const name = document.getElementById("name").value;
                    const email = document.getElementById("email").value;
                    const password = document.getElementById("password").value;

                    if (!name || !email || !password) {
                        Swal.showValidationMessage("Barcha maydonlarni to'ldiring!");
                        return false;
                    }

                    return fetch("/doctor", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ name, email, password })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Xatolik: ${error}`);
                        });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Muvaffaqiyatli saqlandi!", "", "success")
                    .then(() => {
                        window.location.reload();
                    });
                }
            });
        });
    </script>

    <script>
        function deleteDoctor(id) {
            Swal.fire({
                title: "Ishonchingiz komilmi?",
                text: "Bu amalni ortga qaytarib bo‘lmaydi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ha, o‘chir!",
                cancelButtonText: "Bekor qilish",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                preConfirm: () => {
                    return fetch(`/doctor/${id}`, {
                        method: "DELETE",
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
                    Swal.fire("O‘chirildi!", "Shifokor ma’lumotlari o‘chirildi.", "success")
                        .then(() => {
                            window.location.reload(); // Sahifani yangilash
                        });
                }
            });
        }
    </script>


@endsection

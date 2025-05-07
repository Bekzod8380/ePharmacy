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
                    <h5 class="card-title fw-semibold mb-4">Bemorlar</h5>
                    <form method="GET" action="" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Qidirish..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Qidirish</button>
                        </div>
                    </form>
                    <div class="justify-content-end">
                        <button id="add_patient" class="btn btn-success">Qo'shish</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">FISH</th>
                                <th class="border-bottom-0">Passport</th>
                                <th class="border-bottom-0">Telefon raqami</th>
                                <th class="border-bottom-0">Mazili</th>
                                <th class="border-bottom-0">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($patients as $val)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-3">
                                                <p class="fw-bold mb-0">{{$val->FISH}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$val->passport}}</td>
                                    <td>{{$val->phone}}</td>
                                    <td>{{$val->address}}</td>
                                    <td>
                                        <button onclick="recipe({{$val}})" class="btn btn-primary">Retsept yozish</button>
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
        document.getElementById("add_patient").addEventListener("click", function () {
            Swal.fire({
                title: "Bemorni ro'yhatdan o'tkazish",
                html: `
                    <form id="doctorForm">
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="text" name="FISH" id="FISH" class="form-control" required placeholder="Familiya Ism Sharif">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="text" name="passport" id="passport" class="form-control"
                                       required placeholder="Passport"
                                       pattern="[A-Z]{2}[0-9]{7}"
                                       title="2 ta katta harf va 7 ta raqamdan iborat bo‘lishi kerak. Masalan: AA1234567">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required placeholder="Tug'ilgan kuni">
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col mb-3">
                                <select name="gender" id="gender" class="form-control" required>
                                    <option></option>
                                    <option value="male">Erkak</option>
                                    <option value="female">Ayol</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="text" name="address" id="address" class="form-control" required placeholder="Yashash manzili">
                            </div>
                        </div>


                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="tel" name="phone" id="phone" class="form-control"
                                       required placeholder="Telefon raqam (masalan: +998901234567)"
                                       pattern="^\+998\d{9}$"
                                       title="Telefon raqami +998 bilan boshlanib, jami 13 ta belgidan iborat bo‘lishi kerak. Masalan: +998901234567">
                            </div>
                        </div>

                    </form>
`,
                showCancelButton: true,
                confirmButtonText: "Saqlash",
                preConfirm: () => {
                    const FISH = document.getElementById("FISH").value.trim();
                    const passport = document.getElementById("passport").value.trim().toUpperCase();
                    const date_of_birth = document.getElementById("date_of_birth").value;
                    const gender = document.getElementById("gender").value;
                    const address = document.getElementById("address").value.trim();
                    const phone = document.getElementById("phone").value.trim();

                    const passportPattern = /^[A-Z]{2}\d{7}$/;
                    const phonePattern = /^\+998\d{9}$/;

                    if (!FISH || !passport || !date_of_birth || !gender || !address || !phone) {
                        Swal.showValidationMessage("Barcha maydonlarni to'ldiring!");
                        return false;
                    }

                    if (FISH.length < 3) {
                        Swal.showValidationMessage("FISH kamida 3 ta belgidan iborat bo‘lishi kerak!");
                        return false;
                    }

                    if (!passportPattern.test(passport)) {
                        Swal.showValidationMessage("Pasport formati noto‘g‘ri. Masalan: AA1234567");
                        return false;
                    }

                    const today = new Date().toISOString().split("T")[0];
                    if (date_of_birth > today) {
                        Swal.showValidationMessage("Tug‘ilgan sana hozirgi sanadan katta bo‘lishi mumkin emas!");
                        return false;
                    }

                    if (address.length < 5) {
                        Swal.showValidationMessage("Manzil kamida 5 ta belgidan iborat bo‘lishi kerak!");
                        return false;
                    }

                    if (!phonePattern.test(phone)) {
                        Swal.showValidationMessage("Telefon raqam formati noto‘g‘ri. Masalan: +998901234567");
                        return false;
                    }

                    return fetch("/patient", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ FISH, passport, date_of_birth, gender, address, phone })
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


        function recipe(data){

            console.log(data);

            Swal.fire({
                title: data.FISH + "ga retsept",
                html: `
                    <form>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <select name="medicine_id" id="medicine_id" class="form-control" required>
                                    <option></option>
                                    @foreach($medicine as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="number" name="quantity" id="quantity" class="form-control" required placeholder="Soni">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="number" class="form-control" required placeholder="Miqdori(gr, ml)">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <select name="pharmacist_id" id="pharmacist_id" class="form-control" required>
                                    <option></option>
                                    @foreach($pharmacists as $val)
                                        <option value="{{$val->id}}">{{$val->name}}({{$val->address}})</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
`,
                showCancelButton: true,
                confirmButtonText: "Saqlash",
                preConfirm: () => {
                    const user_id = {{\Illuminate\Support\Facades\Auth::user()->id}};
                    const patient_id = data.id;
                    const medicine_id = Number(document.getElementById("medicine_id").value);
                    const pharmacist_id = Number(document.getElementById("pharmacist_id").value);
                    const quantity = Number(document.getElementById("quantity").value);

                    return fetch("{{route('doctors.recipe')}}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ user_id, patient_id, medicine_id, pharmacist_id, quantity})
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


        }
    </script>

@endsection

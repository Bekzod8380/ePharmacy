@extends("layouts.main")
@section("content")

    <style>
        .btn_add{
            background:#0a53be;
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            color: #fff;
        }
        #recipe-form{
            width: 80%;
        }
        #popup {
            width: 30em;
            background: #FFF;
            margin: 5em auto;
            transition: opacity 0.5s ease-in-out;
            display: none;
            border: none;
            border-radius: 15px;
        }

        #popup[open] {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40vh;
        }

        #popup form {
            padding: 1em;
        }

        #popup label {
            display: block;
            margin-bottom: 0.5em;
        }

        #popup input[type="email"] {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 1em;
        }

        #popup button {
            padding: 0.5em 1em;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        #popup button:hover {
            background-color: #0056b3;
        }
        .add_popup{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 40vh;
        }
        .input-group{
            margin-bottom: 10px;
        }
        .btn-close_add{
            position: absolute !important;
            z-index: 9 !important;
            right: 10px !important;
            top: 10px !important;
        }
    </style>

    <div class="container-fluid">
        <div class="btn-add-box">
            <button id="add_medicine" class="btn_add">Dori qo'shish</button>
        </div>
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                <tr>
                    <th class="border-bottom-0">ID</th>
                    <th class="border-bottom-0">Name</th>
                    <th class="border-bottom-0">Price</th>
                    <th class="border-bottom-0">Soni</th>
                    <th class="border-bottom-0">Amallar </th>
                </tr>
                </thead>
                <tbody>
                @foreach($medicines as $val)
                    <tr>
                        <td class="border-bottom-0">{{$val->id}}</td>
                        <td class="border-bottom-0">{{$val->name}}</td>
                        <td class="border-bottom-0">{{$val->price}}</td>
                        <td class="border-bottom-0">{{$val->count}}</td>
                        <td class="border-bottom-0">
                            <button onclick="deleteMedicine({{ $val->id }})" class="btn btn-danger">O‘chirish</button>
                            <button onclick="addC({{$val->id}})" class="btn btn-success">Qo'shish</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="add_popup">
        <dialog id="popup" class="modal">
            <form id="recipe-form" novalidate>
                <!-- Dori nomi -->
                <div class="form-group">
                    <label for="drugName" class="form-label">Dori nomi</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-pills"></i>
                        <input type="text" class="form-control" id="drugName" placeholder="Dori nomini kiriting" required>
                    </div>
                    <div class="invalid-feedback">
                        Iltimos, dorining nomini kiriting.
                    </div>
                </div>

                <!-- Dori miqdori -->
                <div class="form-group">
                    <label  class="form-label">Dori miqdori</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-weight-hanging"></i>
                        <input type="number" class="form-control" placeholder="Dori miqdorini kiriting" required
                               min="1">
                    </div>
                    <div class="invalid-feedback">
                        Iltimos, dori miqdorini kiriting.
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Dori Sanasi</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-weight-hanging"></i>
                        <input type="date" class="form-control" placeholder="Dori miqdorini kiriting" required
                               min="1">
                    </div>
                    <div class="invalid-feedback">
                        Iltimos, dori miqdorini kiriting.
                    </div>
                </div>

                <!-- Dori turi -->
                <div class="form-group">
                    <label for="drugType" class="form-label">Dori turi</label>
                    <select class="form-control" id="drugType" required>
                        <option value="" disabled selected>Dori turini tanlang</option>
                        <option value="1">Tur 1</option>
                        <option value="2">Tur 2</option>
                        <option value="3">Tur 3</option>
                    </select>
                    <div class="invalid-feedback">
                        Iltimos, dori turini tanlang.
                    </div>
                </div>

                <button class="btn-close btn-close_add" data-close-modal></button>
            </form>
        </dialog>

    </div>


    <script>
        document.getElementById("add_medicine").addEventListener("click", function () {
            Swal.fire({
                title: "Dori qo'shish",
                html: `
                    <form id="doctorForm">
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="text" name="name" id="name" class="form-control" required placeholder="Nomi">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <select name="type_id" id="type_id" class="form-control" required>
                                    <option></option>
                                    @foreach($type_md as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <input type="number" name="price" id="price" class="form-control" required placeholder="Narxi">
                            </div>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: "Saqlash",
                preConfirm: () => {
                    const name = document.getElementById("name").value;
                    const type_id = document.getElementById("type_id").value;
                    const price = document.getElementById("price").value;

                    if (!name || !type_id || !price) {
                        Swal.showValidationMessage("Barcha maydonlarni to'ldiring!");
                        return false;
                    }

                    return fetch("/medicine", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ name, type_id, price })
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
        function deleteMedicine(id) {
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
                    return fetch(`/medicine/${id}`, {
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
    <script>
        function addC(id){
            Swal.fire({
                title: "Dori qo'shish",
                html: `
                    <form id="doctorForm">
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label class="input-group">Mahsulot soni</label>
                                <input type="number" name="count" id="count" class="form-control" required placeholder="Soni">
                            </div>
                            <div class="col mb-3">
                                <label class="input-group">Mahsulot miqdori</label>
                                <input type="number" id="count" class="form-control" required placeholder="gr, ml">
                            </div>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: "Saqlash",
                preConfirm: () => {
                    const count = document.getElementById("count").value;

                    if (!count) {
                        Swal.showValidationMessage("Barcha maydonlarni to'ldiring!");
                        return false;
                    }

                    return fetch("{{route('medicine.add')}}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ id, count })
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

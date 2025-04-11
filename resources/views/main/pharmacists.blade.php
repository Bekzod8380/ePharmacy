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
                <h5 class="card-title fw-semibold mb-4">Aptekachilar</h5>
                <div class="btn-add-box text-end">
                    <button id="add_pharmacist" class="btn btn-success">Aptekachi qo'shish</button>
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
                        @foreach($pharmacists as $pharmacist)
                            <tr id="doctor-{{ $pharmacist->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <p class="fw-bold mb-0">{{ $pharmacist->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $pharmacist->email }}</td>
                                <td>
                                    <button onclick="deletePharmacist({{ $pharmacist->id }})" class="btn btn-danger">O‘chirish</button>
                                    <button onclick="sendMedicine({{ $pharmacist->id }})" class="btn btn-warning">Dori jo'natish</button>
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
        let medicines = @json($medicines);

        function getAllSelectedValues() {
            return Array.from(document.querySelectorAll('.product-select'))
                .map(select => select.value)
                .filter(value => value !== "");
        }

        function updateProductOptions() {
            const selectedValues = getAllSelectedValues();

            document.querySelectorAll('.product-select').forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="">Select medicine</option>';

                medicines.forEach(medicine => {
                    const isSelected = selectedValues.includes(String(medicine.id)) && String(medicine.id) !== currentValue;

                    const option = document.createElement('option');
                    option.value = medicine.id;
                    option.textContent = `${medicine.name} (${medicine.count} dona mavjud)`;
                    option.dataset.max = medicine.count;
                    if (String(medicine.id) === currentValue) option.selected = true;
                    if (isSelected) option.disabled = true;

                    select.appendChild(option);
                });

                // Max qiymatni inputga o‘rnatish
                const selectedOption = select.options[select.selectedIndex];
                const maxQuantity = selectedOption ? selectedOption.dataset.max : "";
                const input = select.closest('.product-row').querySelector('.quantity-input');
                input.max = maxQuantity;
                input.value = ""; // eski qiymat tozalansin

                // Input ustida tekshiruv
                input.addEventListener("input", () => {
                    if (parseInt(input.value) > parseInt(maxQuantity)) {
                        input.value = maxQuantity;
                    }
                });
            });

            // Add tugmasini faollashtirish/yoq qilish
            const selectsCount = document.querySelectorAll('.product-select').length;
            document.getElementById('addProductBtn').disabled = selectsCount >= medicines.length;
        }

        function addProduct() {
            const productRows = document.getElementById("productRows");

            const newRow = document.createElement("div");
            newRow.className = "row g-2 mb-2 product-row";

            const selectHTML = `
            <select class="form-select product-select" name="medicine[]" onchange="updateProductOptions()" required>
                <option value="">Select medicine</option>
                ${medicines.map(m => `<option value="${m.id}" data-max="${m.count}">${m.name} (${m.count} dona mavjud)</option>`).join('')}
            </select>`;

            newRow.innerHTML = `
            <div class="col">
                ${selectHTML}
            </div>
            <div class="col">
                <input type="number" class="form-control quantity-input" name="quantity[]" placeholder="Miqdori" required min="1">
            </div>
        `;

            productRows.appendChild(newRow);
            updateProductOptions();
        }

        document.addEventListener("DOMContentLoaded", () => {
            updateProductOptions();
        });
    </script>

    <script>
        function sendMedicine(pharmacist_id){
            Swal.fire({
                title: "Dori jo'natish",
                html: `<form id="productForm">
                            <div id="productRows">
                                <div class="row g-2 mb-2 product-row">

                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary mb-3" onclick="addProduct()">Dori qo'shish</button>
                        </form>`,
                showCancelButton: true,
                confirmButtonText: "Saqlash",
                preConfirm: () => {
                    const medicines = Array.from(document.querySelectorAll('.product-select')).map(el => el.value);
                    const quantities = Array.from(document.querySelectorAll('.quantity-input')).map(el => el.value);

                    if (medicines.includes("") || quantities.includes("")) {
                        Swal.showValidationMessage("Iltimos, barcha maydonlarni to‘ldiring.");
                        return false;
                    }

                    const data = medicines.map((id, index) => ({
                        medicine_id: id,
                        pharmacist_id: pharmacist_id,
                        quantity: quantities[index]
                    }));

                    return fetch("{{route('medicine.send')}}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ items: data })
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
        document.getElementById("add_pharmacist").addEventListener("click", function () {
            Swal.fire({
                title: "Aptekachi qo'shish",
                html: `
                    <form>
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

                    return fetch("/pharmacist", {
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
        function deletePharmacist(id) {
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
                    return fetch(`/pharmacist/${id}`, {
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
                    Swal.fire("O‘chirildi!", "Aptekachi ma’lumotlari o‘chirildi.", "success")
                        .then(() => {
                            window.location.reload();
                        });
                }
            });
        }
    </script>


@endsection

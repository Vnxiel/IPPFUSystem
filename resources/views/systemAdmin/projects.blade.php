@extends('systemAdmin.layout')

@section('title', 'Projects Page')

@section('content')
    <hr class="mx-2">
    <div class="container-fluid px-3">
        <div class="row">
            <!-- Custom Filters -->
            <div class="col-md-12">
                <div class="filter-container">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                                <label for="location_filter">Location:</label>
                                <select id="location_filter" class="form-select">
                                    <option value="">All Location</option>
                                    @foreach($municipalities as $municipalityOf)
                                    <option value="{{ $municipalityOf->municipalityOf }}">{{ $municipalityOf->municipalityOf }}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="contractor_filter">Contractor:</label>
                            <select id="contractor_filter" class="form-select" required>
                                <option value="">All Contractors</option>
                                @foreach($contractors as $contractor)
                                    <option value="{{ $contractor->fullname }}">{{ $contractor->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="amount_filter">Amount:</label>
                            <input type="text" class="form-control" id="amount_filter" name="amount_filter" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="status_filter">Status:</label>
                            <select id="status_filter" class="form-select">
                                <option value="">All Status</option>
                                <option value="Active">Ongoing</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Discontinued</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 m-2">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="m-0">Projects</h5>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewProjectModal">
                    <span class="fa fa-plus"></span>&nbsp;Add New Project
                </button>
            </div>
            <hr class="mt-2">
        </div>
        <div class="row">
            <div class="table-container table-responsive">
                <table id="projects" class="table table-striped table-hover table-bordered display nowrap"
                    style="width:100%;">
                    <thead class="table-light">
                        <tr>
                            <th>Project Title</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Contract Amount</th>
                            <th>Contractor</th>
                            <th>Duration</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center">Loading projects...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    @include('systemAdmin.modals.add-project')
 


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            loadProjects(); // Load projects on page load
            // Select all input fields with the "currency-input" class
            let currencyInputs = document.querySelectorAll(".currency-input");

            currencyInputs.forEach(input => {
                input.addEventListener("input", function () {
                    formatCurrencyInput(this);
                });

                input.addEventListener("blur", function () {
                    formatCurrencyOnBlur(this);
                });

                //  Format existing values on page load
                if (input.value.trim() !== "") {
                    formatCurrencyOnBlur(input);
                }
            });

            function formatCurrencyInput(input) {
                // Remove non-numeric characters except decimal
                let value = input.value.replace(/[^0-9.]/g, "");

                // Ensure there's only one decimal point
                let parts = value.split(".");
                if (parts.length > 2) {
                    value = parts[0] + "." + parts.slice(1).join("");
                }

                input.value = value;
            }

            function formatCurrencyOnBlur(input) {
                let value = input.value.trim();

                if (value === "" || isNaN(value)) {
                    input.value = "";
                    return;
                }

                let formattedValue = parseFloat(value).toLocaleString("en-PH", {
                    style: "currency",
                    currency: "PHP",
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                input.value = formattedValue;
            }
        });

        // Handle "Other Fund" Selection Toggle
        function toggleOtherFund() {
            var sourceOfFunds = document.getElementById("sourceOfFunds").value;
            var otherFundContainer = document.getElementById("otherFundContainer");

            if (sourceOfFunds === "Others") {
                otherFundContainer.style.display = "block";
            } else {
                otherFundContainer.style.display = "none";
            }
        }

        // Handle "Ongoing Status" Selection Toggle
        function toggleOngoingStatus() {
            let statusSelect = document.getElementById("projectStatus");
            let ongoingContainer = document.getElementById("ongoingStatusContainer");
            let ongoingDate = document.getElementById("ongoingDate");

            if (statusSelect.value === "Ongoing") {
                ongoingContainer.style.display = "block";

                // Set the ongoingDate to today's date
                let today = new Date().toISOString().split('T')[0];
                ongoingDate.value = today;
            } else {
                ongoingContainer.style.display = "none";
                ongoingDate.value = ""; // Clear the date when status is not "Ongoing"
            }
        }


        // Add Event Listener for Project Status Dropdown
        document.getElementById("projectStatus").addEventListener("change", function () {
            toggleOngoingStatus();
        });


        // Handle "Other Fund" Dropdown Change
        $('#sourceOfFunds').on('change', function () {
            if ($(this).val() === 'Others') {
                $('#otherFundContainer').slideDown(); // Show input with animation
            } else {
                $('#otherFundContainer').slideUp(); // Hide input with animation
            }
        });
    </script>


    <script>

    </script>





    <script>
        //load the contractors name this is example only
        const contractors = ['Kristine Joy Briones', 'Janessa Guillermo', 'CJenalyn Jumawan', 'Arjay Ordinario'];

        function showSuggestions(query) {
            const suggestionsBox = document.getElementById('suggestionsBox');
            suggestionsBox.innerHTML = ''; // Clear previous suggestions

            if (query.length > 0) {
                const filteredContractors = contractors.filter(contractor => contractor.toLowerCase().includes(query
                    .toLowerCase()));

                if (filteredContractors.length > 0) {
                    suggestionsBox.style.display = 'block';
                    filteredContractors.forEach(contractor => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = contractor;
                        suggestionsBox.appendChild(item);
                    });
                } else {
                    suggestionsBox.style.display = 'none';
                }
            } else {
                suggestionsBox.style.display = 'none';
            }
        }


        // Predefined list of municipalities in Nueva Vizcaya
        const municipalities = [
            'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
            'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
            'Villaverde', 'Ambaguio', 'Santa Fe', 'Lamut'
        ];

        function showMunicipalitySuggestions(query) {
            const suggestionsBox = document.getElementById('suggestionsBox');
            suggestionsBox.innerHTML = ''; // Clear previous suggestions

            if (query.length > 0) {
                // Filter the municipalities based on the user input
                const filteredMunicipalities = municipalities.filter(municipality => municipality.toLowerCase().includes(query
                    .toLowerCase()));

                if (filteredMunicipalities.length > 0) {
                    suggestionsBox.style.display = 'block';
                    filteredMunicipalities.forEach(municipality => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = municipality;
                        item.onclick = function () {
                            document.getElementById('projectLoc').value = municipality +
                                ', Nueva Vizcaya'; // Auto-format the location
                            suggestionsBox.style.display = 'none'; // Hide suggestions after selection
                        };
                        suggestionsBox.appendChild(item);
                    });
                } else {
                    suggestionsBox.style.display = 'none';
                }
            } else {
                suggestionsBox.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const contractorSelect = document.getElementById("projectContractor");
            const othersContractorDiv = document.getElementById("othersContractorDiv");
            const othersContractorInput = document.getElementById("othersContractor");

            contractorSelect.addEventListener("change", function () {
                if (this.value === "Others") {
                    // Show the "Specify New Contractor" text box
                    othersContractorDiv.style.display = "block";
                } else {
                    // Hide the "Specify New Contractor" text box if anything else is selected
                    othersContractorDiv.style.display = "none";
                    othersContractorInput.value = ""; // Clear input if not "Others"
                }
            });
        });
    </script>



@endsection
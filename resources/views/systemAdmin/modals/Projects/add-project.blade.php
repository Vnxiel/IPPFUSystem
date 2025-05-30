<!-- Add Project Modal -->
<div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5 fw-bold" id="appNewProjectLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add Project
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.addProject') }}" id="addProjectForm" method="POST">
                    @csrf
                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>Project Profile
                        </legend>

                            <!-- Project Title, ID, and Year -->
                            <div class="row g-3 mb-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-3 ">
                                            <label for="projectTitle" class="form-label">Project Title <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">
                                            <textarea class="form-control" id="projectTitle" name="projectTitle" rows="3"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row g-3 mb-2 ">
                                <div class="col-md-3">
                                    <label for="projectLoc" class="form-label">Location of Project
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="projectLoc" name="projectLoc"
                                        placeholder="Select or enter location" autocomplete="off"
                                        oninput="filterLocations()" onblur="finalizeLocation()" onfocus="showLocDropdown()" />


                                    <!-- Place dropdown outside input -->
                                    <div id="projectLocDropdown"
                                        class="list-group position-absolute w-111 shadow-sm bg-white rounded"
                                        style="display: none; max-height: 181px; overflow-y: auto; z-index: 1151;">
                                        @foreach($locations as $location)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectLoc('{{ $location }}')">
                                                {{ $location }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2 align-items-center">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 ">
                                            <label for="nameOfFirm" class="form-label">Name of Firm <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="nameOfFirm"
                                                name="nameOfFirm" min="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contractor Input with Dynamic Suggestions -->
                            <div class="row g-3 mb-2 ">
                                <div class="col-md-3">
                                    <label for="projectContractor" class="form-label">Contractor's Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="projectContractor" name="projectContractor"
                                        placeholder="Select or enter contractor name" autocomplete="off"
                                        oninput="filterAndReorderContractors()" onfocus="filterAndReorderContractors()">

                                    <!-- Container for dynamically inserted buttons -->
                                    <div id="projectContractorDropdown"
                                        class="list-group position-absolute w-111 shadow-sm bg-white rounded"
                                        style="dis  play: none; max-height: 181px; overflow-y: auto; z-index: 1151;">
                                    </div>
                                </div>
                            </div>

                            <!-- Address of Contractor or Firm-->
                            <div class="row g-3 mb-2 ">
                                <div class="col-md-3">
                                    <label for="projectContractor" class="form-label">Address of Contractor/Firm <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="projectContractor" name="projectContractor"
                                        placeholder="Select or enter contractor name" autocomplete="off"
                                        oninput="filterAndReorderContractors()" onfocus="filterAndReorderContractors()">
<!-- 
                                    Container for dynamically inserted buttons
                                    <div id="projectContractorDropdown"
                                        class="list-group position-absolute w-111 shadow-sm bg-white rounded"
                                        style="dis  play: none; max-height: 181px; overflow-y: auto; z-index: 1151;">
                                    </div> -->
                                </div>
                            </div>

                            <div class="row mb-2 g-3 ">
                                <div class="col-md-3 ">
                                    <label for="sourceOfFunds" class="form-label">Source/s of Fund <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="sourceOfFunds" name="sourceOfFunds"
                                        placeholder="Select or enter source" autocomplete="off"
                                        oninput="filterFunds()" onfocus="showFundsDropdown()" onblur="hideFundsDropdownDelayed()" required>

                                    <div id="sourceOfFundsDropdown"
                                        class="list-group position-absolute w-111 shadow-sm bg-white rounded"
                                        style="display: none; max-height: 181px; overflow-y: auto; z-index: 1151;">
                                        @foreach($sourceOfFunds as $fund)
                                        <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectFund('{{ trim($fund->sourceOfFunds) }}')">
                                            {{ trim($fund->sourceOfFunds) }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-2">
                                <div class="col-md-12  mb-2">
                                    <div class="row">
                                        <div class="col-3 ">
                                            <label for="projectID" class="form-label">Project ID (Reference Code) <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="projectID" name="projectID"
                                            title="Only numbers and hyphens are allowed" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-3 ">
                                            <label for="appropriation" class="form-label">Appropriation <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">                                        
                                                <input type="text" class="form-control currency-input" name="appropriation"
                                                    id="appropriation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="row g-3 mb-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-3 ">
                                            <label for="appropriation" class="form-label">Approved Budget for the Contract<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">                                        
                                                <input type="text" class="form-control currency-input" name="appropriation"
                                                    id="appropriation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-3 ">
                                            <label for="appropriation" class="form-label">Original Contract Amount<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">                                        
                                                <input type="text" class="form-control currency-input" name="appropriation"
                                                    id="appropriation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="1stRevisedContractAmount" class="form-label">1st Revised Contract Amount</label>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control currency-input" name="1stRevisedContractAmount"
                                                id="1stRevisedContractAmount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Placeholder for new fields -->
                            <div id="revisedAmountsContainer"></div>

                            <!-- Buttons -->
                            <div class="mb-3">
                                <button type="button" id="addRevisedAmountBtn" class="btn btn-primary btn-sm" title="Add Revised Contract Amount">
                                    <i class="fas fa-plus"></i> Add Revision
                                </button>
                                <button type="button" id="removeRevisedAmountBtn" class="btn btn-danger btn-sm" title="Add Revised Contract Amount">
                                    <i class="fas fa-minus"></i> Remove
                                </button>
                            </div>

                            <!-- <div class="row mb-2 align-items-center">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 ">
                                            <label for="contractDays" class="form-label">Contract Days (Calendar days) <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="projectContractDays"
                                                name="projectContractDays" min="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-12 ">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 ">
                                            <label for="projectStatus" class="form-label">Status <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9 d-flex gap-2">
                                            <select id="projectStatus" name="projectStatus" class="form-select"
                                                onchange="toggleOngoingStatus()" required>
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="Not Started"><i class="fas fa-not-equal"></i>Not Started
                                                </option>
                                                <option value="Ongoing">Ongoing</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Discontinued">Discontinued</option>
                                                <option value="Suspended">Suspended</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="table-primary">
                                            <th colspan="7" class="text-center h6 py-2 border-bottom">
                                                <i class="fas fa-clock me-2"></i>Time Line of the Project
                                            </th>
                                        </tr>
                                        <tr class="text-center align-middle bg-light">
                                            <th rowspan="2" width="5%" class="py-2 small">#</th>
                                            <th rowspan="2" width="25%" class="py-2 small">Event</th>
                                            <th rowspan="2"width="15%" class="py-2 small">Date/Days</th>
                                            <th width="15%" class="py-2 small">Days</th>
                                            <th width="15%" class="py-2 small">Total Time</th>
                                            <th width="15%" class="py-2 small">Total Revised</th>
                                            <th width="10%" class="py-2 small">Action</th>
                                        </tr>
                                        <tr class="text-center align-middle bg-light">        
                                            <th width="15%" class="py-2 small">Suspended</th>
                                            <th width="15%" class="py-2 small">Extension Granted</th>
                                            <th width="15%" class="py-2 small">Contract Time</th>
                                            <th width="10%" class="py-2 small">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" small">
                                        <tr class="align-middle">
                                            <th class="text-center">1</th>
                                            <th>Date of Notice to Proceed</th>
                                            <td><input type="date" id="noticeToProceed" name="noticeToProceed" class="form-control form-control-sm"></td>
                                            <td><input type="number" id="noticeSuspendedDays" name="noticeSuspendedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="noticeExtensionDays" name="noticeExtensionDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="noticeRevisedDays" name="noticeRevisedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <th class="text-center">2</th>
                                            <th>Official Start of Project</th>
                                            <td><input type="date" id="projectStart" name="projectStart" class="form-control form-control-sm"></td>
                                            <td><input type="number" id="startSuspendedDays" name="startSuspendedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="startExtensionDays" name="startExtensionDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="startRevisedDays" name="startRevisedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <th class="text-center">3</th>
                                            <th>Contract Time</th>
                                            <td><input type="number" id="contractTime" name="contractTime" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="contractSuspendedDays" name="contractSuspendedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="contractExtensionDays" name="contractExtensionDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="contractRevisedDays" name="contractRevisedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <th class="text-center">4</th>
                                            <th>Original Expiry Date</th>
                                            <td><input type="date" id="expiryDate" name="expiryDate" class="form-control form-control-sm"></td>
                                            <td><input type="number" id="expirySuspendedDays" name="expirySuspendedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="expiryExtensionDays" name="expiryExtensionDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td><input type="number" id="expiryRevisedDays" name="expiryRevisedDays" min="0" class="form-control form-control-sm text-end"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tbody id="dynamic-extensions" class="small">
                                        <tr class="align-middle">
                                            <th class="text-center" rowspan="2">5</th>
                                            <th>
                                                Time Extension Due to
                                                <input type="text" class="form-control form-control-sm mt-1" placeholder="Reason (e.g. Holiday, VO#1)">
                                            </th>
                                            <td><input type="number" class="form-control form-control-sm text-end" min="0"></td>
                                            <td><input type="number" class="form-control form-control-sm text-end" min="0" placeholder="0"></td>
                                            <td><input type="number" class="form-control form-control-sm text-end" placeholder="0"></td>
                                            <td><input type="number" class="form-control form-control-sm text-end" placeholder="0"></td>
                                            <td rowspan="2" class="text-center">
                                            </td>
                                        </tr>
                                        <tr class="align-middle">
                                            <th>
                                                Revised Expiry Due to
                                                <input type="text" class="form-control form-control-sm mt-1" placeholder="Reason (e.g. Holiday, VO#1)">
                                            </th>
                                            <td><input type="date" class="form-control form-control-sm"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-primary" onclick="addExtension()">
                                    <i class="fas fa-plus-circle me-2"></i>Add Extension
                                </button>
                            </div>

                           </fieldset>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script id="contractor-data" type="application/json">
    {!! json_encode($contractors->pluck('name')) !!}
</script>
<script id="engineer-data" type="application/json">
  {!! json_encode($projectEA->pluck('ea')->map(fn($ea) => trim($ea))->values()) !!}
</script>
<script>
    const container = document.getElementById('revisedAmountsContainer');
    const addBtn = document.getElementById('addRevisedAmountBtn');
    const removeBtn = document.getElementById('removeRevisedAmountBtn');

    let count = 2;
    const maxCount = 11;
    const suffixes = ['2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '11th'];

    addBtn.addEventListener('click', () => {
        if (count > maxCount) {
            alert('You can only add up to the 11th Revised Contract Amount.');
            return;
        }

        const suffix = suffixes[count - 2];
        const inputGroup = document.createElement('div');
        inputGroup.className = 'row g-3 mb-2 revised-field';
        inputGroup.setAttribute('data-suffix', suffix);
        inputGroup.innerHTML = `
            <div class="col-md-12">
                <div class="row">
                    <div class="col-3">
                        <label for="${suffix}RevisedContractAmount" class="form-label">${suffix} Revised Contract Amount</label>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control currency-input" name="${suffix}RevisedContractAmount"
                            id="${suffix}RevisedContractAmount" required>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(inputGroup);
        count++;
    });

    removeBtn.addEventListener('click', () => {
        if (count <= 2) {
            alert('Only 1st Revised Contract Amount is required. Nothing to remove.');
            return;
        }

        const lastField = container.querySelector('.revised-field:last-of-type');
        if (lastField) {
            container.removeChild(lastField);
            count--;
        }
    });

</script>

<script>
let extensionCount = 1; // Starts from 1 since "5" is the first one

function addExtension() {
    const tbody = document.getElementById('dynamic-extensions');
    const currentNumber = 5 + extensionCount;

    const row1 = document.createElement('tr');
    row1.className = 'align-middle';
    row1.innerHTML = `
        <th class="text-center" rowspan="2">${currentNumber}</th>
        <th>
            Time Extension Due to
            <input type="text" class="form-control form-control-sm mt-1" placeholder="Reason (e.g. Holiday, VO#1)">
        </th>
        <td><input type="number" class="form-control form-control-sm text-end" min="0"></td>
        <td><input type="number" class="form-control form-control-sm text-end" min="0"" placeholder="0"></td>
        <td><input type="number" class="form-control form-control-sm text-end" placeholder="0"></td>
        <td><input type="number" class="form-control form-control-sm text-end" placeholder="0"></td>
        <td rowspan="2" class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    `;

    const row2 = document.createElement('tr');
    row2.className = 'align-middle';
    row2.innerHTML = `
        <th>
            Revised Expiry Due to
            <input type="text" class="form-control form-control-sm mt-1" placeholder="Reason (e.g. Holiday, VO#1)">
        </th>
        <td><input type="date" class="form-control form-control-sm"></td>
        <td></td>
        <td>></td>
        <td></td>
    `;

    tbody.appendChild(row1);
    tbody.appendChild(row2);
    extensionCount++;
}

function removeRow(button) {
    const row = button.closest('tr');
    const tbody = document.getElementById('dynamic-extensions');
    const index = Array.from(tbody.children).indexOf(row);

    // Protect the first pair (rows 0 and 1)
    if (index <= 1) {
        alert("You can't delete the original extension.");
        return;
    }

    const nextRow = row.nextElementSibling;
    row.remove();
    if (nextRow) nextRow.remove();

    extensionCount--;
    renumberExtensions();
}

function renumberExtensions() {
    const tbody = document.getElementById('dynamic-extensions');
    let number = 5;
    for (let i = 0; i < tbody.children.length; i += 2) {
        const row = tbody.children[i];
        const th = row.querySelector('th');
        if (th) {
            th.textContent = number++;
        }
    }
}
</script>





@section('page-scripts')
        <script src="{{ asset('js/Projects/projects-addSubmit.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-addOrder.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-currencyFormatting.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-dateValidation.js') }}"></script>
       <script src="{{ asset('js/Projects/projects-restrictionsValue.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-suggestionBox.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-valueCalculations.js') }}"></script>
        <script src="{{ asset('js/Filters/contractor-search.js') }}"></script>
        <script src="{{ asset('js/Filters/location-search.js') }}"></script>
        <script src="{{ asset('js/Filters/engineer-search.js') }}"></script>
        <script src="{{ asset('js/Filters/sourceOfFund-search.js') }}"></script>
@endsection

<!-- Modal -->
<div class="modal fade" id="entryModal" tabindex="-1" aria-labelledby="entryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Add Engineering / MQC Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <!-- Form Inputs at the Top -->
        <fieldset class="border rounded-3 p-3 mb-3">
          <legend class="float-none w-auto fs-6 px-2">Entry Information</legend>
          <div class="row g-2 align-items-end">
            <div class="col-md-2">
              <label for="entryType" class="form-label form-label-sm">Type</label>
              <select id="entryType" class="form-select form-select-sm">
                <option value="" disabled selected>Select Type</option>
                <option value="engineering">Engineering</option>
                <option value="mqc">MQC</option>
              </select>
            </div>

            <div class="col-md-2 position-relative">
              <label for="entryName" class="form-label form-label-sm">Name</label>
              <input type="text" id="entryName" class="form-control form-control-sm" placeholder="Type or select name" autocomplete="off">
              <div id="nameSuggestions" class="list-group position-absolute w-100 shadow-sm" style="z-index: 1050; display: none; max-height: 160px; overflow-y: auto;">
                @foreach ($allNames as $name)
                  <div class="list-group-item list-group-item-action suggestion-item">{{ $name }}</div>
                @endforeach
              </div>
            </div>

            <div class="col-md-1">
              <label for="entryMonth" class="form-label form-label-sm">Month</label>
              <select id="entryMonth" class="form-select form-select-sm">
                <option value="" disabled selected>Select Month</option>
                <!-- JS fills options -->
              </select>
            </div>

            <div class="col-md-4">
                <label class="form-label form-label-sm mb-1">Period (From - To)</label>
                <div class="input-group input-group-sm">
                  <span class="input-group-text">From</span>
                  <input type="date" id="entryDateFrom" class="form-control" aria-label="Start date">
                  <span class="input-group-text">To</span>
                  <input type="date" id="entryDateTo" class="form-control" aria-label="End date">
                </div>
              </div>

           

            <div class="col-md-2">
              <label for="entryAmount" class="form-label form-label-sm">Amount</label>
              <input type="text" id="entryAmount" class="form-control form-control-sm" placeholder="Amount">
            </div>

            <div class="col-md-1 d-grid">
              <button type="button" id="addEntryBtn" class="btn btn-success btn-sm mt-4"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </fieldset>

        <!-- Preview Table -->
        <div id="entryPreview" class="table-responsive">
          <table class="table table-bordered table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Month</th>
                <th>Date</th>
                <th>Period</th>
                <th>Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="entryTableBody">
              <!-- Dynamically populated -->
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="submitEntriesBtn">Submit All</button>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {
  const entryName = document.getElementById('entryName');
  const suggestions = document.getElementById('nameSuggestions');

  const filterSuggestions = (query = '') => {
    suggestions.querySelectorAll('.suggestion-item').forEach(item => {
      item.style.display = item.textContent.toLowerCase().includes(query.toLowerCase()) ? 'block' : 'none';
    });
  };

  entryName.addEventListener('focus', () => {
    filterSuggestions();
    suggestions.style.display = 'block';
  });

  entryName.addEventListener('input', () => {
    filterSuggestions(entryName.value);
    suggestions.style.display = 'block';
  });

  suggestions.addEventListener('click', e => {
    if (e.target.classList.contains('suggestion-item')) {
      entryName.value = e.target.textContent;
      suggestions.style.display = 'none';
    }
  });

  document.addEventListener('click', e => {
    if (!entryName.contains(e.target) && !suggestions.contains(e.target)) {
      suggestions.style.display = 'none';
    }
  });
});

</script>
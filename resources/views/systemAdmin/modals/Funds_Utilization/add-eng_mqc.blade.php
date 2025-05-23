<!-- Modal -->
<div class="modal fade" id="entryModal" tabindex="-1" aria-labelledby="entryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Add Engineering / MQC Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Form Inputs -->
        <div class="row g-2 mb-3 align-items-end">
          <div class="col-md-2">
            <label for="entryType" class="form-label form-label-sm">Type</label>
            <select id="entryType" class="form-select form-select-sm">
              <option value="" disabled selected>Select Type</option>
              <option value="engineering">Engineering</option>
              <option value="mqc">MQC</option>
            </select>
          </div>

          <div class="col-md-3 position-relative">
            <label for="entryName" class="form-label form-label-sm">Name</label>
            <input type="text" id="entryName" class="form-control form-control-sm" placeholder="Type or select name" autocomplete="off">
            <div id="nameSuggestions" class="list-group position-absolute w-100 shadow-sm" style="z-index: 1050; display: none; max-height: 160px; overflow-y: auto;">
              @foreach ($allNames as $name)
                <div class="list-group-item list-group-item-action suggestion-item">{{ $name }}</div>
              @endforeach
            </div>
          </div>

          <div class="col-md-2">
            <label for="entryMonth" class="form-label form-label-sm">Month</label>
            <select id="entryMonth" class="form-select form-select-sm">
              <option value="" disabled selected>Select Month</option>
              <!-- JS fills options -->
            </select>
          </div>

          <div class="col-md-2">
            <label for="entryPeriod" class="form-label form-label-sm">Period</label>
            <select id="entryPeriod" class="form-select form-select-sm">
              <option value="" disabled selected>Select Period</option>
              <option value="1st Quincena">1st Quincena</option>
              <option value="2nd Quincena">2nd Quincena</option>
            </select>
          </div>

          <div class="col-md-2">
            <label for="entryAmount" class="form-label form-label-sm">Amount</label>
            <input type="text" id="entryAmount" class="form-control form-control-sm" placeholder="Amount">
          </div>

          <div class="col-md-1 d-grid">
            <button type="button" id="addEntryBtn" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
          </div>
        </div>

        <!-- Preview Table -->
        <div id="entryPreview" class="table-responsive">
          <table class="table table-bordered table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Month</th>
                <th>Period</th>
                <th>Amount</th>
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
document.addEventListener('DOMContentLoaded', () => {
  const entryName = document.getElementById('entryName');
  const suggestions = document.getElementById('nameSuggestions');

  const filterSuggestions = (query = '') => {
    const items = suggestions.querySelectorAll('.suggestion-item');
    items.forEach(item => {
      item.style.display = item.textContent.toLowerCase().includes(query.toLowerCase()) ? 'block' : 'none';
    });
  };

  const showSuggestions = () => suggestions.style.display = 'block';
  const hideSuggestions = () => suggestions.style.display = 'none';

  entryName.addEventListener('focus', () => {
    filterSuggestions();
    showSuggestions();
  });

  entryName.addEventListener('input', () => {
    filterSuggestions(entryName.value);
    showSuggestions();
  });

  suggestions.addEventListener('click', (e) => {
    if (e.target.classList.contains('suggestion-item')) {
      entryName.value = e.target.textContent;
      hideSuggestions();
    }
  });

  document.addEventListener('click', (e) => {
    if (!entryName.contains(e.target) && !suggestions.contains(e.target)) {
      hideSuggestions();
    }
  });
});
</script>

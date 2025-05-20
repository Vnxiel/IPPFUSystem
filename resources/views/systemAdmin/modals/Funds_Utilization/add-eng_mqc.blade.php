<!-- Modal -->
<div class="modal fade" id="entryModal" tabindex="-1" aria-labelledby="entryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Engineering / MQC Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form Inputs -->
        <div class="row g-2 mb-3">
          <div class="col-md-2">
            <select id="entryType" class="form-select form-select-sm">
              <option value="" disabled selected>Select Type</option>
              <option value="engineering">Engineering</option>
              <option value="mqc">MQC</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" id="entryName" placeholder="Name">
          </div>
          <div class="col-md-2">
            <select id="entryMonth" class="form-select form-select-sm">
              <option value="" disabled selected>Select Month</option>
              <!-- months will be injected by JS -->
            </select>
          </div>
          <div class="col-md-2">
            <select id="entryPeriod" class="form-select form-select-sm">
              <option value="" disabled selected>Select Period</option>
              <option value="1st Quincena">1st Quincena</option>
              <option value="2nd Quincena">2nd Quincena</option>
            </select>
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control form-control-sm" id="entryAmount" placeholder="Amount">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-success btn-sm" id="addEntryBtn"><i class="fa fa-plus"></i></button>
          </div>
        </div>

        <!-- Preview Table -->
        <div id="entryPreview">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Month</th>
                <th>Period</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody id="entryTableBody">
              <!-- Rows injected dynamically -->
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

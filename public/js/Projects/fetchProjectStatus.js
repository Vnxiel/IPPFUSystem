$(document).ready(function () {
    $.ajax({
        url: "/get-project-id",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (!response.projectID) {
                console.error("No project ID found. Redirecting...");
                window.location.href = "/main/index";
                return;
            }

            const projectID = response.projectID;
            $("#checkStatusBtn").on("click", function () {
                fetchProjectStatus(projectID);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching Project ID:", error);
        }
    });

    function fetchProjectStatus(projectID) {
        $.ajax({
            url: `/project-status/${encodeURIComponent(projectID)}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                const cardContainer = document.getElementById("statusCards");
                cardContainer.innerHTML = "";

                const leftCol = document.createElement("div");
                leftCol.className = "col-lg-6";

                const rightCol = document.createElement("div");
                rightCol.className = "col-lg-6";

                // Determine if Add Status button should show
                const showAddButton =
                    !(data.projectStatus === "Completed" ||
                      data.projectStatus === "Cancelled" ||
                      (data.ongoingStatus && data.ongoingStatus[0]?.includes("100")));

                const mainCard = `
                    <div class="card border-primary mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Project Status</h5>
                            <p class="card-text">
                                <span class="badge bg-primary">${data.projectStatus}</span>
                            </p>
                            <p class="text-muted mb-3"><i class="bi bi-calendar-event"></i> Updated on: ${data.updatedAt || 'N/A'}</p>
                            ${showAddButton ? `
                                <button id="addStatusBtnInside" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i> Add Status
                                </button>` : ''}
                        </div>
                    </div>
                `;

                leftCol.innerHTML += mainCard;

                // Cancelled Card
                if (data.projectStatus === "Cancelled") {
                    leftCol.innerHTML += `
                        <div class="card border-danger mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-danger"><i class="bi bi-x-circle"></i> Project Cancelled</h5>
                                <p class="card-text text-danger fw-bold">This project was marked as cancelled.</p>
                            </div>
                        </div>
                    `;
                }

                // Progress table logic
                let progressRows = "";
                if (Array.isArray(data.ongoingStatus) && data.ongoingStatus.length > 0) {
                    data.ongoingStatus.forEach(item => {
                        // Split the progress string into progress, percentage, and date
                        const parts = item.split(" - ");
                        const name = parts[0] || "Unknown Phase";
                        const percentDate = parts[1] || "N/A";
                        const percentParts = percentDate.split(" ");
                        const percent = percentParts[1] || "N/A";  // Extract only percentage
                        const date = percentParts[0] || "Unknown Date";  // Extract only date

                        progressRows += `
                            <tr>
                                <td>${name}</td>
                                <td>${percent}%</td>
                                <td>${date}</td>
                            </tr>
                        `;
                    });
                } else {
                    progressRows = `<tr><td colspan="3" class="text-center">No progress data available.</td></tr>`;
                }

                const progressTable = `
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <strong><i class="bi bi-bar-chart-line"></i> Progress Details</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Progress</th>
                                        <th>Percentage</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>${progressRows}</tbody>
                            </table>
                        </div>
                    </div>
                `;

                rightCol.innerHTML += progressTable;

                cardContainer.appendChild(leftCol);
                cardContainer.appendChild(rightCol);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching project status:", error);
            }
        });
    }
});

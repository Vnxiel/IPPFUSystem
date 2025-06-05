$(document).ready(function () {
      $(document).on("click", "#generateProjectBtn", function () {
        const projectID = $(this).data("project-id");
        
        sessionStorage.setItem('project_id', projectID);
        $("#confirmGenerateBtn").data("project-id", projectID);
      });

  $("#confirmGenerateBtn").click(async function (event) {
    event.preventDefault();
    
    let projectID = sessionStorage.getItem("project_id");

    console.log("Project ID:", projectID);

const reviewedBy = $("#reviewedByInput").val()?.trim();
console.log("Reviewed By:", reviewedBy);

const reviewedByPosition = $("#reviewedByPosition").val()?.trim();
console.log("Reviewed By Position:", reviewedByPosition);

const notedBy = $("#notedByInput").val()?.trim();
console.log("Noted By:", notedBy);

const notedByPosition = $("#notedByPosition").val()?.trim();
console.log("Noted By Position:", notedByPosition);

if (!projectID || !reviewedBy || !reviewedByPosition || !notedBy || !notedByPosition) {
  Swal.fire({
    title: "Error",
    text: "Please complete all fields before generating.",
    icon: "error",
    confirmButtonText: "OK"
  });
  return;
}


    const { value: reportType } = await Swal.fire({
      title: "Select Report Type",
      text: "Choose the type of report you want to generate:",
      icon: "question",
      input: "select",
      inputOptions: {
        data: "📄 Project Data Report",
        timeline: "📆 Timeline Report"
      },
      inputPlaceholder: "Select a report type",
      showCancelButton: true,
      confirmButtonText: "Generate",
      cancelButtonText: "Cancel",
      inputValidator: (value) => {
        return value ? undefined : "You need to select a report type.";
      }
    });

    if (!reportType) return;

    // Save signatories via AJAX
    $.ajax({
      url: "/signatories",
      method: "POST",
      data: {
        project_id: projectID,
        reviewed_by: reviewedBy,
        reviewed_by_position: reviewedByPosition,
        noted_by: notedBy,
        noted_by_position: notedByPosition,
        _token: $('meta[name="csrf-token"]').attr("content")
      },
      success: function () {
        $("#generateProjectModal").modal("hide");

        let url = `/generateProject/${projectID}`;
        if (reportType === "timeline") {
          url += "?type=timeline";
        }
        window.open(url, "_blank");
      },
      error: function () {
        Swal.fire("Error", "Failed to save signatories.", "error");
      }
    });
  });

  $("#generatePdfWithPicsBtn").click(async function (event) {
    event.preventDefault();

    const projectID = sessionStorage.getItem("project_id");
    const reviewedBy = $("#reviewedByInput").val()?.trim();
    const reviewedByPosition = $("#reviewedByPosition").val()?.trim();
    const notedBy = $("#notedByInput").val()?.trim();
    const notedByPosition = $("#notedByPosition").val()?.trim();

    if (!projectID || !reviewedBy || !reviewedByPosition || !notedBy || !notedByPosition) {
      Swal.fire({
        title: "Error",
        text: "Please complete all fields before generating.",
        icon: "error",
        confirmButtonText: "OK"
      });
      return;
    }

    const { value: reportType } = await Swal.fire({
      title: "Select Report Type",
      text: "Choose the type of report you want to generate:",
      icon: "question",
      input: "select",
      inputOptions: {
        data: "📄 Project Data Report",
        timeline: "📆 Timeline Report"
      },
      inputPlaceholder: "Select a report type",
      showCancelButton: true,
      confirmButtonText: "Generate",
      cancelButtonText: "Cancel",
      inputValidator: (value) => {
        return value ? undefined : "You need to select a report type.";
      }
    });

    if (!reportType) return;

    // Save signatories via AJAX
    $.ajax({
      url: "/signatories",
      method: "POST",
      data: {
        project_id: projectID,
        reviewed_by: reviewedBy,
        reviewed_by_position: reviewedByPosition,
        noted_by: notedBy,
        noted_by_position: notedByPosition,
        _token: $('meta[name="csrf-token"]').attr("content")
      },
      success: function () {
        $("#generateProjectModal").modal("hide");

        let url = `/generateProject/${projectID}?with_pictures=true`;
        if (reportType === "timeline") {
          url += "&type=timeline";
        }
        window.open(url, "_blank");
      },
      error: function () {
        Swal.fire("Error", "Failed to save signatories.", "error");
      }
    });
  });
});


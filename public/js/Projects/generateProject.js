$(document).ready(function () {
    $("#confirmGenerateBtn").click(async function (event) {
      event.preventDefault();
  
      const projectID = sessionStorage.getItem("project_id");
      const reviewedBy = $("#reviewedByInput").val()?.trim();
      const notedBy = $("#notedByInput").val()?.trim();
  
      if (!projectID || !reviewedBy || !notedBy) {
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
          noted_by: notedBy,
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
  
    $("#generatePdfWithPicsBtn").click(function (event) {
      event.preventDefault();
  
      const projectID = sessionStorage.getItem("project_id");
  
      if (!projectID) {
        Swal.fire({
          title: "Error",
          text: "No project ID found. Please select a project first.",
          icon: "error",
          confirmButtonText: "OK"
        });
        return;
      }
  
      $("#generateProjectModal").modal("hide");
      window.open(`/generateProject/${projectID}?with_pictures=true`, "_blank");
    });
  });
  
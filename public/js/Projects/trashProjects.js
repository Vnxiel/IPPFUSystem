$(document).ready(function () {
    $(document).on("click", "#trashProjectBtn", function () {
        Swal.fire({
            title: "Are you sure?",
            text: "This project will be archived (hidden). You can restore it later.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, archive it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Get project ID from sessionStorage
                const project_id = sessionStorage.getItem("project_id");

                if (!project_id) {
                    console.error("No project ID found in sessionStorage.");
                    Swal.fire("Error!", "Project ID not found.", "error");
                    return;
                }

                console.log("Retrieved Project ID from sessionStorage:", project_id);

                // Archive the project
                $.ajax({
                    url: `/projects/trash/${project_id}`,
                    method: "PUT",
                    contentType: "application/json",
                    data: JSON.stringify({ is_hidden: 1 }),
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (data) {
                        if (data.status === "success") {
                            Swal.fire("Archived!", "The project has been hidden.", "success")
                                .then(() => {
                                    const role = sessionStorage.getItem('user_role');
                        
                                    if (role === 'System Admin') {
                                        window.location.href = "/systemAdmin/trash";
                                    } else if (role === 'Admin') {
                                        window.location.href = "/admin/trash";
                                    } else if (role === 'Staff') {
                                        window.location.href = "/staff/trash";
                                    } else {
                                        Swal.fire("Error!", "Unknown role. Cannot redirect.", "error");
                                    }
                                });
                        } else {
                            Swal.fire("Error!", data.message || "Something went wrong!", "error");
                        }
                        
                    },
                    error: function (xhr) {
                        console.error("Error hiding project:", xhr.responseText);
                        Swal.fire("Error!", "Failed to archive the project. Please try again.", "error");
                    }
                });
            }
        });
    });
});

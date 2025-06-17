window.currentUserRole = "{{ auth()->user()->role }}"; // or however you store the role
document.addEventListener("DOMContentLoaded", function () {
    const editProjectBtn = document.getElementById("editProjectBtn");

    if (!editProjectBtn) return;

    editProjectBtn.addEventListener("click", function (event) {
        if (window.currentUserRole !== "System Admin") {
            event.preventDefault();
            event.stopPropagation();

            Swal.fire({
                icon: 'warning',
                title: 'Access Denied',
                text: 'Only System Admin is allowed to edit projects.',
                confirmButtonColor: '#3085d6',
            });

            return false;
        }

        // Allowed admin action
        console.log("System Admin clicked Edit Project.");
    });
});

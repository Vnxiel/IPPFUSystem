function addFundUtilization(project) {
    if (!project) {
        console.error("Error: Project data is undefined or null.");
        return;
    }

    console.log("Populating funds utilization form with project data:", project);

    const form = document.getElementById("addFundUtilization");
    if (!form) {
        console.error("Error: Form with ID 'addFundUtilization' not found.");
        return;
    }

    const setValue = (selector, value) => {
        const input = form.querySelector(selector);
        if (input) {
            input.value = value ?? "";
        } else {
            console.warn(`Input with selector '${selector}' not found`);
        }
    };

    setValue("#projectTitleFU", project.projectTitle);
    setValue("#orig_abc", project.abc);
    setValue("#orig_contractAmount", project.contractAmount);
    setValue("#orig_engineering", project.engineering);
    setValue("#orig_mqc", project.mqc);
    setValue("#orig_contingency", project.contingency); // double-check this ID spelling
    setValue("#orig_bid", project.bid);
    setValue("#orig_appropriation", project.appropriation);
}

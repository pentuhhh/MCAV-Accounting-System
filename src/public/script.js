// Temporary Script File

// For enabling/disabling processor select
function enableInput(select) {
	var processorSelect = document.getElementById("processor");
	if (select.value === "bank-transfer") {
		processorSelect.disabled = false;
	} else {
		processorSelect.disabled = true;
	}
}

// Scroll to page section
function scrollToSection(sectionId) {
	const section = document.getElementById(sectionId);
	if (section) {
		section.scrollIntoView({ behavior: "smooth" });
	}
}
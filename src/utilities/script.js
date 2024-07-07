// Temporary Script File
function enableInput(select) {
	var processorSelect = document.getElementById("processor");
	if (select.value === "bank-transfer") {
		processorSelect.disabled = false;
	} else {
		processorSelect.disabled = true;
	}
}
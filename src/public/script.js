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

// Popup
var modal = document.getElementById("popupModal");
var modalReceipt = document.getElementById("popupModalReceipt");

var closeButton = document.getElementsByClassName("closeButton")[0];
var closeButtonReceipt = document.getElementsByClassName("closeButtonReceipt")[0];

function openModal() {
    modal.style.display = "block";
}

function openModalReceipt() {
	modalReceipt.style.display = "block";
}

function closeModal() {
    modal.style.display = "none";
}

function closeModalReceipt() {
	modalReceipt.style.display = "none";
}

function clickOutsideToClose(event) {
    if (event.target == modal || event.target == modalReceipt) {
        closeModal();
		closeModalReceipt();
    }
}

closeButton.onclick = closeModal;
closeButtonReceipt.onclick = closeModalReceipt;
window.onclick = clickOutsideToClose;


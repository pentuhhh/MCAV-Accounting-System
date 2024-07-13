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

function enableInput(select) {
	var processor = document.getElementById("processor");
	if (select.value === "bank-transfer") {
		processor.disabled = false;
	} else {
		processor.disabled = true;
		processor.value = "none";
	}
}

function addItemToList() {
	var formData = new FormData(document.getElementById("productForm"));

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "", true);

	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			location.reload();
		}
	};

	xhr.send(formData);
}

function deleteItem(index) {
	var formData = new FormData();
	formData.append("action", "deleteProduct");
	formData.append("index", index);

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "", true);

	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			location.reload();
		}
	};

	xhr.send(formData);
}


function openEditModal(customerID) {
    // Make an AJAX request to fetch customer details based on customerID
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/fetch-customer.php?customerID=" + customerID, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var customerData = JSON.parse(xhr.responseText);
            populateEditModal(customerData);
            modal.style.display = "block"; // Display the edit modal
        }
    };

    xhr.send();
}

function populateEditModal(customerData) {
    // Populate the fields in the edit modal with customerData
    document.getElementById('editCustomerName').value = customerData.CustomerName;
    document.getElementById('editCustomerEmail').value = customerData.CustomerEmail;
    document.getElementById('editCustomerPhone').value = customerData.CustomerPhone;
    // Populate other fields as needed
}
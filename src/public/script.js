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

document.querySelectorAll(".tab").forEach((tab) => {
	tab.addEventListener("click", function () {
		const target = this.getAttribute("data-target");
		fetchContent(target);
	});
});

function fetchContent(target) {
	fetch(`index.php?tab=${target}`)
		.then((response) => response.text())
		.then((html) => {
			document.querySelector(".PRODUCTS_INPUT").innerHTML = html;
		})
		.catch((error) =>
			console.error("Error loading the tab content:", error),
		);
}

const tabs = document.querySelectorAll(".tabs button");
const contents = document.querySelectorAll(".content");

tabs.forEach((tab) => {
	tab.addEventListener("click", () => {
		tabs.forEach((t) => t.classList.remove("tab-active"));

		tab.classList.add("tab-active");

		const contentId = tab.dataset.target;
		const content = document.getElementById(contentId);
		contents.forEach((c) => c.classList.remove("block", "h-screen"));
		content.classList.add("block", "h-screen");
	});
});

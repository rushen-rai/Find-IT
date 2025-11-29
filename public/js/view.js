document.addEventListener("DOMContentLoaded", () => {
  const overlay = document.getElementById("itemOverlay");
  const closeBtn = document.querySelector(".close-overlay");
  const viewButtons = document.querySelectorAll(".report-card button");

  viewButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      overlay.classList.add("active");
      document.body.classList.add("no-scroll");
    });
  });

  closeBtn.addEventListener("click", () => {
    overlay.classList.remove("active");
    document.body.classList.remove("no-scroll");
  });

  overlay.addEventListener("click", e => {
    if (e.target === overlay) {
      overlay.classList.remove("active");
      document.body.classList.remove("no-scroll");
    }
  });
});
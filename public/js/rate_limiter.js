document.addEventListener("DOMContentLoaded", () => {
  const errorBox = document.querySelector(".alert-danger");
  if (!errorBox) return;

  const text = errorBox.textContent;
  const match = text.match(/Try again in (\d+) seconds/);

  if (match) {
    let remaining = parseInt(match[1]);
    const original = text;

    const update = () => {
      if (remaining > 0) {
        errorBox.textContent = `Too many login attempts. Try again in ${remaining} seconds.`;
        remaining--;
        setTimeout(update, 1000);
      } else {
        errorBox.textContent = "You can now try again.";
        errorBox.style.color = "green";
      }
    };

    update();
  }
});

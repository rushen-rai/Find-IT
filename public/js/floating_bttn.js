export function initFloatingButton(id, callback) {
  const btn = document.getElementById(id);
  if (btn && callback) {
    btn.addEventListener('click', callback);
  }
}
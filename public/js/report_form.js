document.addEventListener('DOMContentLoaded', () => {
    const addReportBtn = document.getElementById('addReportBtn');

    addReportBtn.addEventListener('click', async () => {
        let reportformOverlay = document.getElementById('reportformOverlay');

        if (!reportformOverlay) {
            try {
                const response = await fetch('/report');
                const html = await response.text();
                document.body.insertAdjacentHTML('beforeend', html);

                const cssPath = '/css/components/report_form.css';
                if (![...document.styleSheets].some(s => s.href && s.href.includes('report_form.css'))) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = cssPath;
                    document.head.appendChild(link);
                }

                initReportForm();

                reportformOverlay = document.getElementById('reportformOverlay');
                reportformOverlay.classList.add('active');

            } catch (err) {
                alert('Failed to load report form. Please try again.');
            }
        } else {
            reportformOverlay.classList.add('active');
        }
    });

    async function loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = resolve;
            script.onerror = () => reject(new Error(`Failed to load script: ${src}`));
            document.body.appendChild(script);
        });
    }

    function initReportForm() {
        const overlay = document.getElementById('reportformOverlay');
        const form = overlay.querySelector('form');
        const closeButtons = overlay.querySelectorAll('.reportform-close, .reportform-cancel');
        const clearBtn = overlay.querySelector('.reportform-clear');
        const typeButtons = overlay.querySelectorAll('.reportform-type-btn');
        const hiddenTypeInput = form.querySelector('#report_type');

        // close buttons
        closeButtons.forEach(btn =>
            btn.addEventListener('click', () => overlay.classList.remove('active'))
        );

        typeButtons.forEach(btn =>
            btn.addEventListener('click', () => {
                typeButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                hiddenTypeInput.value = btn.dataset.type;
            })
        );

        // clear button
        clearBtn.addEventListener('click', () => {
            form.reset();
            typeButtons.forEach(b => b.classList.remove('active'));
            typeButtons[0].classList.add('active');
            hiddenTypeInput.value = typeButtons[0].dataset.type;
        });

        // Aform submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                // Submit form
                const response = await fetch('/reports', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                if (!response.ok) throw new Error(`HTTP error ${response.status}`);

                const result = await response.json();

                overlay.classList.remove('active');

                if (!window.showAdminApprovalOverlay) {
                    await loadScript('/js/admin_approval.js');
                }

                if (typeof showAdminApprovalOverlay === 'function') {
                    showAdminApprovalOverlay(result.item);
                }

                alert('Report submitted successfully!');
            } catch (err) {
                alert('Something went wrong. Please try again.');
            }
        });
    }
});

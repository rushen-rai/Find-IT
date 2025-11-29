document.addEventListener('DOMContentLoaded', () => {
    const claimBtn = document.getElementById('claimBtn');
    if (!claimBtn) return;

    claimBtn.addEventListener('click', async () => {
        let proofformOverlay = document.getElementById('proofformOverlay');

        if (!proofformOverlay) {
            try {
                const response = await fetch('/proof');
                const html = await response.text();
                document.body.insertAdjacentHTML('beforeend', html);

                const cssPath = '/css/components/proof_form.css';
                if (![...document.styleSheets].some(s => s.href && s.href.includes('proof_form.css'))) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = cssPath;
                    document.head.appendChild(link);
                }

                initProofForm();

                // Show overlay
                proofformOverlay = document.getElementById('proofformOverlay');
                proofformOverlay.classList.add('active');

            } catch (err) {
            }
        } else {
            proofformOverlay.classList.add('active');
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

    function initProofForm() {
        const overlay = document.getElementById('proofformOverlay');
        const form = overlay.querySelector('form');
        const closeButtons = overlay.querySelectorAll('.proofform-close, .proofform-cancel');
        const clearBtn = overlay.querySelector('.proofform-clear');

        // close button
        closeButtons.forEach(btn =>
            btn.addEventListener('click', () => overlay.classList.remove('active'))
        );

        // clear button
        if (clearBtn) clearBtn.addEventListener('click', () => form.reset());

        // close outside click
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    }
});
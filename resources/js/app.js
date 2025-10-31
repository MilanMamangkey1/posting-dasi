import './bootstrap';

const toastIcons = {
    success: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4 text-emerald-500">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12l6 6 9-13.5" />
        </svg>
    `,
    error: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4 text-rose-500">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm0-12a9 9 0 110 18 9 9 0 010-18z" />
        </svg>
    `,
    info: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4 text-sky-500">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.25 9h1.5v6h-1.5zM12 15.75h.008v.008H12v-.008zm0-9.75a9 9 0 110 18 9 9 0 010-18z" />
        </svg>
    `,
};

const getToastRoot = () => {
    let root = document.querySelector('[data-toast-root]');
    if (!root) {
        root = document.createElement('div');
        root.className = 'toast-container';
        root.setAttribute('data-toast-root', 'true');
        document.body.appendChild(root);
    }
    return root;
};

const hideToast = (toastEl) => {
    if (!toastEl) {
        return;
    }
    toastEl.classList.add('opacity-0', '-translate-y-2');
    toastEl.addEventListener(
        'transitionend',
        () => {
            toastEl.remove();
        },
        { once: true },
    );
};

const renderToast = ({ message, type = 'info', duration = 5000 } = {}) => {
    if (!message) {
        return;
    }

    const root = getToastRoot();
    const toastEl = document.createElement('div');
    toastEl.className = `toast toast--${type} opacity-0 translate-y-2`;

    const iconMarkup = toastIcons[type] ?? toastIcons.info;

    toastEl.innerHTML = `
        <span class="toast__icon">${iconMarkup}</span>
        <div class="flex-1 leading-relaxed">${message}</div>
        <button type="button" class="toast__close" aria-label="Tutup pemberitahuan">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12m0-12L6 18" />
            </svg>
        </button>
        <span class="toast__progress" aria-hidden="true">
            <span class="toast__progress-bar"></span>
        </span>
    `;

    const closeButton = toastEl.querySelector('.toast__close');
    if (closeButton) {
        closeButton.addEventListener('click', () => hideToast(toastEl));
    }

    root.appendChild(toastEl);

    requestAnimationFrame(() => {
        toastEl.classList.remove('opacity-0', 'translate-y-2');
        toastEl.classList.add('opacity-100', 'translate-y-0');
    });

    const progressBar = toastEl.querySelector('.toast__progress-bar');
    if (progressBar) {
        progressBar.style.transitionDuration = `${duration}ms`;
        // Force layout to ensure transition runs.
        void progressBar.offsetWidth;
        progressBar.style.width = '0%';
    }

    if (duration > 0) {
        setTimeout(() => hideToast(toastEl), duration);
    }
};

const toastQueue = (window.__toastQueue = window.__toastQueue || []);

const flushQueue = () => {
    while (toastQueue.length > 0) {
        const toast = toastQueue.shift();
        renderToast(toast);
    }
};

window.enqueueToast = (toast) => {
    toastQueue.push(toast);
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        renderToast(toastQueue.shift());
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', flushQueue, { once: true });
} else {
    flushQueue();
}

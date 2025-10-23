const state = {
    activeSection: 'dashboard',
    contents: {
        items: [],
        filters: {
            type: '',
            search: '',
        },
        pagination: {
            current_page: 1,
            per_page: 10,
        },
    },
    consultations: {
        items: [],
        filters: {
            status: '',
            search: '',
        },
        pagination: {
            current_page: 1,
            per_page: 10,
        },
    },
    selectedContent: null,
};

const sectionTabs = document.querySelectorAll('.section-tab');
const sections = document.querySelectorAll('[data-section]');
const metricElements = {
    total_contents: document.querySelector('[data-metric="total_contents"]'),
    total_consultations: document.querySelector('[data-metric="total_consultations"]'),
    contents_by_type: document.querySelector('[data-metric="contents_by_type"]'),
    consultations_by_status: document.querySelector('[data-metric="consultations_by_status"]'),
};

const recentContentsBody = document.getElementById('recent-contents');
const recentConsultationsBody = document.getElementById('recent-consultations');

const contentForm = document.getElementById('content-form');
const contentFormFeedback = document.getElementById('content-form-feedback');
const contentFormErrors = document.getElementById('content-form-errors');
const contentFormResetButton = document.querySelector('[data-action="reset-content-form"]');
const contentFilterType = document.getElementById('content-filter-type');
const contentFilterSearch = document.getElementById('content-filter-search');
const contentListRefreshButton = document.querySelector('[data-action="refresh-content-list"]');
const contentTableBody = document.getElementById('content-table-body');
const typeSpecificFields = document.querySelectorAll('[data-field-for]');

const consultationFilterStatus = document.getElementById('consultation-filter-status');
const consultationFilterSearch = document.getElementById('consultation-filter-search');
const consultationListRefreshButton = document.querySelector('[data-action="refresh-consultation-list"]');
const consultationTableBody = document.getElementById('consultation-table-body');

const IS_ACTIVE_TAB_CLASSES = 'border-transparent bg-slate-900 text-white hover:bg-slate-700';
const IS_INACTIVE_TAB_CLASSES = 'border border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:text-slate-900';

function applyTabState(button, isActive) {
    if (!button) {
        return;
    }
    if (isActive) {
        button.classList.add(...IS_ACTIVE_TAB_CLASSES.split(' '));
        button.classList.remove(...IS_INACTIVE_TAB_CLASSES.split(' '));
    } else {
        button.classList.remove(...IS_ACTIVE_TAB_CLASSES.split(' '));
        button.classList.add(...IS_INACTIVE_TAB_CLASSES.split(' '));
    }
}

function switchSection(sectionId) {
    state.activeSection = sectionId;

    sections.forEach((section) => {
        if (section.dataset.section === sectionId) {
            section.classList.remove('hidden');
        } else {
            section.classList.add('hidden');
        }
    });

    sectionTabs.forEach((tab) => {
        applyTabState(tab, tab.dataset.targetSection === sectionId);
    });
}

function formatDateTime(value) {
    if (!value) {
        return '-';
    }

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return date.toLocaleString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}

function formatDateInput(value) {
    if (!value) {
        return '';
    }

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) {
        return '';
    }

    const pad = (num) => String(num).padStart(2, '0');

    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(
        date.getHours(),
    )}:${pad(date.getMinutes())}`;
}

function objectToSentenceList(data) {
    if (!data || typeof data !== 'object') {
        return '-';
    }

    const entries = Object.entries(data)
        .map(([key, value]) => `${key}: ${value}`)
        .join(', ');

    return entries || '-';
}

function showFeedback(element, message) {
    if (!element) {
        return;
    }
    element.textContent = message;
    element.classList.remove('hidden');
}

function hideFeedback(...elements) {
    elements.forEach((element) => {
        if (element) {
            element.classList.add('hidden');
            element.textContent = '';
        }
    });
}

async function fetchDashboard() {
    try {
        const { data } = await window.axios.get('/admin/api/dashboard');

        metricElements.total_contents.textContent = data.metrics.total_contents ?? '-';
        metricElements.total_consultations.textContent = data.metrics.total_consultations ?? '-';
        metricElements.contents_by_type.textContent = objectToSentenceList(data.metrics.contents_by_type);
        metricElements.consultations_by_status.textContent = objectToSentenceList(data.metrics.consultations_by_status);

        renderRecentList(recentContentsBody, data.recent_contents, ['title', 'type', 'updated_at']);
        renderRecentList(recentConsultationsBody, data.recent_consultations, ['full_name', 'status', 'updated_at']);
    } catch (error) {
        console.error('Failed to fetch dashboard metrics', error);
        renderRecentList(recentContentsBody, [], []);
        renderRecentList(recentConsultationsBody, [], []);
        showFeedback(
            metricElements.total_contents?.parentElement?.nextElementSibling,
            'Gagal memuat metrik. Periksa koneksi API.',
        );
    }
}

function renderRecentList(container, items, fields) {
    if (!container) {
        return;
    }

    if (!Array.isArray(items) || items.length === 0) {
        container.innerHTML = `
            <tr>
                <td class="px-4 py-4 text-sm text-slate-500" colspan="3">
                    Belum ada data.
                </td>
            </tr>
        `;
        return;
    }

    container.innerHTML = items
        .map((item) => {
            const [firstField, secondField, thirdField] = fields;
            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-4 py-3 text-sm font-medium text-slate-800">${item[firstField] ?? '-'}</td>
                    <td class="px-4 py-3 text-sm text-slate-500 capitalize">${item[secondField] ?? '-'}</td>
                    <td class="px-4 py-3 text-sm text-slate-500">${formatDateTime(item[thirdField])}</td>
                </tr>
            `;
        })
        .join('');
}

async function fetchContents() {
    const { filters, pagination } = state.contents;
    const params = new URLSearchParams({
        per_page: pagination.per_page,
    });
    if (filters.type) {
        params.append('type', filters.type);
    }
    if (filters.search) {
        params.append('search', filters.search);
    }

    try {
        const { data } = await window.axios.get(`/admin/api/educational-contents?${params.toString()}`);
        state.contents.items = data.data ?? [];
        renderContentTable();
    } catch (error) {
        console.error('Failed to fetch contents', error);
        showFeedback(contentFormErrors, 'Gagal memuat data konten. Coba periksa sambungan API.');
        contentTableBody.innerHTML = `
            <tr>
                <td class="px-4 py-4 text-sm text-rose-600" colspan="4">
                    Tidak dapat memuat daftar konten.
                </td>
            </tr>
        `;
    }
}

function renderContentTable() {
    if (!contentTableBody) {
        return;
    }

    const items = state.contents.items;

    if (!Array.isArray(items) || items.length === 0) {
        contentTableBody.innerHTML = `
            <tr>
                <td class="px-4 py-4 text-sm text-slate-500" colspan="4">
                    Belum ada data konten.
                </td>
            </tr>
        `;
        return;
    }

    contentTableBody.innerHTML = items
        .map(
            (content) => `
            <tr class="hover:bg-slate-50/80 transition">
                <td class="px-4 py-3 text-sm font-medium text-slate-800">${content.title}</td>
                <td class="px-4 py-3 text-sm text-slate-500 capitalize">${content.type}</td>
                <td class="px-4 py-3 text-sm text-slate-500">${formatDateTime(content.updated_at)}</td>
                <td class="px-4 py-3 text-sm text-slate-500">
                    <div class="flex gap-3">
                        <button type="button" class="text-slate-600 hover:text-slate-900" data-action="edit-content" data-id="${content.id}">
                            Edit
                        </button>
                        <button type="button" class="text-rose-600 hover:text-rose-700" data-action="delete-content" data-id="${content.id}">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
        `,
        )
        .join('');
}

function resetContentForm() {
    if (!contentForm) {
        return;
    }
    contentForm.reset();
    document.getElementById('content-id').value = '';
    state.selectedContent = null;
    hideFeedback(contentFormFeedback, contentFormErrors);
    toggleContentSubmitState(false);
    updateTypeSpecificFields();
}

function toggleContentSubmitState(isSubmitting) {
    const submitButton = contentForm?.querySelector('button[type="submit"]');
    if (!submitButton) {
        return;
    }
    submitButton.disabled = isSubmitting;
    submitButton.textContent = isSubmitting ? 'Menyimpan...' : 'Simpan Konten';
}

function updateTypeSpecificFields() {
    const selectedType = document.getElementById('content-type')?.value;

    typeSpecificFields.forEach((field) => {
        const types = field.dataset.fieldFor.split(' ');
        if (types.includes(selectedType)) {
            field.classList.remove('hidden');
        } else {
            field.classList.add('hidden');
            const input = field.querySelector('input, textarea');
            if (input) {
                if (input.type === 'file') {
                    input.value = '';
                } else {
                    input.value = '';
                }
            }
        }
    });
}

function fillContentForm(content) {
    if (!contentForm) {
        return;
    }
    document.getElementById('content-id').value = content.id;
    document.getElementById('content-title').value = content.title ?? '';
    document.getElementById('content-type').value = content.type ?? '';
    document.getElementById('content-summary').value = content.summary ?? '';
    document.getElementById('content-body').value = content.body ?? '';
    document.getElementById('content-source-url').value = content.source_url ?? '';

    updateTypeSpecificFields();
}

async function submitContentForm(event) {
    event.preventDefault();
    hideFeedback(contentFormFeedback, contentFormErrors);

    const formData = new FormData(contentForm);
    const contentId = formData.get('content_id');
    const selectedType = formData.get('type');
    if (selectedType !== 'photo') {
        formData.delete('file');
    }

    toggleContentSubmitState(true);

    try {
        let response;

        if (contentId) {
            formData.append('_method', 'PUT');
            response = await window.axios.post(`/admin/api/educational-contents/${contentId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
        } else {
            response = await window.axios.post('/admin/api/educational-contents', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
        }

        showFeedback(contentFormFeedback, `Konten "${response.data.title}" berhasil disimpan.`);
        await fetchDashboard();
        await fetchContents();
        resetContentForm();
    } catch (error) {
        console.error('Failed to submit content form', error);
        if (error.response?.data?.errors) {
            const messages = Object.values(error.response.data.errors)
                .flat()
                .join(' ');
            showFeedback(contentFormErrors, messages || 'Terjadi kesalahan saat menyimpan konten.');
        } else {
            showFeedback(contentFormErrors, 'Terjadi kesalahan saat menyimpan konten.');
        }
    } finally {
        toggleContentSubmitState(false);
    }
}

async function handleContentTableClick(event) {
    const button = event.target.closest('button[data-action]');
    if (!button) {
        return;
    }

    const contentId = button.dataset.id;
    if (!contentId) {
        return;
    }

    if (button.dataset.action === 'edit-content') {
        const content = state.contents.items.find((item) => String(item.id) === String(contentId));
        if (!content) {
            return;
        }
        state.selectedContent = content;
        fillContentForm(content);
        switchSection('contents');
        sectionTabs.forEach((tab) => {
            if (tab.dataset.targetSection === 'contents') {
                tab.focus();
            }
        });
    }

    if (button.dataset.action === 'delete-content') {
        const confirmed = window.confirm('Hapus konten ini? Tindakan tidak dapat dibatalkan.');
        if (!confirmed) {
            return;
        }
        try {
            await window.axios.delete(`/admin/api/educational-contents/${contentId}`);
            showFeedback(contentFormFeedback, 'Konten berhasil dihapus.');
            await fetchDashboard();
            await fetchContents();
            if (state.selectedContent && String(state.selectedContent.id) === String(contentId)) {
                resetContentForm();
            }
        } catch (error) {
            console.error('Failed to delete content', error);
            showFeedback(contentFormErrors, 'Gagal menghapus konten. Coba lagi.');
        }
    }
}

async function fetchConsultations() {
    const { filters, pagination } = state.consultations;
    const params = new URLSearchParams({
        per_page: pagination.per_page,
    });
    if (filters.status) {
        params.append('status', filters.status);
    }
    if (filters.search) {
        params.append('search', filters.search);
    }

    try {
        const { data } = await window.axios.get(`/admin/api/consultation-requests?${params.toString()}`);
        state.consultations.items = data.data ?? [];
        renderConsultationTable();
    } catch (error) {
        console.error('Failed to fetch consultations', error);
        consultationTableBody.innerHTML = `
            <tr>
                <td class="px-4 py-4 text-sm text-rose-600" colspan="4">
                    Tidak dapat memuat daftar konsultasi.
                </td>
            </tr>
        `;
    }
}

function renderConsultationTable() {
    if (!consultationTableBody) {
        return;
    }

    const items = state.consultations.items;

    if (!Array.isArray(items) || items.length === 0) {
        consultationTableBody.innerHTML = `
            <tr>
                <td class="px-4 py-4 text-sm text-slate-500" colspan="4">
                    Belum ada pengajuan konsultasi.
                </td>
            </tr>
        `;
        return;
    }

    consultationTableBody.innerHTML = items
        .map((consultation) => {
            const rawWhatsapp = consultation.whatsapp_number ?? '';
            const sanitizedWhatsapp = rawWhatsapp.replace(/\D+/g, '');
            const whatsappLink = sanitizedWhatsapp ? `https://wa.me/${sanitizedWhatsapp}` : null;

            return `
            <tr class="hover:bg-slate-50/80 transition">
                <td class="px-4 py-3 text-sm font-medium text-slate-800">${consultation.full_name}</td>
                <td class="px-4 py-3 text-sm text-slate-500 capitalize">${consultation.status.replace('_', ' ')}</td>
                <td class="px-4 py-3 text-sm text-slate-500">
                    <div class="flex flex-col gap-1">
                        <span>${rawWhatsapp || '-'}</span>
                        ${
                            whatsappLink
                                ? `<a href="${whatsappLink}" target="_blank" rel="noopener" class="text-slate-900 font-medium hover:underline">Hubungi via WhatsApp</a>`
                                : ''
                        }
                    </div>
                </td>
                <td class="px-4 py-3 text-sm text-slate-500">${consultation.address}</td>
                <td class="px-4 py-3 text-sm text-slate-500">
                    <button type="button" class="text-rose-600 hover:text-rose-700" data-action="delete-consultation" data-id="${consultation.id}">
                        Hapus
                    </button>
                </td>
            </tr>
        `;
        })
        .join('');
}

async function handleConsultationTableClick(event) {
    const button = event.target.closest('button[data-action]');
    if (!button) {
        return;
    }

    const consultationId = button.dataset.id;
    const consultation = state.consultations.items.find((item) => String(item.id) === String(consultationId));
    if (!consultation) {
        return;
    }

    if (button.dataset.action === 'delete-consultation') {
        await deleteConsultation(consultationId);
    }
}

async function deleteConsultation(consultationId) {
    const confirmed = window.confirm('Hapus pengajuan konsultasi ini?');
    if (!confirmed) {
        return;
    }
    try {
        await window.axios.delete(`/admin/api/consultation-requests/${consultationId}`);
        window.alert('Pengajuan konsultasi dihapus.');
        await fetchDashboard();
        await fetchConsultations();
    } catch (error) {
        console.error('Failed to delete consultation', error);
        window.alert('Gagal menghapus konsultasi.');
    }
}

function initEventListeners() {
    sectionTabs.forEach((tab) => {
        tab.addEventListener('click', () => switchSection(tab.dataset.targetSection));
    });

    document.querySelectorAll('[data-refresh="contents"]').forEach((button) => {
        button.addEventListener('click', fetchDashboard);
    });
    document.querySelectorAll('[data-refresh="consultations"]').forEach((button) => {
        button.addEventListener('click', fetchDashboard);
    });

    contentFilterType?.addEventListener('change', () => {
        state.contents.filters.type = contentFilterType.value;
    });
    contentFilterSearch?.addEventListener('input', (event) => {
        state.contents.filters.search = event.target.value;
    });
    contentListRefreshButton?.addEventListener('click', fetchContents);

    contentTableBody?.addEventListener('click', handleContentTableClick);
    contentForm?.addEventListener('submit', submitContentForm);
    contentFormResetButton?.addEventListener('click', resetContentForm);
    document.getElementById('content-type')?.addEventListener('change', updateTypeSpecificFields);

    consultationFilterStatus?.addEventListener('change', () => {
        state.consultations.filters.status = consultationFilterStatus.value;
    });
    consultationFilterSearch?.addEventListener('input', (event) => {
        state.consultations.filters.search = event.target.value;
    });
    consultationListRefreshButton?.addEventListener('click', fetchConsultations);

    consultationTableBody?.addEventListener('click', handleConsultationTableClick);
}

function initialize() {
    if (!document.getElementById('admin-main')) {
        return;
    }

    initEventListeners();
    switchSection('dashboard');
    updateTypeSpecificFields();
    fetchDashboard();
    fetchContents();
    fetchConsultations();
}

document.addEventListener('DOMContentLoaded', initialize);

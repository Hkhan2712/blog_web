document.addEventListener('DOMContentLoaded', function () {
    const uniqueInputs = document.querySelectorAll('[data-validate="unique"]');
    const checkUrl = window.APP?.checkExistUrl;

    if (!checkUrl) {
        console.error("Validation URL is missing. Please define window.APP.checkExistUrl.");
        return;
    }

    uniqueInputs.forEach(input => {
        input.addEventListener('input', function () {
            debounce(() => {
                validateUniqueField(checkUrl, input)
                    .then(data => {
                        if (data?.exists) {
                            showValidationMessage(input, `${input.dataset.type} is already taken`);
                        } else {
                            showValidationMessage(input, '');
                        }
                    })
                    .catch(err => {
                        console.error('Validation request failed:', err);
                    });
            }, 300)();  // debounce 300ms tránh spam request
        });
    });
});

/**
 * Gửi yêu cầu AJAX để kiểm tra tính duy nhất của trường
 * @param {string} url - URL endpoint kiểm tra
 * @param {HTMLElement} input - input cần kiểm tra
 * @returns {Promise<object>} - Trả về object JSON từ server
 */
function validateUniqueField(url, input) {
    const value = input.value.trim();
    if (!value) return Promise.resolve(null);

    const params = new URLSearchParams();
    params.set('type', input.dataset.type);
    params.set('value', value);

    return fetch(`${url}?${params.toString()}`, {
        headers: { 'Accept': 'application/json' }
    })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
        });
}

/**
 * Hiển thị hoặc ẩn thông báo lỗi dưới input
 * @param {HTMLElement} input - input cần hiển thị lỗi
 * @param {string} message - thông báo lỗi (nếu rỗng thì ẩn đi)
 */
function showValidationMessage(input, message) {
    let feedbackEl = input.nextElementSibling;
    if (!feedbackEl || !feedbackEl.classList.contains('form-text')) {
        feedbackEl = document.createElement('div');
        feedbackEl.className = 'form-text';
        input.insertAdjacentElement('afterend', feedbackEl);
    }
    feedbackEl.textContent = message || '';
    feedbackEl.classList.toggle('text-danger', !!message);
}

/**
 * Debounce để tránh gửi quá nhiều request liên tục
 * @param {Function} func - Hàm cần debounce
 * @param {number} delay - Thời gian trễ (ms)
 * @returns {Function}
 */
function debounce(func, delay = 300) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}
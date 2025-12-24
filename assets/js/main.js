/**
 * Airigojobs Main JavaScript File
 * Contains common JavaScript functions used throughout the application
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeComponents();
    setupEventListeners();
    checkUserSession();
});

/**
 * Initialize all components
 */
function initializeComponents() {
    // Initialize tooltips
    initTooltips();
    
    // Initialize form validation
    initFormValidation();
    
    // Initialize modals
    initModals();
    
    // Initialize dropdowns
    initDropdowns();
    
    // Initialize tabs
    initTabs();
    
    // Initialize accordions
    initAccordions();
    
    // Initialize file upload previews
    initFileUploads();
    
    // Initialize date pickers
    initDatePickers();
    
    // Initialize password toggle
    initPasswordToggle();
    
    // Initialize notifications
    initNotifications();
}

/**
 * Setup global event listeners
 */
function setupEventListeners() {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
    
    // Close flash messages
    document.addEventListener('click', function(event) {
        if (event.target.closest('[data-dismiss="alert"]')) {
            event.target.closest('.alert').remove();
        }
    });
    
    // Form submission handling
    document.addEventListener('submit', function(event) {
        const form = event.target;
        
        // Add loading state to submit buttons
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton && !form.classList.contains('no-loading')) {
            submitButton.classList.add('loading');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        }
    });
    
    // Prevent multiple form submissions
    let formsSubmitting = new Set();
    document.addEventListener('submit', function(event) {
        const form = event.target;
        if (formsSubmitting.has(form)) {
            event.preventDefault();
            return;
        }
        formsSubmitting.add(form);
        
        // Remove from set after form submission completes
        setTimeout(() => {
            formsSubmitting.delete(form);
        }, 2000);
    });
}

/**
 * Check user session and update UI accordingly
 */
function checkUserSession() {
    // Check for session timeout warning
    const sessionWarningTime = 10 * 60 * 1000; // 10 minutes in milliseconds
    let lastActivity = Date.now();
    
    // Update last activity on user interaction
    ['click', 'keypress', 'scroll', 'mousemove'].forEach(eventType => {
        document.addEventListener(eventType, function() {
            lastActivity = Date.now();
        }, { passive: true });
    });
    
    // Check session every minute
    setInterval(function() {
        const timeSinceLastActivity = Date.now() - lastActivity;
        
        if (timeSinceLastActivity > sessionWarningTime) {
            showSessionWarning();
        }
    }, 60000);
}

/**
 * Show session timeout warning
 */
function showSessionWarning() {
    if (document.querySelector('.session-warning')) return;
    
    const warning = document.createElement('div');
    warning.className = 'session-warning fixed bottom-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg shadow-lg z-50';
    warning.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-3"></i>
            <div>
                <p class="font-bold">Session Timeout Warning</p>
                <p class="text-sm">Your session will expire soon due to inactivity.</p>
            </div>
            <button class="ml-4 text-yellow-700 hover:text-yellow-900" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mt-2 flex justify-end space-x-2">
            <button onclick="extendSession()" class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700">
                Stay Logged In
            </button>
            <button onclick="logout()" class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                Logout Now
            </button>
        </div>
    `;
    
    document.body.appendChild(warning);
    
    // Auto-remove after 30 seconds
    setTimeout(() => {
        if (warning.parentNode) {
            warning.remove();
        }
    }, 30000);
}

/**
 * Extend user session
 */
function extendSession() {
    fetch('/api/session/extend', {
        method: 'POST',
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Session extended', 'success');
            document.querySelector('.session-warning')?.remove();
        }
    })
    .catch(error => {
        console.error('Error extending session:', error);
    });
}

/**
 * Initialize tooltips
 */
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = createTooltip(tooltipText, this);
            document.body.appendChild(tooltip);
            
            // Position tooltip
            const rect = this.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            let top = rect.top - tooltipRect.height - 10;
            let left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
            
            // Adjust if tooltip goes off screen
            if (top < 0) {
                top = rect.bottom + 10;
            }
            if (left < 0) {
                left = 10;
            }
            if (left + tooltipRect.width > window.innerWidth) {
                left = window.innerWidth - tooltipRect.width - 10;
            }
            
            tooltip.style.top = top + 'px';
            tooltip.style.left = left + 'px';
            
            this._tooltip = tooltip;
        });
        
        element.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                delete this._tooltip;
            }
        });
    });
}

/**
 * Create tooltip element
 */
function createTooltip(text, parent) {
    const tooltip = document.createElement('div');
    tooltip.className = 'fixed bg-gray-900 text-white px-3 py-2 rounded-lg text-sm z-50 pointer-events-none';
    tooltip.textContent = text;
    
    // Add arrow
    tooltip.innerHTML += '<div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>';
    
    return tooltip;
}

/**
 * Initialize form validation
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(this)) {
                event.preventDefault();
                return false;
            }
        });
        
        // Real-time validation on input
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            // Clear error on input
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

/**
 * Validate entire form
 */
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Special validation for passwords match
    const password = form.querySelector('input[name="password"]');
    const confirmPassword = form.querySelector('input[name="confirm_password"]');
    
    if (password && confirmPassword && password.value !== confirmPassword.value) {
        showFieldError(confirmPassword, 'Passwords do not match');
        isValid = false;
    }
    
    // Validate email format
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        if (field.value && !isValidEmail(field.value)) {
            showFieldError(field, 'Please enter a valid email address');
            isValid = false;
        }
    });
    
    return isValid;
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Check if required field is empty
    if (field.required && !value) {
        errorMessage = field.getAttribute('data-error-required') || 'This field is required';
        isValid = false;
    }
    
    // Check min length
    const minLength = field.getAttribute('minlength');
    if (minLength && value.length < parseInt(minLength)) {
        errorMessage = field.getAttribute('data-error-minlength') || `Minimum ${minLength} characters required`;
        isValid = false;
    }
    
    // Check max length
    const maxLength = field.getAttribute('maxlength');
    if (maxLength && value.length > parseInt(maxLength)) {
        errorMessage = field.getAttribute('data-error-maxlength') || `Maximum ${maxLength} characters allowed`;
        isValid = false;
    }
    
    // Check pattern
    const pattern = field.getAttribute('pattern');
    if (pattern && value) {
        const regex = new RegExp(pattern);
        if (!regex.test(value)) {
            errorMessage = field.getAttribute('data-error-pattern') || 'Invalid format';
            isValid = false;
        }
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'mt-1 text-sm text-red-600 flex items-center';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
    
    const parent = field.closest('.form-group') || field.parentElement;
    parent.appendChild(errorDiv);
    
    field._errorDiv = errorDiv;
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
    
    if (field._errorDiv) {
        field._errorDiv.remove();
        delete field._errorDiv;
    }
}

/**
 * Check if email is valid
 */
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Initialize modals
 */
function initModals() {
    // Modal triggers
    const modalTriggers = document.querySelectorAll('[data-modal-toggle]');
    
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            
            if (modal) {
                showModal(modal);
            }
        });
    });
    
    // Modal close buttons
    const closeButtons = document.querySelectorAll('[data-modal-hide]');
    
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            
            if (modal) {
                hideModal(modal);
            }
        });
    });
    
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            hideModal(event.target);
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const openModal = document.querySelector('.modal-overlay:not(.hidden)');
            if (openModal) {
                hideModal(openModal);
            }
        }
    });
}

/**
 * Show modal
 */
function showModal(modal) {
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focus on first input in modal
    const input = modal.querySelector('input, select, textarea');
    if (input) {
        setTimeout(() => input.focus(), 100);
    }
}

/**
 * Hide modal
 */
function hideModal(modal) {
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

/**
 * Initialize dropdowns
 */
function initDropdowns() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const dropdown = this.nextElementSibling;
            if (dropdown && dropdown.classList.contains('dropdown-menu')) {
                dropdown.classList.toggle('hidden');
                
                // Close other dropdowns
                document.querySelectorAll('.dropdown-menu:not(.hidden)').forEach(other => {
                    if (other !== dropdown) {
                        other.classList.add('hidden');
                    }
                });
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu:not(.hidden)').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    });
}

/**
 * Initialize tabs
 */
function initTabs() {
    const tabGroups = document.querySelectorAll('.tab-group');
    
    tabGroups.forEach(group => {
        const tabs = group.querySelectorAll('[data-tab]');
        const tabContents = group.querySelectorAll('[data-tab-content]');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Update active tab
                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.classList.remove('border-blue-600', 'text-blue-600');
                    t.classList.add('text-gray-600', 'hover:text-gray-800');
                });
                
                this.classList.add('active', 'border-blue-600', 'text-blue-600');
                this.classList.remove('text-gray-600', 'hover:text-gray-800');
                
                // Show corresponding content
                tabContents.forEach(content => {
                    if (content.getAttribute('data-tab-content') === tabId) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
            });
        });
    });
}

/**
 * Initialize accordions
 */
function initAccordions() {
    const accordionToggles = document.querySelectorAll('[data-accordion-toggle]');
    
    accordionToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const accordionId = this.getAttribute('data-accordion-toggle');
            const accordionContent = document.getElementById(accordionId);
            const icon = this.querySelector('i');
            
            if (accordionContent) {
                accordionContent.classList.toggle('hidden');
                
                // Toggle icon
                if (icon) {
                    if (accordionContent.classList.contains('hidden')) {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    } else {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                }
            }
        });
    });
}

/**
 * Initialize file uploads with preview
 */
function initFileUploads() {
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const previewId = this.getAttribute('data-preview');
            const previewElement = document.getElementById(previewId);
            
            if (previewElement && this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        previewElement.innerHTML = `<img src="${e.target.result}" class="max-w-full h-auto rounded" alt="Preview">`;
                    } else {
                        const icon = getFileIcon(file.name);
                        previewElement.innerHTML = `
                            <div class="flex items-center p-4 bg-gray-100 rounded-lg">
                                <i class="${icon} text-3xl mr-4"></i>
                                <div>
                                    <p class="font-medium">${file.name}</p>
                                    <p class="text-sm text-gray-600">${formatFileSize(file.size)}</p>
                                </div>
                            </div>
                        `;
                    }
                };
                
                reader.readAsDataURL(file);
            }
        });
    });
}

/**
 * Get file icon class based on file extension
 */
function getFileIcon(filename) {
    const extension = filename.split('.').pop().toLowerCase();
    
    const icons = {
        pdf: 'fas fa-file-pdf text-red-500',
        doc: 'fas fa-file-word text-blue-500',
        docx: 'fas fa-file-word text-blue-500',
        jpg: 'fas fa-file-image text-green-500',
        jpeg: 'fas fa-file-image text-green-500',
        png: 'fas fa-file-image text-green-500',
        gif: 'fas fa-file-image text-green-500',
        txt: 'fas fa-file-alt text-gray-500',
        csv: 'fas fa-file-csv text-green-500',
        xls: 'fas fa-file-excel text-green-500',
        xlsx: 'fas fa-file-excel text-green-500'
    };
    
    return icons[extension] || 'fas fa-file text-gray-500';
}

/**
 * Format file size
 */
function formatFileSize(bytes) {
    if (bytes >= 1073741824) {
        return (bytes / 1073741824).toFixed(2) + ' GB';
    } else if (bytes >= 1048576) {
        return (bytes / 1048576).toFixed(2) + ' MB';
    } else if (bytes >= 1024) {
        return (bytes / 1024).toFixed(2) + ' KB';
    } else {
        return bytes + ' bytes';
    }
}

/**
 * Initialize date pickers
 */
function initDatePickers() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        // Set min date to today for future dates
        if (input.hasAttribute('min-today')) {
            const today = new Date().toISOString().split('T')[0];
            input.setAttribute('min', today);
        }
        
        // Set max date to today for past dates
        if (input.hasAttribute('max-today')) {
            const today = new Date().toISOString().split('T')[0];
            input.setAttribute('max', today);
        }
    });
}

/**
 * Initialize password toggle
 */
function initPasswordToggle() {
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.setAttribute('title', 'Hide password');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.setAttribute('title', 'Show password');
            }
        });
    });
}

/**
 * Initialize notifications
 */
function initNotifications() {
    // Check for new notifications
    if (window.userId) {
        checkNotifications();
        
        // Poll for new notifications every 30 seconds
        setInterval(checkNotifications, 30000);
    }
}

/**
 * Check for new notifications
 */
function checkNotifications() {
    fetch('/api/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            if (data.count > 0) {
                updateNotificationBadge(data.count);
            }
        })
        .catch(error => console.error('Error checking notifications:', error));
}

/**
 * Update notification badge
 */
function updateNotificationBadge(count) {
    const badge = document.getElementById('notification-badge');
    const icon = document.querySelector('[data-notification-icon]');
    
    if (badge) {
        badge.textContent = count;
        badge.classList.remove('hidden');
    }
    
    if (icon && count > 0) {
        // Add animation to notification icon
        icon.classList.add('animate-pulse');
    }
}

/**
 * Show notification
 */
function showNotification(message, type = 'info', duration = 5000) {
    // Create notification container if it doesn't exist
    let container = document.getElementById('notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(container);
    }
    
    const notification = document.createElement('div');
    notification.className = `notification transform transition-all duration-300 translate-x-full`;
    
    const typeClasses = {
        success: 'bg-green-100 border-green-400 text-green-700',
        error: 'bg-red-100 border-red-400 text-red-700',
        warning: 'bg-yellow-100 border-yellow-400 text-yellow-700',
        info: 'bg-blue-100 border-blue-400 text-blue-700'
    };
    
    notification.innerHTML = `
        <div class="rounded-lg border px-4 py-3 ${typeClasses[type] || typeClasses.info}">
            <div class="flex items-center">
                <i class="fas ${getNotificationIcon(type)} mr-3"></i>
                <span>${message}</span>
                <button class="ml-4 text-current hover:text-opacity-75" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 10);
    
    // Auto-remove after duration
    if (duration > 0) {
        setTimeout(() => {
            notification.remove();
        }, duration);
    }
    
    return notification;
}

/**
 * Get notification icon based on type
 */
function getNotificationIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    return icons[type] || 'fa-info-circle';
}

/**
 * Copy text to clipboard
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => {
            showNotification('Copied to clipboard', 'success');
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
            showNotification('Failed to copy to clipboard', 'error');
        });
}

/**
 * Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle function
 */
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/**
 * Format date
 */
function formatDate(date, format = 'MMM dd, yyyy') {
    const d = new Date(date);
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    return d.toLocaleDateString('en-US', options);
}

/**
 * Time ago function
 */
function timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    
    let interval = Math.floor(seconds / 31536000);
    if (interval > 1) return interval + ' years ago';
    if (interval === 1) return 'a year ago';
    
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) return interval + ' months ago';
    if (interval === 1) return 'a month ago';
    
    interval = Math.floor(seconds / 86400);
    if (interval > 1) return interval + ' days ago';
    if (interval === 1) return 'a day ago';
    
    interval = Math.floor(seconds / 3600);
    if (interval > 1) return interval + ' hours ago';
    if (interval === 1) return 'an hour ago';
    
    interval = Math.floor(seconds / 60);
    if (interval > 1) return interval + ' minutes ago';
    if (interval === 1) return 'a minute ago';
    
    return 'just now';
}

/**
 * Toggle favorite
 */
function toggleFavorite(element, itemId, itemType) {
    const isFavorite = element.classList.contains('text-red-500');
    
    fetch('/api/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            item_id: itemId,
            item_type: itemType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (isFavorite) {
                element.classList.remove('text-red-500');
                element.classList.add('text-gray-500');
                element.setAttribute('title', 'Add to favorites');
            } else {
                element.classList.remove('text-gray-500');
                element.classList.add('text-red-500');
                element.setAttribute('title', 'Remove from favorites');
            }
        } else {
            showNotification('Failed to update favorites', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to update favorites', 'error');
    });
}

/**
 * Share content
 */
function shareContent(url, title, text) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: text,
            url: url
        })
        .then(() => showNotification('Shared successfully', 'success'))
        .catch(error => console.error('Error sharing:', error));
    } else {
        // Fallback to copying URL
        copyToClipboard(url);
    }
}

/**
 * Print page
 */
function printPage() {
    window.print();
}

/**
 * Scroll to top
 */
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

/**
 * Show/hide scroll to top button
 */
window.addEventListener('scroll', function() {
    const scrollButton = document.getElementById('scroll-to-top');
    if (scrollButton) {
        if (window.pageYOffset > 300) {
            scrollButton.classList.remove('hidden');
        } else {
            scrollButton.classList.add('hidden');
        }
    }
});

/**
 * Initialize scroll to top button
 */
function initScrollToTop() {
    const button = document.createElement('button');
    button.id = 'scroll-to-top';
    button.className = 'fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 hidden z-40';
    button.innerHTML = '<i class="fas fa-chevron-up"></i>';
    button.onclick = scrollToTop;
    document.body.appendChild(button);
}

/**
 * Dark mode toggle
 */
function initDarkMode() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
    
    if (darkModeToggle) {
        // Check for saved theme or use preferred scheme
        const currentTheme = localStorage.getItem('theme');
        
        if (currentTheme === 'dark' || (!currentTheme && prefersDarkScheme.matches)) {
            document.documentElement.classList.add('dark');
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            document.documentElement.classList.remove('dark');
            darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }
        
        darkModeToggle.addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                this.innerHTML = '<i class="fas fa-moon"></i>';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                this.innerHTML = '<i class="fas fa-sun"></i>';
            }
        });
    }
}

/**
 * Load more content (infinite scroll)
 */
function initInfiniteScroll(containerSelector, loadUrl, params = {}) {
    const container = document.querySelector(containerSelector);
    if (!container) return;
    
    let loading = false;
    let page = 2; // Start from page 2 since page 1 is already loaded
    let hasMore = true;
    
    function loadMore() {
        if (loading || !hasMore) return;
        
        loading = true;
        
        // Show loading indicator
        const loader = document.createElement('div');
        loader.className = 'loading text-center py-8';
        loader.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl text-blue-600"></i>';
        container.appendChild(loader);
        
        // Build query string
        const queryParams = new URLSearchParams({
            page: page,
            ...params
        });
        
        fetch(`${loadUrl}?${queryParams}`)
            .then(response => response.json())
            .then(data => {
                // Remove loader
                loader.remove();
                
                if (data.success && data.html) {
                    // Append new content
                    const temp = document.createElement('div');
                    temp.innerHTML = data.html;
                    container.appendChild(temp);
                    
                    // Update page and hasMore
                    page++;
                    hasMore = data.has_more;
                    
                    // Reinitialize any components in new content
                    initializeComponentsInElement(temp);
                } else {
                    hasMore = false;
                }
                
                loading = false;
            })
            .catch(error => {
                console.error('Error loading more content:', error);
                loader.remove();
                loading = false;
            });
    }
    
    // Detect when user scrolls to bottom
    window.addEventListener('scroll', debounce(() => {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
            loadMore();
        }
    }, 100));
}

/**
 * Initialize components in specific element
 */
function initializeComponentsInElement(element) {
    // Reinitialize tooltips in new content
    const tooltips = element.querySelectorAll('[data-tooltip]');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function(e) {
            // Tooltip initialization logic here
        });
    });
    
    // Reinitialize other components as needed
}

/**
 * Search functionality
 */
function initSearch() {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    
    if (!searchInput || !searchResults) return;
    
    let searchTimeout;
    
    searchInput.addEventListener('input', debounce(function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }
        
        fetch(`/api/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.results.length > 0) {
                    searchResults.innerHTML = data.results.map(result => `
                        <a href="${result.url}" class="block p-3 hover:bg-gray-100">
                            <div class="font-medium">${result.title}</div>
                            <div class="text-sm text-gray-600">${result.description}</div>
                        </a>
                    `).join('');
                    searchResults.classList.remove('hidden');
                } else {
                    searchResults.innerHTML = '<div class="p-4 text-gray-500 text-center">No results found</div>';
                    searchResults.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                searchResults.classList.add('hidden');
            });
    }, 300));
    
    // Hide results when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.classList.add('hidden');
        }
    });
}

/**
 * Initialize all on DOMContentLoaded
 */
document.addEventListener('DOMContentLoaded', function() {
    initializeComponents();
    setupEventListeners();
    checkUserSession();
    initScrollToTop();
    initDarkMode();
    initSearch();
});

/**
 * Global error handler
 */
window.addEventListener('error', function(event) {
    console.error('Global error:', event.error);
    
    // Show user-friendly error message
    if (event.error instanceof Error) {
        showNotification('An error occurred: ' + event.error.message, 'error');
    }
});

/**
 * Unhandled promise rejection handler
 */
window.addEventListener('unhandledrejection', function(event) {
    console.error('Unhandled promise rejection:', event.reason);
    showNotification('An unexpected error occurred', 'error');
});

// Export functions for use in other modules
window.Airigojobs = {
    showNotification,
    copyToClipboard,
    formatDate,
    timeAgo,
    toggleFavorite,
    shareContent,
    printPage,
    scrollToTop,
    debounce,
    throttle
};